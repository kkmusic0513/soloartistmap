<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-6">

        {{-- 戻るボタン --}}
        <div class="mb-4">
            <a href="{{ route('dashboard') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow">
               ← ダッシュボードに戻る
            </a>
        </div>

        <h1 class="text-2xl font-bold mb-6">
            YouTube動画管理（{{ $artist->name }}）
        </h1>

        {{-- 現在の動画一覧 --}}
        @if($videos->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">登録済み動画</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($videos as $video)
                        <div class="bg-white shadow rounded-lg overflow-hidden p-4">
                            <h3 class="font-semibold mb-2">{{ $video->title ?: '無題' }}</h3>
                            <iframe width="100%" height="200" src="{{ $video->youtube_url }}" frameborder="0" allowfullscreen></iframe>

                            <div class="mt-2 flex gap-2">
                                <a href="{{ route('artists.videos.edit', [$artist, $video]) }}" class="text-blue-600 hover:underline">編集</a>

                                <form action="{{ route('artists.videos.destroy', [$artist, $video]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">削除</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 新規登録フォーム --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">新規動画登録</h2>

            <form action="{{ route('artists.videos.store', $artist) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">動画タイトル（任意）</label>
                    <input type="text" name="title" class="w-full border rounded p-2" value="{{ old('title') }}">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">YouTube URL</label>
                    <input type="text" name="youtube_url" class="w-full border rounded p-2" required value="{{ old('youtube_url') }}">
                </div>

                <button class="bg-pink-600 text-white px-4 py-2 rounded">
                    登録する
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
