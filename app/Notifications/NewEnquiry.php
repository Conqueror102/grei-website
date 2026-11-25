<?php

namespace App\Notifications;

use App\Models\Enquiry;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEnquiry extends Notification
{
    public function __construct(public Enquiry $enquiry) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $e = $this->enquiry;
        $mail = (new MailMessage)
            ->subject('New '.$e->type.' enquiry: '.($e->topic ?: $e->name))
            ->replyTo($e->email, $e->name)
            ->line("From: {$e->name} <{$e->email}>".($e->phone ? ", {$e->phone}" : ''));

        foreach (($e->meta ?? []) as $k => $v) {
            if ($v !== null && $v !== '') {
                $mail->line(ucfirst(str_replace('_', ' ', $k)).': '.(is_array($v) ? implode(', ', $v) : $v));
            }
        }

        return $mail->line($e->message ?: '(no message)');
    }
}
