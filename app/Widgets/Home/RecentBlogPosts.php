<?php

namespace App\Widgets\Home;

use Arrilot\Widgets\AbstractWidget;

class RecentBlogPosts extends AbstractWidget
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

        return view('widgets.home.recent_blog_posts', [
            'config' => $this->config,
        ]);
    }
}
