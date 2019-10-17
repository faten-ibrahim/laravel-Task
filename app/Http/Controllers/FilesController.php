<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
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
        return $this->storeFilesIntoStorage($request);
    }

    public function removeFiles(Request $request)
    {
        $filename = $request->name;
        // $filename=preg_replace('/^[^-]*-/', '', $filename);
        File::where('name', $filename)->delete();
        $file_path = $this->photos_path . '/' . $filename;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        return Response::json(['message' => 'File successfully delete'], 200);
    }

    public function getFiles(Request $request)
    {
        return response()->json(News::find($request->id)->files->pluck('name','id'));
    }
}
