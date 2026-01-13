<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4 lg:py-6">

            <!-- すべての画面サイズで表示 -->
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0">

                <!-- 左側: サイトタイトルと使い方ガイド -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-2 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('home') }}" class="text-lg lg:text-xl font-bold text-gray-800">
                        {{ config('app.name', '全国ソロアーティストマップ') }}
                    </a>
                    <a href="{{ route('help') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs lg:text-sm font-semibold px-2 py-1 lg:px-3 lg:py-1 rounded shadow whitespace-nowrap">
                        使い方ガイド
                    </a>
                </div>

                <!-- 右側: 認証状態に応じたコンテンツ -->
                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4 lg:space-x-6">
                    @auth
                        <!-- ログイン時 -->
                        <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                            <span class="text-gray-700 font-medium text-center sm:text-left">
                                ようこそ、{{ Auth::user()->name }}さん
                            </span>
                            <div class="flex space-x-3">
                                <a href="{{ route('dashboard') }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-3 py-2 lg:px-4 lg:py-2 rounded-lg shadow text-sm lg:text-base">
                                    ダッシュボード
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-3 py-2 lg:px-4 lg:py-2 rounded-lg shadow text-sm lg:text-base">
                                        ログアウト
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- 未ログイン時 -->
                        <div class="flex space-x-3">
                            <a href="{{ route('login') }}"
                                class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-3 py-2 lg:px-4 lg:py-2 rounded-lg shadow text-sm lg:text-base">
                                ログイン
                            </a>
                            <a href="{{ route('register') }}"
                                class="bg-green-500 hover:bg-green-600 text-white font-semibold px-3 py-2 lg:px-4 lg:py-2 rounded-lg shadow text-sm lg:text-base">
                                新規登録
                            </a>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</nav>
