<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:h-12 items-center">
            <!-- サイトタイトル -->
            <div class="flex justify-center sm:justify-start mt-2 mb-2 sm:mb-0 lg:mb-4">
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                    {{ config('app.name', 'SoloArtistMap') }}
                </a>
            </div>

            <!-- ボタン -->
            <div class="flex justify-center space-x-4 w-full sm:w-auto sm:mb-4 lg:mb-0">
                @auth
                    <span class="text-gray-700 text-center sm:text-left">ようこそ、{{ Auth::user()->name }}さん</span>
                    <form method="POST" action="{{ route('logout') }}" class="flex justify-center sm:justify-start">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            ログアウト
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-1 rounded shadow whitespace-nowrap text-center">
                        ログイン
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-1 rounded shadow whitespace-nowrap text-center">
                        新規登録
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>
