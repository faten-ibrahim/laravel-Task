<?php

namespace App\Traits;

use App\Upload;
use JD\Cloudder\Facades\Cloudder as Cloudder;
use Illuminate\Http\Request;
trait ImageUploadTrait
{

    public function uploadImages($image, $name, $imageName)
    {
        Cloudder::upload($imageName);
        list($width, $height) = getimagesize($imageName); // filesize($image_name);//$image_name->getSize();
        Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        //save to uploads directory
        $image->move(public_path("uploads"), $name);

        return $this;
    }

    public function saveImages(Request $request, $imageUrl, $userId)
    {
        $image = new Upload();
        $image->user_id = $userId;
        $image->image_name = $request->file('image_name')->getClientOriginalName();
        $image->image_url = $imageUrl;
        $image->save();
    }

    public function getImageUrl($request)
    {
        if ($request->hasFile('image_name')) {
            $image = $request->file('image_name');
            $name = $request->file('image_name')->getClientOriginalName();
            $imageName = $request->file('image_name')->getRealPath();
            $imageUrl = $this->uploadImages($image, $name, $imageName);

            return $imageUrl;
        }

        return '';
    }
}
