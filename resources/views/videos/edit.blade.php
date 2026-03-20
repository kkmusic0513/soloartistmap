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

            <div class="flex items-center">
                <button class="bg-blue-600 text-white px-4 py-2 rounded mr-2 hover:bg-blue-700 transition">
                    更新する
                </button>
                
                {{-- ★ ここを修正：index から create へ変更 --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <a href="{{ route('artists.videos.create', $artist) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    キャンセル
                </a>
            </div>
        </form>
    </div>
</x-app-layout>