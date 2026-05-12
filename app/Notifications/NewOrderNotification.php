<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class NewOrderNotification extends Notification
{
    use Queueable;

    protected $name, $product, $price;

    public function __construct($name, $product, $price)
    {
        $this->name = $name;
        $this->product = $product;
        $this->price = $price;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Dear ' . $notifiable->name)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }


    public function toDatabase(object $notifiable): array
    {
        return [
            'msg' => 'New order created ' . $this->name . ' purchase ' . $this->product . ' with cost ' . $this->price,
            'url' => LaravelLocalization::getLocalizedURL(app()->getLocale(), route('admin.orders')),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'msg' => 'New order created, ' . $this->name . ' purchase ' . $this->product . ' with cost ' . $this->price,
            'url' => route('admin.orders')
        ];
    }
}
