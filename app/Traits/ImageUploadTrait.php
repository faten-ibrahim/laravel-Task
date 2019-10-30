<?php

namespace App\Traits;

use App\File;
use App\Folder;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

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
    public function storeFilesIntoStorage(Request $request, $path = '')
    {
        $file = $request->file('file');
        // $name  = date('Y-m-d') . '-' . $file->getClientOriginalName();
        $name = $file->getClientOriginalName();
        // $filePath=$file->store($name, 'public');
        if ($path) {
            $file->move(public_path($path), $name);
        } else {
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

    // Store folders Media
    public function storeMedia($file, $path, $folder, $type)
    {
        $name  = date('Y-m-d H:i:s') . '-' . $file->getClientOriginalName();
        $file->move(public_path($path), $name);

        $file = $folder->files()->create([
            'name' =>  $name,
            'type' => $type,
            'mime_type' => $file->getClientOriginalExtension(),
        ]);

        return $file;
    }

    // update folders Media
    public function updateMedia($file, $fileId, $path, $folder, $type)
    {
        $name  = date('Y-m-d H:i:s') . '-' . $file->getClientOriginalName();
        $file->move(public_path($path), $name);
        // dd($folder->files()->where('id',$fileId)->first());
        $folder->files()->where('id', $fileId)->update([
            'name' =>  $name,
            'type' => $type,
            'mime_type' => $file->getClientOriginalExtension(),
        ]);
    }

    public function checkFileExistance(Request $request, $flag = 'store', $fileId = null)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $type = 'image';
        } elseif ($request->hasFile('file')) {
            $file = $request->file('file');
            $type = 'file';
        } elseif ($request->hasFile('video')) {
            $file = $request->file('video');
            $type = 'video';
        }else{
            return ;
        }
        $folder = Folder::find($request->folderId);
        $path = '/uploads/folders/' . $folder->name;
        if ($flag == 'store') {
            return $this->storeMedia($file, $path, $folder, $type);
        } else {
            $this->updateMedia($file, $fileId, $path, $folder, $type);
        }
    }
}
