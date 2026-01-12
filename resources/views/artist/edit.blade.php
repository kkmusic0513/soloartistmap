<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold mb-6">アーティスト情報を編集</h1>

        <form action="{{ route('artist.update', $artist->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- 名前 --}}
            <x-input-label value="名前" />
            <x-text-input name="name" value="{{ old('name', $artist->name) }}" class="w-full mb-4" />

            {{-- ★ メイン画像 --}}
            <x-input-label value="メイン画像（現在の画像）" />
            @if ($artist->main_photo)
                <img src="{{ asset('storage/' . $artist->main_photo) }}" class="w-48 mb-2 rounded shadow">
            @endif
            <input type="file" name="main_photo" accept="image/*" class="mb-4">

            {{-- ★ サブ画像1 --}}
            <x-input-label value="サブ画像 1（現在の画像）" />
            @if ($artist->sub_photo_1)
                <img src="{{ asset('storage/' . $artist->sub_photo_1) }}" class="w-48 mb-2 rounded shadow">
            @endif
            <input type="file" name="sub_photo_1" accept="image/*" class="mb-4">

            {{-- ★ サブ画像2 --}}
            <x-input-label value="サブ画像 2（現在の画像）" />
            @if ($artist->sub_photo_2)
                <img src="{{ asset('storage/' . $artist->sub_photo_2) }}" class="w-48 mb-2 rounded shadow">
            @endif
            <input type="file" name="sub_photo_2" accept="image/*" class="mb-4">

            {{-- 活動地域 --}}
            <div>
                <label class="block font-medium mb-1">活動地域（県名）</label>
                <select name="prefecture" required class="w-full border rounded px-3 py-2">
                    <option value="">選択してください</option>
                    @foreach(config('prefectures') as $pref)
                        <option value="{{ $pref }}" 
                            {{ old('prefecture', $artist->prefecture) === $pref ? 'selected' : '' }}>
                            {{ $pref }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ジャンル --}}
            <div>
                <label class="block font-medium mb-1">ジャンル</label>
                <select name="genre" class="w-full border rounded px-3 py-2">
                    <option value="">選択してください</option>
                    @foreach(config('genres') as $genre)
                        <option value="{{ $genre }}" 
                            {{ old('genre', $artist->genre) === $genre ? 'selected' : '' }}>
                            {{ $genre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- プロフィール --}}
            <x-input-label value="プロフィール" />
            <textarea name="profile" class="w-full mb-4">{{ old('profile', $artist->profile) }}</textarea>

            <div>
                <label class="block font-medium mb-1">公式WEBサイト</label>
                <input type="url" name="official_website" 
                    value="{{ old('official_website', $artist->official_website) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- SNS --}}
            <div>
                <label class="block font-medium mb-1">YouTubeリンク</label>
                <input type="url" name="youtube_link" 
                    value="{{ old('youtube_link', $artist->youtube_link) }}"
                    class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block font-medium mb-1">SoundCloudリンク</label>
                <input type="url" name="soundcloud_link" 
                    value="{{ old('soundcloud_link', $artist->soundcloud_link) }}"
                    class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block font-medium mb-1">X(Twitter)リンク</label>
                <input type="url" name="twitter_link"
                    value="{{ old('twitter_link', $artist->twitter_link) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- 公開設定 --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <label class="flex items-center">
                    <input type="checkbox" name="is_public" value="1"
                        {{ old('is_public', $artist->is_public) ? 'checked' : '' }}
                        class="mr-3 h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                    <span class="font-medium text-gray-900">このアーティストを公開する</span>
                </label>
                <p class="text-sm text-gray-600 mt-2">
                    チェックを入れるとホームページで検索・閲覧できるようになります。
                    チェックを外すと自分のダッシュボードでのみ管理できます。
                </p>
            </div>

            <button class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded shadow mt-4">
                更新する
            </button>
        </form>

        <form action="{{ route('artist.destroy', $artist->id) }}" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-white px-4 py-2 rounded shadow"
                onclick="return confirm('本当に削除しますか？')">
                アーティストを削除する
            </button>
        </form>
    </div>
</x-app-layout>
