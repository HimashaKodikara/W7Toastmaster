<?php

namespace App\Http\Controllers\Adminpanel;

use App\Models\Events;
use Illuminate\Http\Request;
use App\Events\LoggableEvent;
use App\Helpers\StorageHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Yajra\DataTables\Facades\DataTables;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('admin.events.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'main_image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'gallery_images'   => 'nullable|array',
        'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'topic'            => 'required|string|max:255',
        'description'      => 'nullable|string',
    ]);

    try {
        DB::beginTransaction();

        // Upload main image
        $mainImageName = null;
        if ($request->hasFile('main_image')) {
            $extension = $request->file('main_image')->extension();
            $mainImageName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $extension;
            (new StorageHelper('eventsimage', $mainImageName, $request->file('main_image')))
                ->uploadImage();
        }

        // Upload gallery images
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $extension = $image->extension();
                $imageName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $extension;
                (new StorageHelper('eventsimage', $imageName, $image))->uploadImage();
                $galleryImages[] = $imageName;
            }
        }

        // Create event
        $event = new Events();
        $event->main_image     = $mainImageName;
        $event->gallery_images = $galleryImages;
        $event->topic          = $request->topic;
        $event->description    = $request->description;
        $event->save();

        DB::commit();

        event(new LoggableEvent($event, 'created'));

        return redirect()->route('event.event')->with('success', APIResponseMessage::CREATED);

    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->route('event.event')
            ->with('error', APIResponseMessage::FAIL);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $eventId = decrypt($id);
        $event = Events::findOrFail($eventId);

        return view('admin.events.edit', [
            'event' => $event,
            'id' => $id,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    $event = Events::findOrFail(decrypt($id));

    $request->validate([
        'main_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'gallery_images'   => 'nullable|array',
        'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'topic'            => 'required|string|max:255',
        'description'      => 'nullable|string',
    ]);

    try {
        DB::beginTransaction();

        // Keep existing image if no new file uploaded
        $mainImageName = $event->main_image;
        if ($request->hasFile('main_image')) {
            $extension = $request->file('main_image')->extension();
            $mainImageName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $extension;
            (new StorageHelper('eventsimage', $mainImageName, $request->file('main_image')))
                ->uploadImage();
        }

        // Merge new gallery images with existing ones
        $galleryImages = $event->gallery_images ?? [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $extension = $image->extension();
                $imageName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $extension;
                (new StorageHelper('eventsimage', $imageName, $image))->uploadImage();
                $galleryImages[] = $imageName;
            }
        }

        $event->update([
            'main_image'     => $mainImageName,
            'gallery_images' => $galleryImages,
            'topic'          => $request->topic,
            'description'    => $request->description,
        ]);

        DB::commit();
        Event::dispatch(new LoggableEvent($event, 'updated'));

        return redirect()->route('event.event')->with('success', APIResponseMessage::UPDATED);
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->route('event.event')->with('error', APIResponseMessage::FAIL);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();

            $event = Events::find($id);

            if(!$event){
                return redirect()->route('event.event')->with('error','Event Not found');
            }

            $event->delete();

            DB::commit();
            Event::dispatch(new LoggableEvent($event, 'deleted'));

            return redirect()->route('event.event')->with('success','Event deleted successfully');
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('event.event')->with('error','An error occurred while deleting the event');
        }
    }

      public function getAjaxEventData()
    {
        try {
            $model = Events::query()->orderBy('id', 'desc');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->editColumn('topic', function ($event) {
                    return $event->topic;
                })
                ->addColumn('edit', function ($event) {
                    $edit_url = route('event.show-event', encrypt($event->id));
                    return '<a href="' . $edit_url . '"><i class="fas fa-edit"></i></a>';
                })
                ->addColumn('activation', function ($event) {
                    return view('admin.events.partials._status', compact('event'))->render();
                })
                ->addColumn('delete', function ($event) {
                    return view('admin.events.partials._delete', compact('event'))->render();
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
        $event = Events::find($request->id);

        if (!$event) {
            return redirect()->route('event.event')->with('error', 'Event not found.');
        }

        $event->status = $event->status === 'Y' ? 'N' : 'Y';
        $event->save();

        Event::dispatch(new LoggableEvent($event, 'statuschange'));

        return redirect()->route('event.event')->with(
            'success',
            $event->status === 'Y' ? 'Record activated successfully.' : 'Record deactivated successfully.'
        );
    }

}
