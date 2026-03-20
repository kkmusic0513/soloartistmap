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

        {{-- ★ バグ報告・改善リクエスト（ド派手バージョン） --}}
        <div class="mb-12 relative group">
            {{-- 背景のネオン・グロー効果（ホバーでさらに光る） --}}
            <div class="absolute -inset-1 bg-gradient-to-r from-pink-600 via-purple-600 to-blue-600 rounded-3xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
            
            {{-- コンテンツ本体 --}}
            <div class="relative bg-white border-2 border-dashed border-gray-200 p-8 rounded-3xl shadow-2xl overflow-hidden">
                
                {{-- 背景のアートワーク（薄くギターのアイコンなどを配置しても良い） --}}
                <div class="absolute right-0 bottom-0 opacity-5 transform translate-x-1/4 translate-y-1/4 scale-150">
                    <svg class="w-64 h-64 text-purple-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                </div>

                <div class="grid md:grid-cols-3 gap-8 items-center relative z-10">
                    
                    {{-- 左側：メッセージ --}}
                    <div class="md:col-span-2">
                        <h3 class="text-3xl font-black mb-4 flex items-center bg-gradient-to-r from-pink-500 to-violet-600 bg-clip-text text-transparent">
                            <span class="mr-3 text-4xl">🛠</span> あなたの「声」が地図を広げる
                        </h3>
                        <p class="text-gray-700 mb-2 leading-relaxed text-lg font-medium">
                            「全国ソロアーティストマップ」は現在<strong class="text-purple-600">β版</strong>として爆速開発中です。<br>
                            表示の崩れ、使いにくい点、そして「こんな機能が欲しい！」という熱いアイデアがあれば、ぜひ管理人までお気軽にお寄せください。
                        </p>
                        <p class="text-sm text-gray-500">※あなたのアイデアが、次のアップデートで実装されるかも！</p>
                    </div>

                    {{-- 右側：巨大アクションボタン --}}
                    <div class="text-center">
                        <a href="https://x.com/kk_jazzmaster" target="_blank" 
                        class="inline-flex flex-col items-center justify-center bg-black hover:bg-gray-800 text-white p-8 rounded-full shadow-2xl transform hover:scale-105 hover:-translate-y-1 transition-all duration-300 w-48 h-48 border-4 border-white ring-8 ring-black ring-opacity-10 group">
                            
                            {{-- Xアイコン --}}
                            <svg class="w-16 h-16 mb-2 fill-current text-[#1DA1F2] group-hover:text-white transition" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            
                            <span class="font-black text-xl tracking-tight">管理人に連絡</span>
                            <span class="text-xs opacity-70">(@kk_jazzmaster)</span>
                        </a>
                    </div>
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