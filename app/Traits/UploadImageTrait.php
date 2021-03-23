<?php

namespace App\Traits;

trait UploadImageTrait
{

    public function uploadImageAndReturnName($request,$file,$afterName,$path,$defImg){
        if($request->hasFile($file) ){
            $image = $request->file($file);
            $extension=$image->extension();
            $imageName = $afterName.rand(0,9999999).'.'.$extension;
            $image->move(storage_path($path),$imageName);
        }else{
            $imageName = $defImg;
        }
        return $imageName;
    }
}

?>