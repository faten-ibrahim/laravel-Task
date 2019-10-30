<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\File;
use App\Folder;
use App\News;
use Illuminate\Support\Facades\Response;
use  App\Traits\ImageUploadTrait;

class FilesController extends Controller
{
    use ImageUploadTrait;
    private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('/uploads/news/');
    }

    public function storeFiles(Request $request)
    {
        if ($request->path) {
            return $this->storeFilesIntoStorage($request, $request->path);
        } else {
            return $this->storeFilesIntoStorage($request);
        }
    }

    public function removeFiles(Request $request)
    {
        $filename = $request->name;
        // $filename=preg_replace('/^[^-]*-/', '', $filename);
        File::where('name', $filename)->delete();
        if ($request->path) {
            $file_path =  public_path($request->path) . '/' . $filename;
        } else {
            $file_path = $this->photos_path . '/' . $filename;
        }

        if (file_exists($file_path)) {
            unlink($file_path);
        }
        return Response::json(['message' => 'File successfully delete'], 200);
    }

    public function getFiles(Request $request)
    {
        if ($request->model == 'news') {
            return response()->json(News::find($request->id)->files()->pluck('name', 'id'));
        } else {
            return response()->json(Event::find($request->id)->files()->pluck('name', 'id'));
        }
    }
}
