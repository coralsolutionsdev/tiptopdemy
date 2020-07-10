<?php

namespace App\Widgets\Admin\Dashboard;

use App\BlogPost;
use Arrilot\Widgets\AbstractWidget;

class posts extends AbstractWidget
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
        $itemsCount = BlogPost::all()->count();

        return view('widgets.admin.dashboard.posts', [
            'config' => $this->config,
            'itemsCount' => $itemsCount,
        ]);
    }
}
