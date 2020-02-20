<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29/12/2018
 * Time: 2:04 PM
 */

namespace App\Services;
use Image;
use Storage;



class FileAssetManagerService
{
    /**
     * Store the image
     * @param $image
     * @param $location
     * @param null $width
     * @param null $height
     * @return mixed
     */
    public static function ImageStore($image,$location, $width = null, $height = null)
    {
        $uploaded_image = Storage::disk('local')->put($location, $image);

        if (!empty($width)){
            $img = Image::make('storage'.DIRECTORY_SEPARATOR.$uploaded_image);
            $img->resize($width, !empty($height) ? $height : null, function ($constraint) {
            $constraint->aspectRatio();
            })->save('storage'.DIRECTORY_SEPARATOR.$uploaded_image);
        }
        return $uploaded_image;
    }

    public  static function ImageDestroy($image)
    {
        if (!empty ( $image )) {
            $oldImage = $image;
            Storage::delete($oldImage);
        }
    }
}