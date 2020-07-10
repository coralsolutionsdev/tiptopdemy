<?php

namespace App\Widgets\Admin\Dashboard;

use App\Product;
use Arrilot\Widgets\AbstractWidget;

class products extends AbstractWidget
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
        $itemsCount = Product::all()->count();

        return view('widgets.admin.dashboard.products', [
            'config' => $this->config,
            'itemsCount' => $itemsCount,
        ]);
    }
}
