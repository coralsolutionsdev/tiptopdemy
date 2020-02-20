<?php

namespace App\Widgets\Home\Blog;

use App\BlogCategory;
use App\BlogPost;
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
        $categories = BlogCategory::all();
        $posts = BlogPost::latest()->where('status',BlogPost::STATUS_ENABLED)->paginate(5);

        return view('widgets.home.blog.side_bar_menu', [
            'config' => $this->config,
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }
}
