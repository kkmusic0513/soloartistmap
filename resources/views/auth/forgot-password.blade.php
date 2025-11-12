<x-guest-layout>
    <div class="max-w-md mx-auto py-10">
        <h1 class="text-2xl font-bold mb-4 text-center">パスワードをお忘れですか？</h1>
        <p class="mb-4 text-gray-600 text-center">
            登録済みのメールアドレスを入力してください。<br>
            パスワード再設定用のリンクをお送りします。
        </p>

        <!-- セッションステータス -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- メールアドレス -->
            <div>
                <x-input-label for="email" :value="__('メールアドレス')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- 送信ボタン -->
            <div class="text-center">
                <x-primary-button class="w-full">
                    {{ __('パスワード再設定リンクを送信') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                {{ __('ログイン画面に戻る') }}
            </a>
        </div>
    </div>
</x-guest-layout>
