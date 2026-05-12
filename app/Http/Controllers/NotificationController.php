<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    function send()
    {
        $admin = User::find(1);
        $admin->notify(new NewOrderNotification('Ali', 'jacket', 150));
        return "Notification sen";
    }
}
