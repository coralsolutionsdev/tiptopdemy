<?php


namespace App\Modules\ColorPattern;


trait HasColorPattern
{
    public function getColorPattern()
    {
        return ColorPattern::find($this->color_pattern_id);
    }
    public function getMainColorPattern()
    {
        return $this->getColorPattern()->gradient[0];
    }

}