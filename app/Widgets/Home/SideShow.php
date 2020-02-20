<?php

namespace App\Widgets\Home;

use Arrilot\Widgets\AbstractWidget;
use App\Banner;

class SideShow extends AbstractWidget
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
        //
        $carousels = Banner::where('group', Banner::GROUP_SLIDE_SHOW)
            ->orderBy('order_id', 'asc')
            ->where('status', '1')->get();
        $carousel_active = Banner::where('group', Banner::GROUP_SLIDE_SHOW)
            ->orderBy('order_id', 'asc')
            ->where('status', '1')->latest()->first();


        return view('widgets.home.side_show', [
            'config' => $this->config,
            'carousels' => $carousels,
            'carousel_active' => $carousel_active,
        ]);
    }
}
