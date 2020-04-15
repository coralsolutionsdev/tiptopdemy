<?php

namespace App\Widgets\Home\Blog;

use App\BlogCategory;
use App\BlogPost;
use App\Category;
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
        $search_key = $config['search_key'];

        $categories = Category::where('type', Category::TYPE_POST, 3)->where('parent_id', 0)->get();
        $posts = BlogPost::latest()->where('status',BlogPost::STATUS_ENABLED)->paginate(5);
        $tags = Tag::where('type', 'post')->get();

        return view('widgets.home.blog.side_bar_menu', [
            'config' => $this->config,
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,
            'search_key' => $search_key,
        ]);
    }
}
