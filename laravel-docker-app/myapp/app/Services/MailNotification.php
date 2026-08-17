<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Mail;

class MailNotification
{
    public function sendTaskCreated(Task $task): void
    {
        Mail::raw(
            "新しいタスクが作成されました：{$task->title}",
            function ($message) use ($task) {
                $message->to('admin@example.com')
                    ->subject('タスク作成通知');
            }
        );
    }
}