<?php

namespace App\Http\Controllers\Adminpanel;

use App\Models\Achivements;
use Illuminate\Http\Request;
use App\Events\LoggableEvent;
use App\Helpers\StorageHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIResponseMessage;
use App\Http\Controllers\Controller;
use Exception;


use Yajra\DataTables\Facades\DataTables;

class AchivementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.achivements.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.achivements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'front_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        DB::beginTransaction();

        $frontImage = null;
        if ($request->hasFile('front_image')) {
            $extension = $request->file('front_image')->extension();
            $frontImage = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $extension;
            (new StorageHelper('achivementimage', $frontImage, $request->file('front_image')))->uploadImage();
        }

        $gallery_images = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $extension = $image->extension();
                $imageName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $extension;
                (new StorageHelper('achivementimage', $imageName, $image))->uploadImage();
                $gallery_images[] = $imageName;
            }
        }

        $achivement = new Achivements();
        $achivement->title = $request->title;
        $achivement->body = $request->body;
        $achivement->front_image = $frontImage;
        $achivement->gallery_images = json_encode($gallery_images);
        $achivement->save();

        DB::commit();

        return redirect()->route('achivements.achivements')->with('success', 'Achievement created successfully!');

    } catch (Exception $e) {
        DB::rollBack();

        \Log::error('Achievement store error: ' . $e->getMessage());

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create achievement. Please try again.');
    }
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $achivementId = decrypt($id);
        $achivement = Achivements::findOrFail($achivementId);

        return view('admin.achivements.edit',[
            'achivement' => $achivement,
            'id' => $id,
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
    {
        $achivement = Achivements::findOrFail(decrypt($id));

        $request->validate([
            'title' => 'required|string|max:255',
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Fixed: nullable for updates, fixed typo 'miimes'
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'body' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Handle front image - keep existing if no new one uploaded
            $frontImage = $achivement->front_image; // Keep existing image
            if ($request->hasFile('front_image')) {
                // Delete old image if exists
                if ($achivement->front_image) {
                    Storage::delete('achivementimage/' . $achivement->front_image);
                }

                $extension = $request->file('front_image')->extension();
                $frontImage = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $extension;
                (new StorageHelper('achivementimage', $frontImage, $request->file('front_image')))->uploadImage();
            }

            // Handle gallery images - merge with existing
            $existingGalleryImages = $achivement->gallery_images ?? [];
            $newGalleryImages = [];

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $extension = $image->extension();
                    $imageName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $extension;
                    (new StorageHelper('achivementimage', $imageName, $image))->uploadImage();
                    $newGalleryImages[] = $imageName;
                }
            }

            // Merge existing and new gallery images
            $allGalleryImages = array_merge($existingGalleryImages, $newGalleryImages);

            $achivement->update([
                'front_image' => $frontImage,
                'gallery_images' => $allGalleryImages,
                'title' => $request->title, // Fixed: was 'topic'
                'body' => $request->body,   // Fixed: was 'description'
            ]);

            DB::commit();

            // Fixed: Check if LoggableEvent exists and is properly imported
            if (class_exists('App\Events\LoggableEvent')) {
                event(new LoggableEvent($achivement, 'updated'));
            }

            return redirect()->route('achivements.achivements')->with('success', APIResponseMessage::UPDATED);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Achievement update failed: ' . $e->getMessage());
            return redirect()->route('achivements.achivements')->with('error', APIResponseMessage::FAIL);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();

            $achivement = Achivements::find($id);

            if(!$achivement){
                return redirect()->route('achivements.achivements')->with('error', 'Event not found');
            }

            $achivement->delete();

            DB::commit();

            Achivements::dispatch(new LoggableEvent($achivement,'deleted'));
            return redirect()->route('achivements.achivements')->with('success', APIResponseMessage::DELETED);
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('achivements.achivements')->with('error', APIResponseMessage::FAIL);
        }
    }

   public function getAjaxAchievementData()
{
    try {
        $model = Achivements::query()->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('title', function($achievement) {
                return $achievement->title;
            })
            ->addColumn('edit', function($achievement) {
                $edit_url = route('achivements.show-achivements', encrypt($achievement->id));
                return '<a href="' . $edit_url . '" class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200">
                            <i class="fas fa-edit text-sm"></i>
                        </a>';
            })
            ->addColumn('activation', function($achievement) {
                return view('admin.achivements.partials._status', compact('achievement'))->render();
            })
            ->addColumn('delete', function($achievement) {
                return view('admin.achivements.partials._delete', compact('achievement'))->render();
            })
            ->rawColumns(['edit', 'activation', 'delete']) // Allow HTML in these columns
            ->make(true);
    } catch (Exception $e) {
        \Log::error('Achievement DataTable Error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to load achievements data'], 500);
    }
}


public function activation(Request $request)
{
    $achivement = Achivements::find($request->id);

    if(!$achivement){
        return redirect()->route('achivements.achivements')->with('error','Event not found');
    }

    $achivement->status = $achivement->status === 'Y' ? 'N' : 'Y';
    $achivement->save();

    event(new LoggableEvent($achivement,'statuschange' ));

    return redirect()->route('achivements.achivements')->with('success', $achivement->status === 'Y' ? 'Record activated successfully.' : 'Record deactivated successfully.');
}
}
