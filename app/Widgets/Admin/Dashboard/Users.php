<?php

namespace App\Widgets\Admin\Dashboard;

use App\User;
use Arrilot\Widgets\AbstractWidget;

class users extends AbstractWidget
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
        $itemsCount = User::where('id', '!=', 1)->get()->count();

        return view('widgets.admin.dashboard.users', [
            'config' => $this->config,
            'itemsCount' => $itemsCount,
        ]);
    }
}
