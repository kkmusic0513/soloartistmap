<x-app-layout>
    <div class="max-w-xl mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">
            YouTube動画を編集（{{ $artist->name }}）
        </h1>

        <form action="{{ route('artists.videos.update', [$artist, $video]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-semibold">動画タイトル（任意）</label>
                <input type="text" name="title" value="{{ old('title', $video->title) }}" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">YouTube URL</label>
                <input type="text" name="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" class="w-full border rounded p-2" required>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded mr-2">
                更新する
            </button>
            <a href="{{ route('artists.videos.index', $artist) }}" class="bg-gray-500 text-white px-4 py-2 rounded">
                キャンセル
            </a>
        </form>
    </div>
</x-app-layout>