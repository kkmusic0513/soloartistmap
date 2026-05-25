<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('ご登録ありがとうございます！サイトを始める前に、先ほどお送りしたメール内のリンクをクリックして、メールアドレスの認証を完了させてください。もしメールが届いていない場合は、下のボタンから再送信することができます。') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('ご登録いただいたメールアドレスに、新しい認証リンクを送信しました。') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('認証メールを再送信する') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-554 dark:focus:ring-offset-gray-800">
                {{ __('ログアウト') }}
            </button>
        </form>
    </div>
</x-guest-layout>