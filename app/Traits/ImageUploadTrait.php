<?php

namespace App\Traits;

use App\File;
use App\Upload;
use JD\Cloudder\Facades\Cloudder as Cloudder;
use Illuminate\Http\Request;

trait ImageUploadTrait
{

    // public function uploadImagesToClouder($image, $name, $imageName)
    // {
    //     Cloudder::upload($imageName);
    //     list($width, $height) = getimagesize($imageName); // filesize($image_name);//$image_name->getSize();
    //     Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
    //     //save to uploads directory
    //     $image->move(public_path("uploads"), $name);

    //     return $this;
    // }


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

        return response()->json([
            'name' => $name,
            'mimeType' => $file->getClientOriginalExtension(),
        ]);
    }

    // To store staff or visitor image
    public function storeImageIntoDatabase(Request $request, $staff, $type)
    {
        $data = $this->storeImageIntoStorage($request->file('image_name'), $type);

        $fileData = explode("$", $data);
        // dd($fileData);
        $staff->files()->create([
            'name' => $fileData[0],
            'mime_type' => $fileData[1],
        ]);
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
        //    dd($request->all());
        if ($request->document) {
            $news->files()->delete();
            foreach ($request->document as $file) {
                $fileData = explode("$", $file);
                // dd($fileData);
                $news->files()->create([
                    'name' => $fileData[0],
                    'mime_type' => $fileData[1],
                ]);
            }
        }
    }

    // public function saveImages(Request $request, $imageUrl, $userId)
    // {
    //     $image = new Upload();
    //     $image->user_id = $userId;
    //     $image->image_name = $request->file('image_name')->getClientOriginalName();
    //     $image->image_url = $imageUrl;
    //     $image->save();
    // }

    // public function getImageUrl($request)
    // {
    //     if ($request->hasFile('image_name')) {
    //         $image = $request->file('image_name');
    //         $name = $request->file('image_name')->getClientOriginalName();
    //         $imageName = $request->file('image_name')->getRealPath();
    //         $imageUrl = $this->uploadImagesToClouder($image, $name, $imageName);

    //         return $imageUrl;
    //     }

    //     return '';
    // }
}
