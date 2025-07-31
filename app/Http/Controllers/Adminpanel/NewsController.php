<?php

namespace App\Http\Controllers\Adminpanel;

use Exception;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use App\Events\LoggableEvent;
use App\Helpers\StorageHelper;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.news.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $imgName = null;

        if ($request->image) {
            $imageExtension = $request->image->extension();
            $imgName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $imageExtension;
            $uploadUrl = (new StorageHelper('newsimage', $imgName, $request->image))->uploadImage();
        }

        try {
            DB::beginTransaction();

            $news = new News();
            $news->title = $request->title;
            $news->body = $request->body;
            $news->status = $request->status;
            $news->image = $imgName;
            $news->save();

            DB::commit();
            Event::dispatch(new LoggableEvent($news, 'created'));

            return redirect()->route('news.news')->with('success', APIResponseMessage::CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('news.news')->with('error', APIResponseMessage::FAIL);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $newsId = decrypt($id);
        $news = News::findOrFail($newsId);

        return view('admin.news.edit', [
            'news' => $news,
            'id' => $id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $news = News::findOrFail(decrypt($id));
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::findOrFail(decrypt($id));

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $imageExtension = $request->image->extension();
                $imgName = date('m-d-Y_H-i-s') . '-' . uniqid() . '.' . $imageExtension;
                (new StorageHelper('newsimage', $imgName, $request->image))->uploadImage();
                $news->image = $imgName;
            }

            $news->title = $request->title;
            $news->body = $request->body;
            $news->status = $request->status;
            $news->save();

            DB::commit();
            Event::dispatch(new LoggableEvent($news, 'updated'));

            return redirect()->route('news.news')->with('success', 'News updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('news.news')->with('error', 'Failed to update news.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $news = News::findOrFail(decrypt($id));
            $news->delete();
            Event::dispatch(new LoggableEvent($news, 'deleted'));
            return redirect()->route('news.news')->with('success', 'News deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('news.news')->with('error', 'Failed to delete news.');
        }
    }

    /**
     * AJAX data for DataTables
     */
    public function getAjaxHopitalData()
    {
        $model = News::query()->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('title', fn ($news) => $news->title)
            ->addColumn('edit', function ($news) {
                $edit_url = route('news.show-news', encrypt($news->id));
                return '<a href="' . $edit_url . '"><i class="fal fa-edit"></i></a>';
            })
            ->addColumn('activation', function ($news) {
                return view('admin.news.partials._status', compact('news'));
            })
            ->addColumn('delete', function ($news) {
                return view('admin.news.partials._delete', compact('news'));
            })
            ->rawColumns(['edit', 'activation', 'delete'])
            ->toJson();
    }

    /**
     * Change activation status
     */
    public function activation(Request $request)
    {
        $data = News::findOrFail($request->id);

        if ($data->status == 'active') {
            $data->status = 'inactive';
        } else {
            $data->status = 'active';
        }

        $data->save();
        Event::dispatch(new LoggableEvent($data, 'statuschange'));

        return redirect()->route('news.index')->with('success', 'Record status updated successfully.');
    }
}
