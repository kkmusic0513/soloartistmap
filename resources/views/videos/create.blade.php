<x-app-layout>
    <div class="max-w-xl mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">
            YouTube動画を登録（{{ $artist->name }}）
        </h1>

        <form action="{{ route('artists.videos.store', $artist) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-semibold">動画タイトル（任意）</label>
                <input type="text" name="title" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">YouTube URL</label>
                <input type="text" name="youtube_url" class="w-full border rounded p-2" required>
            </div>

            <button class="bg-pink-600 text-white px-4 py-2 rounded">
                登録する
            </button>
        </form>
    </div>
</x-app-layout>
