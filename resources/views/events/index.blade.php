<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">

        <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded shadow">
            ← ダッシュボードに戻る
            </a>
            <h1 class="text-2xl font-bold">イベント一覧: {{ $artist->name }}</h1>
            <a href="{{ route('events.create', $artist) }}" class="px-4 py-2 bg-pink-500 text-white rounded">＋ イベント追加</a>
        </div>

        @if($events->isEmpty())
            <p class="text-gray-500">イベントはまだ登録されていません。</p>
        @else
            <div class="space-y-4">
                @foreach($events as $event)
                    <div class="bg-white shadow rounded p-4 flex justify-between items-start">
                        <div>
                            <h2 class="font-bold text-lg">{{ $event->title }}</h2>
                            <p class="text-gray-600">{{ $event->start_at }} 〜 {{ $event->end_at ?? '-' }}</p>
                            <p class="text-gray-600">{{ $event->location }}</p>
                        </div>
                        <form action="{{ route('events.destroy', [$artist, $event]) }}" method="POST"
                              onsubmit="return confirm('削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded">削除</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
