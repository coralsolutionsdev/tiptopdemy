<?php

namespace App\Widgets\Admin\Dashboard;

use App\Product;
use Arrilot\Widgets\AbstractWidget;

class RecentProducts extends AbstractWidget
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
        $items = Product::latest()->get()->take(5);

        return view('widgets.admin.dashboard.recent_products', [
            'config' => $this->config,
            'items' => $items,
        ]);
    }
}
