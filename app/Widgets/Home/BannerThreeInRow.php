<?php

namespace App\Widgets\Home;

use App\Banner;
use Arrilot\Widgets\AbstractWidget;

class BannerThreeInRow extends AbstractWidget
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
        $item = $this->config['item'];
        $title = $item['title'];
        $description = $item['description'];
        $banners = Banner::where('group', Banner::GROUP_BANNER_HOME)->where('status',Banner::STATUS_ENABLED)->orderBy('order_id')->take(6)->get();
        return view('widgets.home.banner_three_in_row', [
            'config' => $this->config,
            'banners' => $banners,
            'title' => $title,
            'description' => $description,
        ]);
    }
}
