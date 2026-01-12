<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">

        <h1 class="text-2xl font-bold mb-6">イベント編集: {{ $artist->name }}</h1>

        <form action="{{ route('events.update', [$artist, $event]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">イベント名</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium mb-1">詳細</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">開始日時</label>
                    <input type="datetime-local" name="start_at" value="{{ old('start_at', $event->start_at->format('Y-m-d\TH:i')) }}" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">終了日時</label>
                    <input type="datetime-local" name="end_at" value="{{ old('end_at', $event->end_at ? $event->end_at->format('Y-m-d\TH:i') : '') }}" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block font-medium mb-1">場所</label>
                <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium mb-1">写真</label>
                @if($event->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $event->photo) }}" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="photo" class="w-full">
                <p class="text-sm text-gray-500 mt-1">新しい写真を選択すると、現在の写真が置き換わります</p>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">更新</button>
                <a href="{{ route('artist.events.index', $artist) }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">キャンセル</a>
            </div>
        </form>

    </div>
</x-app-layout>