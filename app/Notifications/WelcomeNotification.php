<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    protected $user;

    // ユーザー情報をメール内で使えるように受け取る
    public function __construct($user)
    {
        $this->user = $user;
    }

    // メール（mail）で送信することを指定
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    // メール本文の構築
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('【全国ソロアーティストマップ】会員登録が完了しました！')
            ->greeting($this->user->name . ' 様')
            ->line('この度は「全国ソロアーティストマップ」にご登録いただき、誠にありがとうございます！')
            ->line('当サイトでは、全国のソロアーティストの活動や動画、イベント情報をチェック・共有することができます。')
            ->action('さっそくサイトを見る', url('/'))
            ->line('あなたの推しアーティストの登録や、お気に入り動画の共有など、ぜひ様々な機能をお楽しみください！')
            ->line('ご不明な点がございましたら、お気軽にお問い合わせください。')
            ->salutation('全国ソロアーティストマップ（β版）運営より');
    }
}