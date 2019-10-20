<?php

namespace App\Traits;

use App\File;
use Illuminate\Http\Request;

trait ImageUploadTrait
{
    // To store staff or visitor image
    public function storeImage(Request $request, $model, $type = "visitors")
    {
        if ($request->hasFile('image_name')) {
            $file = $request->file('image_name');
            $name  = date('Y-m-d') . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/' . $type), $name);
            $model->file()->create([
                'name' =>  $name,
                'mime_type' => $file->getClientOriginalExtension(),
            ]);
        }
    }

    // To update staff or visitor image
    public function updateImage(Request $request, $model, $type = "visitor")
    {
        if ($request->hasFile('image_name')) {
            $file = $request->file('image_name');
            $name  = date('Y-m-d') . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/' . $type), $name);
            if ($model->file) {
                $model->file()->update([
                    'name' =>  $name,
                    'mime_type' => $file->getClientOriginalExtension(),
                ]);
            } else {
                $model->file()->create([
                    'name' =>  $name,
                    'mime_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }
    }


    // To store news images and files
    public function storeFilesIntoStorage(Request $request ,$path='')
    {
        $file = $request->file('file');
        // $name  = date('Y-m-d') . '-' . $file->getClientOriginalName();
        $name = $file->getClientOriginalName();
        // $filePath=$file->store($name, 'public');
        if($path)
        {
            $file->move(public_path($path), $name);
        }else{
            $file->move(public_path('uploads/news'), $name);
        }
       
        $file = File::create([
            'name' => $name,
            'mime_type' =>  $file->getClientOriginalExtension(),
        ]);
        return response()->json([
            'fileId' => $file->id,
            // 'filePath'=>$filePath
        ]);
    }

    public function storeFilesIntoDatabase(Request $request, $model)
    {
        if ($request->document) {
            $files = File::whereIn('id', $request->document)->get();
            $model->files()->saveMany($files);
        }
    }

}
