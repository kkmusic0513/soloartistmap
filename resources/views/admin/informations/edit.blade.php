<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4">
        <h1 class="text-2xl font-bold mb-6">📝 お知らせの編集</h1>

        <form action="{{ route('admin.informations.update', $information->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded p-8">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">タイトル</label>
                <input type="text" name="title" value="{{ old('title', $information->title) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">カテゴリー</label>
                <select name="category" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    <option value="news" {{ $information->category == 'news' ? 'selected' : '' }}>NEWS (全般)</option>
                    <option value="event" {{ $information->category == 'event' ? 'selected' : '' }}>EVENT (出演者募集・イベント)</option>
                    <option value="update" {{ $information->category == 'update' ? 'selected' : '' }}>UPDATE (機能更新)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">現在のバナー</label>
                @if($information->banner_image)
                    <img src="{{ asset('storage/' . $information->banner_image) }}" class="w-48 mb-2 rounded border">
                @endif
                <input type="file" name="banner_image" class="w-full">
                <p class="text-xs text-gray-500 mt-1">※変更する場合のみ選択してください</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">外部リンク</label>
                <input type="url" name="external_url" value="{{ old('external_url', $information->external_url) }}" class="shadow border rounded w-full py-2 px-3" placeholder="https://...">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">内容</label>
                <textarea name="content" rows="10" class="shadow border rounded w-full py-2 px-3 text-gray-700">{{ old('content', $information->content) }}</textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full transition">
                    💾 更新を保存する
                </button>
                <a href="{{ route('admin.informations.index') }}" class="text-sm text-gray-500 hover:underline">戻る</a>
            </div>
        </form>
    </div>
</x-app-layout>