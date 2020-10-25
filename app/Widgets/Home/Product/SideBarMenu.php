<?php

namespace App\Widgets\Home\Product;

use App\Category;
use App\Product;
use Arrilot\Widgets\AbstractWidget;
use Spatie\Tags\Tag;

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
        $config =  $this->config;
//        $search_key = $config['search_key'];
        $search_key = '';

        $categories = Category::where('type', Category::TYPE_PRODUCT, 3)->where('parent_id', 0)->where('status',Category::STATUS_ENABLED)->get();
        $tags = Tag::where('type', 'product')->get();

        return view('widgets.home.product.side_bar_menu', [
            'config' => $this->config,
            'categories' => $categories,
            'tags' => $tags,
            'search_key' => $search_key,
        ]);
    }
}
