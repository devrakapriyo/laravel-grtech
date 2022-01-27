<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

class Notification extends Model
{
    public static function notificationMail($penerima, $subjek, $messages)
    {
        return Mail::to($penerima)->send(new NotificationMail($subjek, $messages));
    }
}
