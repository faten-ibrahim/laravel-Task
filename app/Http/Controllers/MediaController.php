<?php

namespace App\Http\Controllers;

use App\File;
use App\FileDescription;
use App\Folder;
use App\Http\Requests\StoreMediaRequest;
use Illuminate\Http\Request;
use  App\Traits\ImageUploadTrait;

class MediaController extends Controller
{
    use ImageUploadTrait;
    public function __construct()
    {
        $this->authorizeResource(File::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMediaRequest $request)
    {
        // dd($request->all());
        if ($request->path) {
            $folder = Folder::find($request->folderId);
            $file = $folder->files()->create(array_merge($request->all(), ['name' => $request->file_name, 'type' => 'video']));
        } else {
            $file = $this->checkFileExistance($request);
        }
        if ($file) {
            $file->description()->create($request->all());
            return redirect()->route('folders.index')->with('status', 'file Added successfully !');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    { }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($folderId, File $file)
    {
        // dd(File::find($media)->fileable()->get('id'));
        // $file=File::find($media);
        // dd($file->fileable->id);
        // $file = File::with('description')->find($file);
        $file->load('description');
        // dd($file);
        // dd($file->description->description);
        if ($file->type == 'image') {
            $route = 'folders.media.images.edit';
        } elseif ($file->type == 'file') {
            $route = 'folders.media.files.edit';
        } elseif ($file->type == 'video') {
            $route = 'folders.media.videos.edit';
        }

        return view($route, compact('folderId', 'file'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMediaRequest $request, File $file)
    {
        if ($request->path) {
            $folder = Folder::find($request->folderId);
            $folder->files()->update(array_merge($request->all(), ['name' => $request->file_name, 'type' => 'video']));
        } else {
            $this->checkFileExistance($request, 'update', $file->id);
        }
        $file->description->update($request->all());
        return redirect()->route('folders.index')->with('status', 'file updated successfully !');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();
        return redirect()->route('folders.index')->with('status', 'file deleted successfully !');
    }
}
