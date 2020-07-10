<?php

namespace App\Widgets\Admin\Dashboard;

use App\User;
use Arrilot\Widgets\AbstractWidget;

class RecentUsers extends AbstractWidget
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
        $items = User::latest()->where('id', '!=', 1)->get()->take(5);


        return view('widgets.admin.dashboard.recent_users', [
            'config' => $this->config,
            'items' => $items,
        ]);
    }
}
