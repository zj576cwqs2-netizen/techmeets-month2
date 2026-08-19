<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendWelcomeEmail(User $user)
    {
        Mail::raw('Welcome to our application!', function ($message) use ($user) {
            $message->to($user->email)
                     ->subject('Welcome');
        });
    }
}
