<?php

namespace App\Traits;

use App\Upload;
use JD\Cloudder\Facades\Cloudder as Cloudder;
use App\Http\Requests\StoreStaffMemberRequest;
use App\Http\Requests\UpdateStaffMemberRequest;
use Illuminate\Http\Request;
trait ImageUploadTrait
{

    public function uploadImages($image, $name, $image_name)
    {
        Cloudder::upload($image_name);
        list($width, $height) = getimagesize($image_name); // filesize($image_name);//$image_name->getSize();
        $image_url = Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height" => $height]);
        //save to uploads directory
        $image->move(public_path("uploads"), $name);

        return $image_url;
    }

    public function saveImages(Request $request, $image_url, $user_id)
    {
        $image = new Upload();
        $image->user_id = $user_id;
        $image->image_name = $request->file('image_name')->getClientOriginalName();
        $image->image_url = $image_url;
        $image->save();
    }

    public function get_image_url($request)
    {
        if ($request->hasFile('image_name') && $request->file('image_name')->isValid()) {
            $image = $request->file('image_name');
            $name = $request->file('image_name')->getClientOriginalName();
            $image_name = $request->file('image_name')->getRealPath();
            $image_url = $this->uploadImages($image, $name, $image_name);

            return $image_url;
        }

        return 0;
    }
}
