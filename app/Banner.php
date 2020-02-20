<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    // const
    const GROUP_BASIC_BANNER = 1;
    const GROUP_SLIDE_SHOW_BANNER = 2;
    const GROUP_ICONIC_BANNER = 3;

    const GROUP_ARRAY = [
        self::GROUP_BASIC_BANNER => 'Basic Banner',
        self::GROUP_SLIDE_SHOW_BANNER => 'Slide Show Banner',
        self::GROUP_ICONIC_BANNER => 'Iconic Banner',

    ];

    const GRID_ARRAY = [
        1 => 'One in row',
        2 => 'Two in row',
        3 => 'Three in row',
        3 => 'Four in row',
    ];

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected $fillable = [
        'title',
        'image',
        'image_size',
        'content',
        'content_alignment',
        'link',
        'font_color',
        'grid',
        'group',
        'status',
        'user_id',
        'order_id',
        'icon',
        ];

    /**
     * @return string
     */
    public function getAlignment()
    {
        $class = 'center';
        switch ($this->content_alignment){
            case 'right':
                $class = 'end';
                break;
            case 'left':
                $class = 'start';
        }
        return $class;
    }

    public function getGroup()
    {
       return self::GROUP_ARRAY[$this->group];
    }
    public function getImageUrl()
    {
        $url =  asset_image($this->image);
        return $url;
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

}
