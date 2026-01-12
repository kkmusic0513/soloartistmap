<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- 戻るボタン --}}
        <div class="mb-4">
            <a href="{{ route('home') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow">
               ← 一覧に戻る
            </a>
        </div>

        <h1 class="text-3xl font-bold mb-6">動画アーカイブ</h1>

        @if($videos->isEmpty())
            <p class="text-gray-500">動画はまだ登録されていません。</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @foreach($videos as $video)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <iframe class="w-full aspect-video"
                            src="{{ $video->youtube_url }}"
                            title="{{ $video->title }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>

                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2">{{ $video->title ?: '無題' }}</h3>
                            <p class="text-blue-600 font-medium mb-2">{{ $video->artist->name }}</p>
                            <p class="text-sm text-gray-500">登録日: {{ $video->created_at->format('Y/m/d') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ページネーション --}}
            <div class="mt-8">
                {{ $videos->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
