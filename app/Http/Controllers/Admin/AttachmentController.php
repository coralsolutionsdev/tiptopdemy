<?php

namespace App\Http\Controllers\Admin;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FileAssetManagerService;


class AttachmentController extends Controller
{
    function imageUpload(Request $request)
    {

        if ($request->hasFile('file')) {
            $file = $request->file;
            $hashids = new Hashids();
            $companyHashId = $hashids->encode(1);
            $fileName = $file->getClientOriginalName();

            if (isset($_SERVER['HTTP_ORIGIN'])) {
                // same-origin requests won't set an origin. If the origin is set, it must be valid.
                if ($_SERVER['HTTP_ORIGIN'] == url('/')) {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                } else {
                    header("HTTP/1.0 403 Origin Denied");
                    return;
                }
            }

            /*
              If your script needs to receive cookies, set images_upload_credentials : true in
              the configuration and enable the following two headers.
            */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');

            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $fileName)) {
                header("HTTP/1.0 500 Invalid file name.");
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $image = $file;
            $location =  'attachments/'.$companyHashId.'/images';
            $path = FileAssetManagerService::ImageStore($image,$location);


            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            $attachmentUrl = url('storage/'.$path);
            $item = [
                'path' =>  $path,
                'url' =>  $attachmentUrl,
            ];
            echo json_encode(array('item' => $item));
        } else {
            // Notify editor that the upload failed
            header("HTTP/1.0 500 Server Error");
        }

    }

}
