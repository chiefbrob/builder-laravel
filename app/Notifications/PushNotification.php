<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class PushNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [FcmChannel::class];
    }

    /**
     * Get the push no representation of the notification.
     */
    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['data1' => 'value', 'data2' => 'value2'])
            ->setNotification(
                \NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle('Test Message')
                    ->setBody('A message from test servr')
                    ->setImage('https://chiefbrob.info/images/nice-suit.png')
            )
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(
                        AndroidFcmOptions::create()
                            ->setAnalyticsLabel('analytics')
                    )
                    ->setNotification(
                        AndroidNotification::create()->setColor('#0A0A0A')
                    )
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(
                        ApnsFcmOptions::create()
                            ->setAnalyticsLabel('analytics_ios')
                    )
            );
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

    public function fcmProject($notifiable, $message)
    {
        return 'app'; // name of the firebase project to use
    }
}
