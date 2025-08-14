<?php

namespace App\Http\Controllers\Adminpanel;

use Exception;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Events\LoggableEvent;
use App\Helpers\StorageHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Yajra\DataTables\Facades\DataTables;

class MemeberController extends Controller
{
    /**
     * Display a listing of members.
     */
    public function index()
    {
        return view('admin.members.list');
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'           => 'required|string|max:255',
            'testimonial'    => 'required|string',
            'linkedin_link'  => 'nullable|url|max:255',
            'instergram_link'=> 'nullable|url|max:255',
            'image'          => 'nullable|image|max:2048',
        ]);


        $imgName = null;

        if ($request->hasFile('image')) {
            $imageExtension = $request->image->extension();
            $imgName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $imageExtension;
            (new StorageHelper('membersimage', $imgName, $request->image))->uploadImage();
        }

        try {
            DB::beginTransaction();

            $member = new Member();
            $member->name = $request->name;
            $member->testimonial = $request->testimonial;
            $member->linkedin_link = $request->linkedin_link;
            $member->instergram_link = $request->instergram_link;
            $member->image = $imgName;
            $member->created_at = $request->created_at
                ? date('Y-m-d H:i:s', strtotime($request->created_at))
                : now();

            $member->save();

            DB::commit();
            Event::dispatch(new LoggableEvent($member, 'created'));

            return redirect()->route('member.member')->with('success', APIResponseMessage::CREATED);
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('member.member')->with('error', APIResponseMessage::FAIL);
        }
    }

    /**
     * Show the form for editing the specified member.
     */
    public function show(string $id)
    {
        $memberId = decrypt($id);
        $member = Member::findOrFail($memberId);

        return view('admin.members.edit', [
            'member' => $member,
            'id' => $id,
        ]);
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, string $id)
    {

        $member = Member::findOrFail(decrypt($id));

        $request->validate([
            'name'           => 'required|string|max:255',
            'testimonial'    => 'required|string',
            'linkedin_link'  => 'nullable|url|max:255',
            'instergram_link'=> 'nullable|url|max:255',
            'image'          => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $imageExtension = $request->image->extension();
                $imgName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $imageExtension;
                (new StorageHelper('membersimage', $imgName, $request->image))->uploadImage();
                $member->image = $imgName;
            }

            $member->name = $request->name;
            $member->testimonial = $request->testimonial;
            $member->linkedin_link = $request->linkedin_link;
            $member->instergram_link = $request->instergram_link;

            $member->save();

            DB::commit();
            Event::dispatch(new LoggableEvent($member, 'updated'));

            return redirect()->route('member.member')->with('success', 'Member updated successfully.');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('member.member')->with('error', 'Failed to update member.');
        }
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $member = Member::find($id);

            if (!$member) {
                return redirect()->route('member.member')->with('error', 'Member not found.');
            }

            $member->delete();

            DB::commit();
            Event::dispatch(new LoggableEvent($member, 'deleted'));

            return redirect()->route('member.member')->with('success', APIResponseMessage::DELETED);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('member.member')->with('error', APIResponseMessage::FAIL);
        }
    }

    /**
     * Get members data for DataTables.
     */
    public function getAjaxMembersData()
    {
        try {
            $model = Member::query()->orderBy('id', 'desc');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->editColumn('name', function ($member) {
                    return $member->name;
                })
                ->addColumn('edit', function ($member) {
                    $edit_url = route('member.show-member', encrypt($member->id));
                    return '<a href="' . $edit_url . '"><i class="fas fa-edit"></i></a>';
                })
                ->addColumn('activation', function ($member) {
                    return view('admin.members.partials._status', compact('member'))->render();
                })
                ->addColumn('delete', function ($member) {
                    return view('admin.members.partials._delete', compact('member'))->render();
                })
                ->rawColumns(['edit', 'activation', 'delete'])
                ->toJson();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Change activation status.
     */
    public function activation(Request $request)
    {
        $member = Member::find($request->id);

        if (!$member) {
            return redirect()->route('member.member')->with('error', 'Member not found.');
        }

        $member->status = $member->status === 'Y' ? 'N' : 'Y';
        $member->save();

        Event::dispatch(new LoggableEvent($member, 'statuschange'));

        return redirect()->route('member.member')->with(
            'success',
            $member->status === 'Y' ? 'Record activated successfully.' : 'Record deactivated successfully.'
        );
    }
}
