<?php

namespace App\Http\Controllers\Adminpanel;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Events\LoggableEvent;
use App\Helpers\StorageHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Exceptions\Exception;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.gallery.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

         return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         $request->validate([
            'image_name'     => 'required|string|max:255',
            'image'          => 'nullable|image|max:2048',
        ]);


        $imgName = null;

        if ($request->hasFile('image')) {
            $imageExtension = $request->image->extension();
            $imgName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $imageExtension;
            (new StorageHelper('galleryimage', $imgName, $request->image))->uploadImage();
        }

        try {
            DB::beginTransaction();

            $gallery = new Gallery();
            $gallery->image_name = $request->image_name;
            $gallery->image = $imgName;
            $gallery->created_at = $request->created_at
                ? date('Y-m-d H:i:s', strtotime($request->created_at))
                : now();

            $gallery->save();

            DB::commit();
            Event::dispatch(new LoggableEvent($gallery, 'created'));

            return redirect()->route('gallery.gallery')->with('success', APIResponseMessage::CREATED);
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('gallery.gallery')->with('error', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $galleryId = decrypt($id);
        $gallery = Gallery::findOrFail($galleryId);

        return view('admin.gallery.edit', [
            'gallery' => $gallery,
            'id' => $id,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $gallery = Gallery::findOrFail(decrypt($id));

        $request->validate([
            'image_name'     => 'required|string|max:255',
            'image'          => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
            $imageExtension = $request->image->extension();
            $imgName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $imageExtension;
            (new StorageHelper('galleryimage', $imgName, $request->image))->uploadImage();
            $gallery->image = $imgName;
          }



            $gallery->image_name = $request->image_name;


            $gallery->save();

            DB::commit();
            Event::dispatch(new LoggableEvent($gallery, 'updated'));

            return redirect()->route('gallery.gallery')->with('success', 'Gallery updated successfully.');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('gallery.gallery')->with('error', 'Failed to update gallery.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         try {
            DB::beginTransaction();

            $gallery = Gallery::find($id);

            if (!$gallery) {
                return redirect()->route('gallery.gallery')->with('error', 'Gallery not found.');
            }

            $gallery->delete();

            DB::commit();
            Event::dispatch(new LoggableEvent($gallery, 'deleted'));

            return redirect()->route('gallery.gallery')->with('success', APIResponseMessage::DELETED);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('gallery.gallery')->with('error', APIResponseMessage::FAIL);
        }
    }


      /**
     * Get members data for DataTables.
     */
    public function getAjaxGalleryData()
    {
        try {
            $model = Gallery::query()->orderBy('id', 'desc');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->editColumn('name', function ($gallery) {
                    return $gallery->image_name;
                })
                ->addColumn('edit', function ($gallery) {
                    $edit_url = route('gallery.show-gallery', encrypt($gallery->id));
                    return '<a href="' . $edit_url . '"><i class="fas fa-edit"></i></a>';
                })
                ->addColumn('activation', function ($gallery) {
                    return view('admin.gallery.partials._status', compact('gallery'))->render();
                })
                ->addColumn('delete', function ($gallery) {
                    return view('admin.gallery.partials._delete', compact('gallery'))->render();
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
        $gallery = Gallery::find($request->id);

        if (!$gallery) {
            return redirect()->route('gallery.gallery')->with('error', 'Gallery not found.');
        }

        $gallery->status = $gallery->status === 'Y' ? 'N' : 'Y';
        $gallery->save();

        Event::dispatch(new LoggableEvent($gallery, 'statuschange'));

        return redirect()->route('gallery.gallery')->with(
            'success',
            $gallery->status === 'Y' ? 'Record activated successfully.' : 'Record deactivated successfully.'
        );
    }
}
