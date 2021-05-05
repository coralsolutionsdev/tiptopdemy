<?php

namespace App\Widgets\Home;

use App\User;
use Arrilot\Widgets\AbstractWidget;

class NavbarTopMenu extends AbstractWidget
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
        $items = getNavbarTopMenuItems();
        $user = getAuthUser();
        $notifications = array();
        $unreadCount = 0;
        if ($user){
            $unreadCount =  $user->notifications->whereNull('read_at')->count();
            $notifications =  $user->notifications->take(5);
//            $notifications->map(function ($item){
//                $notifiable = User::find($item->notifiable_id);
//                if ($notifiable){
//                    $item->notifiable_image = $notifiable->getProfilePicURL();
//                }
//            });
        }

        return view('widgets.home.navbar_top_menu', [
            'config' => $this->config,
            'items' => $items,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}
