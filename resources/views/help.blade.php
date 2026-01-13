<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 戻るボタン --}}
        <div class="mb-4">
            <a href="{{ route('home') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow">
               ← トップに戻る
            </a>
        </div>

        <h1 class="text-4xl font-bold text-center mb-8">使い方ガイド</h1>

        <div class="mb-8 bg-blue-50 p-6 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">🎵 全国ソロアーティストマップへようこそ！</h2>
            <p class="text-lg text-gray-700 leading-relaxed">
                全国ソロアーティストマップは、ソロアーティストのためのプラットフォームです。<br>
                ユーザー登録するとアーティストを登録できます。<br>
                ひとつのユーザーアカウントで複数のアーティストを登録・管理できます。
            </p>
        </div>

        <div class="mb-12">
            <h2 class="text-3xl font-bold mb-6">📋 利用開始までの流れ</h2>

            <div class="space-y-8">
                {{-- ステップ1: ユーザー登録 --}}
                <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                1
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold mb-3">新規ユーザー登録</h3>
                            <p class="text-gray-600 mb-4">
                                まずはユーザーアカウントを作成しましょう。メールアドレスとパスワードを登録してください。
                            </p>
                            <div class="bg-gray-100 p-4 rounded">
                                <p class="text-sm text-gray-600">📍 場所: 右上の「新規登録」ボタン</p>
                                <p class="text-sm text-gray-600">📧 必要な情報: メールアドレス、パスワード、名前</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ステップ2: アーティスト登録 --}}
                <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-start">
                        <div class="ml-6">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                    2
                                </div>
                                <h3 class="text-xl font-bold ml-6">アーティスト登録</h3>
                            </div>
                            <p class="text-gray-600 mb-4">
                                ユーザーアカウント作成後、アーティスト情報を登録します。<br>
                                <strong>
                                    ひとつのユーザーアカウントで複数のアーティストを登録・管理できます。
                                </strong>
                            </p>

                            <div class="bg-green-50 p-4 rounded mb-4">
                                <h4 class="font-bold text-green-800 mb-2">🎯 複数アーティスト登録のメリット</h4>
                                <ul class="text-green-700 space-y-1">
                                    <li>• 異なるジャンルでの活動を分けて管理</li>
                                    <li>• プロジェクトごとのアーティスト名を使い分け</li>
                                    <li>• コラボレーション作品も個別に管理</li>
                                </ul>
                            </div>

                            <div class="bg-gray-100 p-4 rounded">
                                <p class="text-sm text-gray-600">📍 場所: ダッシュボード → 「＋ アーティストを登録する」</p>
                                <p class="text-sm text-gray-600">📝 必要な情報: アーティスト名、活動地域、ジャンル、プロフィール、写真など</p>
                                {{-- <p class="text-sm text-gray-600">⏱️ 承認: 管理者承認後に公開されます</p> --}}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ステップ3: コンテンツ登録 --}}
                <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-start">
                        <div class="ml-6">
                            <div class="flex items-center mb-3">
                                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                    3
                                </div>
                                <h3 class="text-xl font-bold ml-6">イベント・動画の登録</h3>
                            </div>
                            <p class="text-gray-600 mb-4">
                                アーティスト登録が完了したら、イベント情報や動画コンテンツを登録しましょう。
                            </p>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="bg-purple-50 p-4 rounded">
                                    <h4 class="font-bold text-purple-800 mb-2">🎪 イベント登録</h4>
                                    <p class="text-purple-700 text-sm mb-2">ライブ、展示会、ワークショップなどのイベント情報を登録できます。</p>
                                    <p class="text-xs text-gray-600">📍 ダッシュボード → アーティスト → 「イベントを登録」</p>
                                </div>

                                <div class="bg-purple-50 p-4 rounded">
                                    <h4 class="font-bold text-purple-800 mb-2">🎬 動画登録</h4>
                                    <p class="text-purple-700 text-sm mb-2">YouTube動画を埋め込んで作品を紹介できます。</p>
                                    <p class="text-xs text-gray-600">📍 ダッシュボード → アーティスト → 「YouTube動画を登録」</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-yellow-800 mb-3">💡 ポイント</h3>
            <ul class="text-yellow-700 space-y-2">
                {{-- <li>• 登録したアーティスト情報は管理者承認後に公開されます</li> --}}
                {{-- <li>• 承認済みのアーティストはホームページで検索・閲覧できるようになります</li> --}}
                <li>• 各アーティストごとにイベント・動画を個別に管理できます</li>
                <li>• プロフィール情報はいつでも編集可能です</li>
            </ul>
        </div>

        <div class="text-center">
            <a href="{{ route('register') }}"
               class="inline-block bg-pink-500 hover:bg-pink-600 text-white px-8 py-3 rounded-lg font-semibold text-lg shadow-lg">
               今すぐ始める →
            </a>
        </div>

    </div>
</x-app-layout></contents>
</xai:function_call name="write">
<parameter name="file_path">resources/views/help.blade.php