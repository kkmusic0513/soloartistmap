<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-6">

        <h2 class="text-2xl font-bold mb-4">{{ $artist->name }} の動画管理</h2>

        <a href="{{ route('artists.videos.create', $artist) }}" class="bg-pink-500 text-white px-4 py-2 rounded mb-4 inline-block">＋ 新規動画登録</a>

        @if($videos->isEmpty())
            <p class="text-gray-500">動画はまだ登録されていません。</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($videos as $video)
                    <div class="bg-white shadow rounded-lg overflow-hidden p-4">
                        <h3 class="font-semibold mb-2">{{ $video->title }}</h3>
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
        @endif
    </div>
</x-app-layout>
