<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- 戻るボタン --}}
        <div class="mb-4">
            @if(isset($artist))
                <a href="{{ route('dashboard') }}"
                   class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow">
                   ← ダッシュボードに戻る
                </a>
            @else
                <a href="{{ route('home') }}"
                   class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow">
                   ← 一覧に戻る
                </a>
            @endif
        </div>

        <div class="flex justify-between items-center mb-6">
            @if(isset($artist))
                <h1 class="text-3xl font-bold">{{ $artist->name }} のイベント管理</h1>
                <a href="{{ route('events.create', $artist) }}" class="px-4 py-2 bg-pink-500 text-white rounded">＋ イベント追加</a>
            @else
                <h1 class="text-3xl font-bold">イベントアーカイブ</h1>
            @endif
        </div>

        @if($events->isEmpty())
            @if(isset($artist))
                <p class="text-gray-500">イベントはまだ登録されていません。</p>
            @else
                <p class="text-gray-500">現在、開催予定のイベントはありません。</p>
            @endif
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @foreach($events as $event)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        @if($event->photo)
                            <img src="{{ asset('storage/' . $event->photo) }}" class="w-full h-48 object-cover">
                        @endif

                        <a href="{{ route('events.show', $event) }}" class="block hover:shadow-lg transition-shadow">
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2">{{ $event->title }}</h3>
                                @if(!isset($artist))
                                    <p class="text-blue-600 font-medium mb-2">{{ $event->artist->name }}</p>
                                @endif

                                <div class="text-sm text-gray-600 mb-2">
                                    <p>📅 {{ $event->start_at->format('Y/m/d H:i') }}</p>
                                    @if($event->end_at)
                                        <p>～ {{ $event->end_at->format('H:i') }}</p>
                                    @endif
                                </div>

                                @if($event->location)
                                    <p class="text-sm text-gray-600 mb-2">📍 {{ $event->location }}</p>
                                @endif

                                @if($event->description)
                                    <p class="text-sm text-gray-700 mb-2">{{ Str::limit($event->description, 100) }}</p>
                                @endif

                                @if(isset($artist))
                                    <div class="flex gap-2 mt-3" onclick="event.stopPropagation();">
                                        <a href="{{ route('events.edit', [$artist, $event]) }}" class="text-blue-600 hover:underline text-sm">編集</a>
                                        <form action="{{ route('events.destroy', [$artist, $event]) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">削除</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- ページネーション --}}
            <div class="mt-8">
                {{ $events->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
