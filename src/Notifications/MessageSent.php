<?php

namespace MichaelNabil230\LaravelChat\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use MichaelNabil230\LaravelChat\Models\Message;

class MessageSent extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected Message $message)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['email'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->greeting('Hello!')
            ->subject('You have a new message from ' . $this->message->sender->name)
            ->line('Message: ' . $this->message->body)
            ->line('Thank you for using our application!');

        $functionRoute = config('chat.notifyUsersDonstSeen.routeShow');
        if (!$functionRoute($this->message->chat_id)) {
            $mail->action('View Message', $functionRoute($this->message->chat_id));
        }

        return $mail;
    }
}
