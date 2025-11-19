<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold mb-6">アーティスト情報を編集</h1>

        <form action="{{ route('artist.update', $artist->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-input-label for="name" value="名前" />
            <x-text-input id="name" name="name" value="{{ old('name', $artist->name) }}" class="w-full mb-4" />

            <x-input-label for="prefecture" value="都道府県" />
            <x-text-input id="prefecture" name="prefecture" value="{{ old('prefecture', $artist->prefecture) }}" class="w-full mb-4" />

            <x-input-label for="genre" value="ジャンル" />
            <x-text-input id="genre" name="genre" value="{{ old('genre', $artist->genre) }}" class="w-full mb-4" />

            <x-input-label for="profile" value="プロフィール" />
            <textarea name="profile" id="profile" class="w-full mb-4">{{ old('profile', $artist->profile) }}</textarea>

            <x-input-label for="youtube_link" value="YouTubeリンク" />
            <x-text-input id="youtube_link" name="youtube_link" value="{{ old('youtube_link', $artist->youtube_link) }}" class="w-full mb-4" />

            <x-input-label for="photos" value="写真アップロード" />
            <input type="file" name="photos[]" multiple class="mb-4">

            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded shadow">
                更新する
            </button>
        </form>

        {{-- 削除ボタン --}}
        <form action="{{ route('artist.destroy', $artist->id) }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow"
                onclick="return confirm('本当に削除しますか？')">
                アーティストを削除する
            </button>
        </form>
    </div>
</x-app-layout>
