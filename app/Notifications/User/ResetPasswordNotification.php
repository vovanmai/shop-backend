<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public string $token;

    /**
     * Create a new notification instance.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Xin chào!')
            ->salutation('Xin chào!')
            ->subject('Yêu cầu khôi phục mật khẩu.')
            ->line('Bạn đang khôi phục lại mật khẩu. Vui lòng click vào nút bên dưới để tiến hành khôi phục.')
            ->action('Link', $this->resetUrl())
            ->line('Cảm ơn đã sử dụng của chúng tôi!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @return string
     */
    protected function resetUrl()
    {
        return config('app.front_end_url') . '/reset-password?token=' . $this->token;
    }
}
