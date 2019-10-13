<?php

namespace App\Traits;

use App\File;
use App\Upload;
use JD\Cloudder\Facades\Cloudder as Cloudder;
use Illuminate\Http\Request;

trait ImageUploadTrait
{
    // Upload News files
    public function uploadFile($file, $path, $name)
    {
        $file->move(public_path($path), $name);
    }

    // To store staff or visitor image
    public function storeImageIntoStorage($file, $type)
    {
        $path = '/uploads/visitors/';
        if ($type == "staff") {
            $path = '/uploads/staff/';
        }
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $this->uploadFile($file, $path, $name);
        return array([
            'name' => $name,
            'mimeType' => $file->getClientOriginalExtension(),
        ]);
    }

    // To store staff or visitor image
    public function storeImageIntoDatabase(Request $request, $model, $type)
    {
        if ($request->hasFile('image_name')) {
            $model->file()->delete();
            $fileData = $this->storeImageIntoStorage($request->file('image_name'), $type);
            $model->file()->create([
                'name' => $fileData[0]['name'],
                'mime_type' => $fileData[0]['mimeType'],
            ]);
        }
    }


    // To store news images and files
    public function storeFilesIntoStorage(Request $request)
    {
        $path = '/uploads/news/';
        $file = $request->file('file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $this->uploadFile($file, $path, $name);
       
        return response()->json([
            'name' => $name,
            'mimeType' => $file->getClientOriginalExtension(),
        ]);
    }

    public function storeFilesIntoDatabase(Request $request, $news)
    {
        dd($request->document);
        if ($request->document) {
            $news->files()->delete();
            foreach ($request->document as $file) {
                $fileData = explode("$", $file);
                $news->files()->create([
                    'name' => $fileData[0],
                    'mime_type' => $fileData[1],
                ]);
            }
        }
    }

    // public function storeFileIntoStorage(Request $request, $type)
    // {
    //     $path = '/uploads/news/';
    //     if ($type && $type == "staff") {
    //         $path = '/uploads/staff/';
    //     } elseif ($type && $type == "visitor") {
    //         $path = '/uploads/visitors/';
    //     }
    //     $file = $request->file('file');
    //     $name = uniqid() . '_' . trim($file->getClientOriginalName());
    //     $this->uploadFile($file, $path, $name);

    //     return response()->json([
    //         'name' => $name,
    //         'mimeType' => $file->getClientOriginalExtension(),
    //     ]);
    // }
    
}
