<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">

        <h1 class="text-2xl font-bold mb-6">イベント追加: {{ $artist->name }}</h1>

        <form action="{{ route('events.store', $artist) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium mb-1">イベント名</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium mb-1">詳細</label>
                <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">開始日時</label>
                    <input type="datetime-local" name="start_at" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">終了日時</label>
                    <input type="datetime-local" name="end_at" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block font-medium mb-1">場所</label>
                <input type="text" name="location" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium mb-1">写真</label>
                <input type="file" name="photo" class="w-full">
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded">追加</button>
            </div>
        </form>

    </div>
</x-app-layout>
