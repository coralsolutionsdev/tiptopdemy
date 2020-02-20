<?php

namespace App\Widgets\Home;

use App\Banner;
use Arrilot\Widgets\AbstractWidget;

class BannerSlideShow extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $config =  $this->config;
        $items = $config['items'];
        $item_banners = $items['item_banners'];
        $banners = Banner::whereIn('id', $item_banners)->where('status', Banner::STATUS_ENABLED)->get();

        return view('widgets.home.banner_slide_show', [
            'config' => $this->config,
            'banners' => $banners,
        ]);
    }
}
