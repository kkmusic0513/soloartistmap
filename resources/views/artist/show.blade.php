<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">

        {{-- 戻るボタン --}}
        <div class="mb-4">
            <a href="{{ route('home') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow">
               ← 一覧に戻る
            </a>
        </div>

        {{-- 名前 --}}
        <h1 class="text-3xl font-bold mb-4">{{ $artist->name }}</h1>

        {{-- メイン画像 --}}
        <div class="w-full mb-6">
            @if ($artist->main_photo)
                <a href="{{ asset('storage/' . $artist->main_photo) }}" class="glightbox">
                    <img src="{{ asset('storage/' . $artist->main_photo) }}" 
                        class="w-full max-h-96 object-cover rounded-lg shadow cursor-pointer">
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
            <p><strong>活動地域：</strong>{{ $artist->prefecture }}</p>
            <p><strong>ジャンル：</strong>{{ $artist->genre }}</p>
            <p><strong>プロフィール：</strong><br>{!! nl2br(e($artist->profile)) !!}</p>

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
            </div>
        </div>

        {{-- 編集 / 削除 --}}
        @auth
            @if (auth()->id() === $artist->user_id || auth()->user()->role === 'admin')
                <div class="mt-6 flex gap-4">
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

    </div>
</x-app-layout>
