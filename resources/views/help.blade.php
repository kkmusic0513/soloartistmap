<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 戻るボタン --}}
        <div class="mb-4">
            <a href="{{ route('home') }}"
               class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
               ← トップに戻る
            </a>
        </div>

        <h1 class="text-4xl font-black text-center mb-4 text-gray-800">使い方ガイド</h1>
        <p class="text-center text-gray-500 mb-10">あなたの活動を、もっと多くの人へ届けるための3分ガイド</p>

        {{-- イントロダクション --}}
        <div class="mb-10 bg-gradient-to-r from-blue-600 to-indigo-700 p-8 rounded-2xl shadow-xl text-white">
            <h2 class="text-2xl font-bold mb-4 flex items-center">
                <span class="mr-2">🎸</span> 全国ソロアーティストマップへようこそ！
            </h2>
            <p class="text-lg leading-relaxed opacity-90">
                ここは、一人で活動する表現者たちが主役のプラットフォームです。<br>
                「自分のホームページを持つのは大変だけど、ライブ情報や動画をまとめておきたい」<br>
                そんなアーティストの願いを一箇所で叶えます。<br>
                現在は、「一人で」活動している方のみの登録をお願いします。
            </p>
        </div>

        {{-- ステップ --}}
        <div class="space-y-12 mb-12">
            
            {{-- STEP 1 --}}
            <div class="relative pl-8 border-l-4 border-blue-500">
                <span class="absolute -left-4 top-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold">1</span>
                <h3 class="text-2xl font-bold mb-2">まずはユーザー登録</h3>
                <p class="text-gray-600 mb-4">
                    まずはアカウントを作成しましょう。SNSのアカウントを作る感覚でOKです。
                </p>
                <div class="bg-white border border-gray-200 p-5 rounded-xl shadow-sm">
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li>✅ <strong>メールアドレス</strong> と <strong>パスワード</strong> だけで完了！</li>
                        <li>✅ <strong>名前</strong> は本名じゃなくても大丈夫です。</li>
                    </ul>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div class="relative pl-8 border-l-4 border-green-500">
                <span class="absolute -left-4 top-0 w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold">2</span>
                <h3 class="text-2xl font-bold mb-2">「アーティスト」を登録する（複数OK！）</h3>
                <p class="text-gray-600 mb-4">
                    アーティストのプロフィールを作成します。<br>
                    <strong>(例)「アコースティック活動」と「DTM活動」を分けて(名義が違う場合など)登録</strong>することもできます。
                </p>
                
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div class="bg-green-50 p-5 rounded-xl border border-green-100">
                        <h4 class="font-bold text-green-800 mb-2">💡 登録のコツ</h4>
                        <p class="text-sm text-green-700 leading-relaxed">
                            プロフィールを詳しく書くと、後日<strong>あなたが登録した情報が紹介</strong>される場合があります。
                        </p>
                    </div>
                </div>
            </div>

            {{-- STEP 3 --}}
            <div class="relative pl-8 border-l-4 border-purple-500">
                <span class="absolute -left-4 top-0 w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center font-bold">3</span>
                <h3 class="text-2xl font-bold mb-2">活動を広める（イベント・YouTube）</h3>
                <p class="text-gray-600 mb-4">
                    プロフィールができたら、実際の活動内容を見てもらいましょう！
                </p>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="p-5 bg-white border border-purple-100 rounded-xl shadow-sm">
                        <div class="text-2xl mb-2">📅</div>
                        <h4 class="font-bold text-purple-800">イベント登録</h4>
                        <p class="text-sm text-gray-600">ライブや配信の予定を登録。サイト上にあなたのライブスケジュール(または配信予定)が表示されます。</p>
                    </div>
                    <div class="p-5 bg-white border border-purple-100 rounded-xl shadow-sm">
                        <div class="text-2xl mb-2">🎬</div>
                        <h4 class="font-bold text-purple-800">YouTube連携</h4>
                        <p class="text-sm text-gray-600">URLを貼るだけで、あなたのページに動画が埋め込まれます。</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- 困ったときは --}}
        <div class="bg-gray-800 text-white p-8 rounded-2xl mb-12">
            <h3 class="text-xl font-bold mb-4 flex items-center">
                <span class="text-yellow-400 mr-2">❓</span> 困ったときは
            </h3>
            <div class="space-y-4 text-gray-300">
                <div>
                    <p class="font-bold text-white">Q. DM機能が見当たりません</p>
                    <p class="text-sm">A. 現在、直接メッセージ機能は一時停止しております。SNS等のリンクをご活用ください。</p>
                </div>
                <div>
                    <p class="font-bold text-white">Q. 登録した情報はいつ反映されますか？</p>
                    <p class="text-sm">A. 公開ボタンを押した瞬間、即座にサイトへ反映されます。</p>
                </div>
            </div>
        </div>

        <div class="text-center">
            @guest
                <a href="{{ route('register') }}"
                   class="inline-block bg-pink-500 hover:bg-pink-600 text-white px-10 py-4 rounded-full font-bold text-xl shadow-lg transform hover:scale-105 transition duration-200">
                   無料で今すぐ登録する
                </a>
            @else
                <a href="{{ route('dashboard') }}"
                   class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-10 py-4 rounded-full font-bold text-xl shadow-lg transform hover:scale-105 transition duration-200">
                   マイページへ戻る
                </a>
            @endguest
        </div>

    </div>
</x-app-layout>