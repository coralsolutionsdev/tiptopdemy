<?php

namespace App\Widgets\Home;

use App\Banner;
use Arrilot\Widgets\AbstractWidget;

class BannerIconic extends AbstractWidget
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
        $iconic_banners = Banner::where('group', Banner::GROUP_BANNER_HOME_ICONIC)->where('status',Banner::STATUS_ENABLED)->orderBy('order_id')->take(6)->get();
        return view('widgets.home.banner_iconic', [
            'config' => $this->config,
            'iconic_banners' => $iconic_banners,
            'title' => $title,
            'description' => $description,
        ]);
    }
}
