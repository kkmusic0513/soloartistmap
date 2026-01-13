<x-app-layout>
    <div class="max-w-4xl mx-auto px-6 py-10">

        <h1 class="text-2xl font-bold mb-6">イベント編集: {{ $artist->name }}</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.update', [$artist, $event]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium mb-1">イベント名</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full border rounded px-3 py-2" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">詳細</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">OPEN</label>
                    <div class="grid grid-cols-3 gap-2">
                        <input type="date" name="start_date" value="{{ old('start_date', $event->start_at->format('Y-m-d')) }}" class="border rounded px-2 py-2" id="start_date" required>
                        <select name="start_hour" class="border rounded px-2 py-2" required>
                            @for($i = 0; $i < 24; $i++)
                                <option value="{{ sprintf('%02d', $i) }}" {{ old('start_hour', $event->start_at->format('H')) == sprintf('%02d', $i) ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                            @endfor
                        </select>
                        <select name="start_minute" class="border rounded px-2 py-2" required>
                            @for($i = 0; $i < 60; $i++)
                                <option value="{{ sprintf('%02d', $i) }}" {{ old('start_minute', $event->start_at->format('i')) == sprintf('%02d', $i) ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                            @endfor
                        </select>
                    </div>
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('start_hour')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('start_minute')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block font-medium mb-1">START</label>
                    <div class="grid grid-cols-3 gap-2">
                        <input type="date" name="end_date" value="{{ old('end_date', $event->end_at ? $event->end_at->format('Y-m-d') : '') }}" class="border rounded px-2 py-2" id="end_date">
                        <select name="end_hour" class="border rounded px-2 py-2">
                            <option value=""></option>
                            @for($i = 0; $i < 24; $i++)
                                <option value="{{ sprintf('%02d', $i) }}" {{ old('end_hour', $event->end_at ? $event->end_at->format('H') : '') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                            @endfor
                        </select>
                        <select name="end_minute" class="border rounded px-2 py-2">
                            <option value=""></option>
                            @for($i = 0; $i < 60; $i++)
                                <option value="{{ sprintf('%02d', $i) }}" {{ old('end_minute', $event->end_at ? $event->end_at->format('i') : '') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="block font-medium mb-1">場所</label>
                <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full border rounded px-3 py-2">
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">写真</label>
                @if($event->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $event->photo) }}" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="photo" accept="image/*" class="w-full border rounded px-3 py-2">
                <p class="text-sm text-gray-600 mt-1">
                    JPEG、PNG、GIF、WebP形式 / 最大10MB / 推奨サイズ: 100x100px 以上、8000x8000px 以下
                </p>
                <p class="text-sm text-gray-500">新しい写真を選択すると、現在の写真が置き換わります</p>
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">更新</button>
                <a href="{{ route('artist.events.index', $artist) }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">キャンセル</a>
            </div>
        </form>

        <script>
            // OPENの日付が変更されたらSTARTの日付も自動的に同じにする
            document.getElementById('start_date').addEventListener('change', function() {
                document.getElementById('end_date').value = this.value;
            });
        </script>

    </div>
</x-app-layout>