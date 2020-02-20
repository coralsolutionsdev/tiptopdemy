<?php

namespace App\Widgets\Home;

use App\Banner;
use Arrilot\Widgets\AbstractWidget;

class Carousel extends AbstractWidget
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
        $carousels = Banner::where('group', Banner::GROUP_SLIDE_SHOW)->where('status',Banner::STATUS_ENABLED)->orderBy('order_id')->get();

        return view('widgets.home.carousel', [
            'config' => $this->config,
            'carousels' => $carousels,
        ]);
    }
}
