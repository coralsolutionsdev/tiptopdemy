<?php

namespace App\Widgets\Admin\Dashboard;

use Arrilot\Widgets\AbstractWidget;

class ChangesLog extends AbstractWidget
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

        return view('widgets.admin.dashboard.changes_log', [
            'config' => $this->config,
        ]);
    }
}
