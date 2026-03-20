@section('title', $artist->name . ' | ソロアーティストマップ')

@section('meta')
    <meta property="og:title" content="{{ $artist->name }} - ソロアーティストマップ">
    <meta property="og:description" content="{{ Str::limit(strip_tags($artist->profile), 100) }}">
    <meta property="og:image" content="{{ $artist->main_photo ? asset('storage/' . $artist->main_photo) : asset('ogp-main.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $artist->name }}">
    <meta name="twitter:image" content="{{ $artist->main_photo ? asset('storage/' . $artist->main_photo) : asset('ogp-main.png') }}">
@endsection
<x-app-layout>
   
    <div class="max-w-4xl mx-auto px-6 py-10">

        {{-- 戻るボタンとシェアボタンの並び --}}
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('home') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow text-sm">
               ← 一覧に戻る
            </a>

            {{-- X シェアボタン --}}
            @php
                $shareText = urlencode("【ソロアーティストマップ】\nアーティスト：{$artist->name}\n地域：" . (is_array($artist->prefecture) ? implode('・', $artist->prefecture) : $artist->prefecture) . "\n");
                $shareUrl = urlencode(Request::url());
            @endphp
            <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}&hashtags=ソロアーティストマップ"
               target="_blank"
               rel="nofollow noopener"
               class="bg-black hover:opacity-80 text-white px-4 py-2 rounded-full flex items-center shadow transition">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></svg>
                <span class="text-xs font-bold">Xでシェア</span>
            </a>
        </div>

        {{-- 名前 --}}
        <h1 class="text-3xl font-bold mb-4">{{ $artist->name }}</h1>

        {{-- メイン画像 --}}
        <div class="w-full mb-6 text-center"> {{-- text-center を追加 --}}
            @if ($artist->main_photo)
                {{-- GLightbox (拡大表示) のリンク --}}
                <a href="{{ asset('storage/' . $artist->main_photo) }}" class="glightbox">
                    {{-- ★ 修正ポイント: 縦長写真対応 --}}
                    <img src="{{ asset('storage/' . $artist->main_photo) }}" 
                        {{-- object-contain: 画像全体を収める。背景は黒。 --}}
                        {{-- rounded-lg と w-full は維持 --}}
                        {{-- max-h-96: 画面の2/3程度の高さに抑える。 --}}
                        class="w-full max-h-96 object-contain rounded-lg shadow cursor-pointer bg-black">
                </a>
            @else
                <div class="w-full h-60 bg-gray-200 flex items-center justify-center rounded-lg">
                    <span class="text-gray-500">No Image</span>
                </div>
            @endif
        </div>

        {{-- サブ画像 --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            @foreach (['sub_photo_1', 'sub_photo_2'] as $photo)
                @if ($artist->$photo)
                    <a href="{{ asset('storage/' . $artist->$photo) }}" class="glightbox">
                        <img src="{{ asset('storage/' . $artist->$photo) }}"
                            class="w-full h-48 object-cover rounded-lg shadow cursor-pointer">
                    </a>
                @endif
            @endforeach
        </div>


        {{-- プロフィール情報 --}}
        <div class="space-y-4 bg-white p-6 rounded-lg shadow">
            <p class="flex items-center flex-wrap gap-2">
                <strong>活動地域：</strong>
                @if(is_array($artist->prefecture))
                    @foreach($artist->prefecture as $p)
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $p }}
                        </span>
                    @endforeach
                @else
                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ $artist->prefecture }}
                    </span>
                @endif
            </p>
            <p class="flex items-center flex-wrap gap-2">
                <strong>ジャンル：</strong>
                @if(is_array($artist->genre))
                    @foreach($artist->genre as $g)
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $g }}
                        </span>
                    @endforeach
                @else
                    {{-- 万が一、古いデータが文字列のまま残っていた場合のフォールバック --}}
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ $artist->genre }}
                    </span>
                @endif
            </p>
            {{-- <p><strong>プロフィール：</strong><br>{!! nl2br(e($artist->profile)) !!}</p> --}}
            {{-- プロフィールセクション --}}
            <p class="text-gray-700 leading-relaxed">
                <strong>プロフィール：</strong><br>
                <span class="mt-2 block">
                    {!! linkify($artist->profile) !!}
                </span>
            </p>

            @if ($artist->official_website)
                <p><strong>公式WEBサイト：</strong>
                    <a href="{{ $artist->official_website }}" class="text-blue-600 underline" target="_blank">
                        {{ $artist->official_website }}
                    </a>
                </p>
            @endif

            {{-- SNSリンク --}}
            <div class="mt-6 space-y-2">
                @if ($artist->youtube_link)
                    <p><strong>YouTube：</strong>
                        <a href="{{ $artist->youtube_link }}" class="text-red-600 underline" target="_blank">
                            {{ $artist->youtube_link }}
                        </a>
                    </p>
                @endif

                @if ($artist->soundcloud_link)
                    <p><strong>SoundCloud：</strong>
                        <a href="{{ $artist->soundcloud_link }}" class="text-orange-600 underline" target="_blank">
                            {{ $artist->soundcloud_link }}
                        </a>
                    </p>
                @endif

                @if ($artist->twitter_link)
                    <p><strong>X(Twitter)：</strong>
                        <a href="{{ $artist->twitter_link }}" class="text-blue-600 underline" target="_blank">
                            {{ $artist->twitter_link }}
                        </a>
                    </p>
                @endif

                @if ($artist->instagram_link)
                    <p><strong>Instagram：</strong>
                        <a href="{{ $artist->instagram_link }}" class="text-pink-600 underline" target="_blank">
                            {{ $artist->instagram_link }}
                        </a>
                    </p>
                @endif

                @if ($artist->tiktok_link)
                    <p><strong>TikTok：</strong>
                        <a href="{{ $artist->tiktok_link }}" class="text-black underline" target="_blank">
                            {{ $artist->tiktok_link }}
                        </a>
                    </p>
                @endif
            </div>
        </div>

        {{-- イベント一覧 --}}
        <div id="events" class="mt-10">
            <h2 class="text-2xl font-bold mb-4">ライブ・イベント一覧</h2>

            @if ($artist->events->isEmpty())
                <p class="text-gray-500">まだ登録されていません。</p>
            @else
                <div class="space-y-4">
                    @foreach ($artist->events as $event)
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-lg">{{ $event->title }}</h3>
                                <span class="text-gray-500 text-sm">
                                    {{ $event->start_at->format('Y/m/d H:i') }}
                                    @if($event->end_at)
                                        ～ {{ $event->end_at->format('H:i') }}
                                    @endif
                                </span>
                            </div>

                            @if ($event->photo)
                                <div class="my-2">
                                    <a href="{{ asset('storage/' . $event->photo) }}" class="glightbox">
                                        <img src="{{ asset('storage/' . $event->photo) }}" class="w-full h-48 object-cover rounded-lg shadow cursor-pointer">
                                    </a>
                                </div>
                            @endif

                            @if ($event->location)
                                <p><strong>場所：</strong>{{ $event->location }}</p>
                            @endif

                            @if ($event->description)
                                <p>{!! nl2br(e($event->description)) !!}</p>
                            @endif
                                <div class="flex-shrink-0 text-right mt-3 md:mt-0 mb-4">
                                    <a href="{{ route('events.show', $event->id) }}" 
                                    class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-bold text-base shadow-md transform hover:scale-105 hover:-translate-y-0.5 transition-all duration-200 group w-full md:w-auto">
                                        
                                        {{-- ボタンテキスト --}}
                                        詳細ページへ
                                        
                                        {{-- 右矢印アイコン（ホバーで右に動く） --}}
                                        <svg class="w-5 h-5 ml-2.5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </a>
                                </div>
                            @auth
                                @if (auth()->id() === $artist->user_id || auth()->user()->role === 'admin')
                                    
                                    <div class="mt-2 flex gap-2">
                                        <a href="{{ route('events.edit', [$artist, $event]) }}" class="text-blue-600 hover:underline">編集</a>
                                        <form action="{{ route('events.destroy', [$artist, $event]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">削除</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            @endif

            @auth
                @if (auth()->id() === $artist->user_id || auth()->user()->role === 'admin')
                    <div class="mt-4">
                        <a href="{{ route('events.create', $artist) }}" class="px-4 py-2 bg-green-600 text-white rounded">
                            新しいイベントを追加
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        {{-- 動画一覧 --}}
        <div class="mt-10">
            <h2 class="text-2xl font-bold mb-4">動画一覧</h2>

            @if ($videos->isEmpty())
                <p class="text-gray-500">まだ登録されていません。</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($videos as $video)
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="aspect-video mb-4">
                                <iframe
                                    src="{{ $video->youtube_url }}"
                                    class="w-full h-full rounded"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>

                            @if ($video->title)
                                <h3 class="font-semibold text-lg mb-2">{{ $video->title }}</h3>
                            @endif

                            <div class="text-sm text-gray-500">
                                登録日: {{ $video->created_at->format('Y/m/d') }}
                            </div>

                            @auth
                                @if (auth()->id() === $artist->user_id || auth()->user()->role === 'admin')
                                    <div class="mt-3 flex gap-2">
                                        <a href="{{ route('artists.videos.edit', [$artist, $video]) }}" class="text-blue-600 hover:underline text-sm">編集</a>
                                        <form action="{{ route('artists.videos.destroy', [$artist, $video]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">削除</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            @endif

            @auth
                @if (auth()->id() === $artist->user_id || auth()->user()->role === 'admin')
                    <div class="mt-4">
                        <a href="{{ route('artists.videos.create', $artist) }}" class="px-4 py-2 bg-green-600 text-white rounded">
                            新しい動画を追加
                        </a>
                    </div>
                @endif
            @endauth
        </div>


        {{-- 編集 / 削除 --}}
        @auth
            @if (auth()->id() === $artist->user_id || auth()->user()->role === 'admin')
                <div class="mt-6 mb-6 flex gap-4">
                    <a href="{{ route('artist.edit', $artist->id) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded">編集</a>

                    <form action="{{ route('artist.destroy', $artist->id) }}" method="POST"
                          onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button class="px-4 py-2 bg-red-600 text-white rounded">削除</button>
                    </form>
                </div>
            @endif
        @endauth

        {{-- DM機能 --}}
        {{-- @auth
            @if(auth()->id() != $artist->user_id)
                @php
                    $unread = \App\Models\DmMessage::where('from_user_id', $artist->user_id)
                        ->where('to_user_id', auth()->id())
                        ->where('is_read', false)
                        ->count();
                @endphp

                <a href="{{ route('dm.show', $artist->user_id) }}"
                    class="relative inline-block bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded shadow">

                    このアーティストにDMを送る

                    @if($unread > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ $unread }}
                        </span>
                    @endif
                </a>
            @endif
        @endauth --}}

    </div>
</x-app-layout>
