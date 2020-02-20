<?php

namespace App\Widgets\Home\Product;

use App\Category;
use Arrilot\Widgets\AbstractWidget;

class SideBarMenu extends AbstractWidget
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
        $tree_categories = Category::where('type', Category::TYPE_PRODUCT)->where('parent_id', 0)->get();

        return view('widgets.home.product.side_bar_menu', [
            'config' => $this->config,
            'tree_categories' => $tree_categories,
        ]);
    }
}
