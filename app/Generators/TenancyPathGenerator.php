<?php

namespace App\Generators;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class TenancyPathGenerator implements PathGenerator
{
    public function getPath(Media $media) : string
    {
        $user = getAuthUser();
        return 'media/'.$user->getTenancyId().'/'.$user->id.'/'.md5($media->id).'/';
    }

    public function getPathForConversions(Media $media) : string
    {
        return $this->getPath($media).'c/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'/cri/';
    }
}