<?php

namespace App\Widgets\Home\Product;

use App\Category;
use Arrilot\Widgets\AbstractWidget;

class TopBarMenu extends AbstractWidget
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
        $categories = Category::where('type', Category::TYPE_PRODUCT)->where('status', 1)->pluck ('name', 'id')->toArray();
        return view('widgets.home.product.top_bar_menu', [
            'config' => $this->config,
            'categories' => $categories,
        ]);
    }
}
