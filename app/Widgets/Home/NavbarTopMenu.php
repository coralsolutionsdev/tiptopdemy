<?php

namespace App\Widgets\Home;

use Arrilot\Widgets\AbstractWidget;

class NavbarTopMenu extends AbstractWidget
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
        $items = getNavbarTopMenuItems();


        return view('widgets.home.navbar_top_menu', [
            'config' => $this->config,
            'items' => $items,
        ]);
    }
}
