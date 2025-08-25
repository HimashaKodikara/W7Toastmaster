<?php

namespace App\Http\Controllers\Adminpanel;

use Exception;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Events\LoggableEvent;
use App\Helpers\StorageHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Yajra\DataTables\Facades\DataTables;

class TestermonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.testimonial.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'name'           => 'required|string|max:255',
            'body'           => 'required|string',
            'image'          => 'nullable|image|max:2048',
        ]);


        $imgName = null;

        if ($request->hasFile('image')) {
            $imageExtension = $request->image->extension();
            $imgName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $imageExtension;
            (new StorageHelper('testimonialimage', $imgName, $request->image))->uploadImage();
        }

        try {
            DB::beginTransaction();

            $testimonial = new Testimonial();
            $testimonial->name = $request->name;
            $testimonial->body = $request->body;
            $testimonial->image = $imgName;
            $testimonial->created_at = $request->created_at
                ? date('Y-m-d H:i:s', strtotime($request->created_at))
                : now();

            $testimonial->save();

            DB::commit();
            Event::dispatch(new LoggableEvent($testimonial, 'created'));

            return redirect()->route('testimonial.testimonial')->with('success', APIResponseMessage::CREATED);
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('testimonial.testimonial')->with('error', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testimonialId = decrypt($id);
        $testimonial = Testimonial::findOrFail($testimonialId);

        return view('admin.testimonial.edit',[
            'testimonial' => $testimonial,
            'id' => $id,
        ]);
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $testimonial = Testimonial::findOrFail(decrypt($id));

         $request->validate([
            'name'           => 'required|string|max:255',
            'body'           => 'required|string',
            'image'          => 'nullable|image|max:2048',
        ]);

        try{

            DB::beginTransaction();

         if ($request->hasFile('image')) {
            $imageExtension = $request->image->extension();
            $imgName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $imageExtension;
            (new StorageHelper('testimonialimage', $imgName, $request->image))->uploadImage();
            $testimonial->image = $imgName;
        }

        $testimonial->name = $request->name;
        $testimonial->body = $request->body;

        $testimonial->save();

        DB::commit();
        Event::dispatch(new LoggableEvent($testimonial, 'updated'));

        return redirect()->route('testimonial.testimonial')->with('success','Testimonials updated successfully');

      }catch(Exception $e){
        DB::rollback();
        return redirect()->route('testimonial.testimonial')->with('error','Failed to update testimonial ');
      }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();

            $testimonial = Testimonial::find($id);

            if(!$testimonial){
                return redirect()->route('testimonial.testimonial')->with('error','Testimonial not found' );
            }

            $testimonial->delete();

            DB::commit();
            Event::dispatch(new LoggableEvent($testimonial,'deleted'));

            return redirect()->route('testimonial.testimonial')->with('success','Testimonial deleted successfully');
        }catch(Exception $e){
            DB::rollback();
            return redirect()->route('testimonial.testimonial')->with('error','Failed to delete testimonial');
        }
    }

   public function getAjaxTestimonialsData()
{
    try {
        $testimonials = Testimonial::query()->orderBy('id', 'desc');

        return DataTables::eloquent($testimonials)
            ->addIndexColumn()
            ->editColumn('name', function($testimonial) {
                return $testimonial->name;
            })
            ->addColumn('edit', function($testimonial) {
                $edit_url = route('testimonial.show-testimonial', encrypt($testimonial->id));
                return '<a href="' . $edit_url . '" class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors duration-200">
                            <i class="fas fa-edit text-sm"></i>
                        </a>';
            })
            ->addColumn('activation', function($testimonial) {
                return view('admin.testimonial.partials._status', compact('testimonial'))->render();
            })
            ->addColumn('delete', function($testimonial) {
                return view('admin.testimonial.partials._delete', compact('testimonial'))->render();
            })
            ->rawColumns(['edit', 'activation', 'delete'])
            ->make(true);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function activation(Request $request)
{
    $testimonial = Testimonial::find($request->id);

    if (!$testimonial) {
        return redirect()->route('testimonial.testimonial')->with('error', 'Testimonial not found');
    }

    $testimonial->status = $testimonial->status === 'Y' ? 'N' : 'Y';
    $testimonial->save();

    event(new LoggableEvent($testimonial, 'status Change'));


    return redirect()->route('testimonial.testimonial')->with(
        'success',
        $testimonial->status === 'Y'
            ? 'Record activated successfully'
            : 'Record deactivated successfully.'
    );
}

}
