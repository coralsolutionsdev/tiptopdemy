<?php

namespace App\Widgets\Admin\Dashboard;

use Arrilot\Widgets\AbstractWidget;

class orders extends AbstractWidget
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

        return view('widgets.admin.dashboard.orders', [
            'config' => $this->config,
        ]);
    }
}
