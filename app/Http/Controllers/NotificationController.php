<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\OffersNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        // $user = User::where('name')->get();
        $user = User::first();

        $offerData = [
            'name' => 'Testing',
            'body' => 'You received a notification',
            'thanks' => 'Thanks You',
            'Text' => 'Check out the offer',
            'Url' => url('/'),
            'terting_id' => rand(111, 999),
        ];

        Notification::send($user, new OffersNotification($offerData));
        dd('Tak is Complete');
    }
    public function markAsRead(Request $request, $notification)
    {
        // Mark the notification as read
        $request->user()->notifications()->findOrFail($notification)->markAsRead();

        // jika Anda ingin menghapus notifikasi alih-alih menandai sebagai telah dibaca
        // $request->user()->notifications()->findOrFail($notification)->delete();

        return redirect()->back();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
