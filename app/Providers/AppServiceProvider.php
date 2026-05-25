<?php

namespace App\Providers;

require_once __DIR__ . '/../helpers.php';

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Events\Verified;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 既存の公開パスバインド
        $this->app->bind('path.public', function() {
            return '/home/web13c/best-web.net/public_html/solo';
        });

        Vite::useBuildDirectory('build');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        // 既存のパスワードリセット設定（日本語化）
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return (new MailMessage)
                ->subject('パスワード再設定の通知')
                ->greeting('こんにちは！')
                ->line('アカウントのパスワード再設定リクエストを受け取ったため、このメールをお送りしています。')
                ->action('パスワードを再設定する', url(route('password.reset', [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ], false)))
                ->line('このパスワード再設定リンクの有効期限は 60 分です。')
                ->line('もしパスワードの再設定をリクエストしていない場合は、これ以上の操作は必要ありません。')
                ->salutation('全国ソロアーティストマップ（β版）より');
        });

        // 👈 2. ここから追加：メール認証用のメール（日本語化）
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('【全国ソロアーティストマップ】メールアドレスの確認')
                ->greeting($notifiable->name . ' 様')
                ->line('「全国ソロアーティストマップ」へのご登録、誠にありがとうございます！')
                ->line('下のボタンをクリックして、メールアドレスの認証を完了させてください。')
                ->action('メールアドレスを確認する', $url) // Laravelが自動生成した認証URLがここに入ります
                ->line('もしこのメールに心当たりがない場合は、操作を破棄してください。')
                ->salutation('全国ソロアーティストマップ（β版）より');
        });
        // 4. ここから追記：メール認証が完了した瞬間にウェルカムメールを送信する
        Event::listen(Verified::class, function (Verified $event) {
            // 認証されたユーザー（$event->user）にウェルカムメールを送信
            $event->user->notify(new WelcomeNotification($event->user));
        });
    }
}
