<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserNotification;
use Google\Cloud\Storage\Notification;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationController extends Controller
{
    public function sendNotification(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $message = $request->input('message', 'Default notification message');
        $user->notify(new UserNotification($message));

        // Kirim notifikasi ke Firebase
        $title = $request->input('title') ?? 'New Notification';
        $firebaseMessaging = app('firebase.messaging');
        $deviceToken = $request->input('device_token'); // Token perangkat dari client

        // c1UjIgOTR9Swwl0hZo8U3O:APA91bH1rL9ewfDXCTtbKL1ItTPfaOJxR_6HkW6cAuWveGttN2zYK_oM2QQXTTlkuudRtcGdYBE-iPjcKS3-yBSLpV4mnPFtwUoyswNu2DTKOOiV_jIfFUk

        // TODO : setiap user login, post lah kolom fcm_token user
        // jadi nanti dalam praktiknya device token ini tidak diambil dari input karena berbahaya

        // tapi dalam project ini diinputkan secara manual
        // melalui request body pada endpoint
        // {{BASE_URL}}/users/2/notifications
        // untuk perocabaan aja

        // yang belum ada di projek ini
        // menambahkan kolom fcm_token atau namanya sejenisnya
        // untuk simpan fcm_token user saat dia login

        $cloudMessage = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $message,
            ],
        ]);

        $firebaseMessaging->send($cloudMessage);

        return response()->json(['success' => 'Notification sent successfully']);

        return response()->json(['success' => 'Notification sent successfully']);
    }


    // semua
    public function getUserNotifications($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Ambil semua notifikasi milik user
        $notifications = $user->notifications;

        return response()->json($notifications);
    }

    // unread notificaiton saja
    // public function getUserNotifications($id)
    // {
    //     $user = User::find($id);

    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     // Ambil hanya notifikasi yang belum dibaca
    //     $unreadNotifications = $user->unreadNotifications;

    //     return response()->json($unreadNotifications);
    // }
    public function markNotificationsAsRead($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Tandai semua notifikasi sebagai sudah dibaca
        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => 'All notifications marked as read']);
    }
}
