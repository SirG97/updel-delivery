<?php

namespace App\Controllers;

class BaseController{
    public function display_menu(){
        $menu = [
            '/dashboard' => ['Dashboard', 'fas fa-fw fa-tachometer-alt'],
            '/profile' => ['Profile', 'fas fa-fw fa-user'],
            '/authorize' => ['Authorize Delivery', 'fas fa-fw fa-qrcode'],
            '/managers' => ['Managers', 'fas fa-fw fa-user-shield'],
            '/support_staff' => ['Customer service', 'fas fa-fw fa-headset'],
            '/riders' => ['Riders', 'fas fa-fw fa-motorcycle'],
            '/staff' => ['New staff', 'fas fa-fw fa-user-plus'],
            '/district_routes' => ['District/Routes', 'fas fa-fw fa-paper-plane'],
            '/assign_route' => ['Assign Route', 'fas fa-fw fa-tachometer-alt'],
            '/dashboard' => ['Dashboard', 'fas fa-fw fa-tachometer-alt'],
            '/dashboard' => ['Dashboard', 'fas fa-fw fa-tachometer-alt'],
        ];
    }
}