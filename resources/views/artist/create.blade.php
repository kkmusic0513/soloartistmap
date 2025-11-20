{{-- resources/views/artist/create.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">

        @auth
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4 text-center">アーティスト登録フォーム</h1>

            <form action="{{ route('artist.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- 名前 --}}
                <div>
                    <label class="block font-medium mb-1">名前</label>
                    <input type="text" name="name" required class="w-full border rounded px-3 py-2">
                </div>

                {{-- ★ メイン画像 --}}
                <div>
                    <label class="block font-medium mb-1">メイン画像</label>
                    <input type="file" name="main_photo" accept="image/*" required
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- ★ サブ画像1 --}}
                <div>
                    <label class="block font-medium mb-1">サブ画像 1</label>
                    <input type="file" name="sub_photo_1" accept="image/*"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- ★ サブ画像2 --}}
                <div>
                    <label class="block font-medium mb-1">サブ画像 2</label>
                    <input type="file" name="sub_photo_2" accept="image/*"
                        class="w-full border rounded px-3 py-2">
                </div>

                {{-- 活動地域 --}}
                <div>
                    <label class="block font-medium mb-1">活動地域（県名）</label>
                    <select name="prefecture" required class="w-full border rounded px-3 py-2">
                        <option value="">選択してください</option>
                        @foreach(config('prefectures') as $pref)
                            <option>{{ $pref }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- ジャンル --}}
                <div>
                    <label class="block font-medium mb-1">ジャンル</label>
                    <select name="genre" class="w-full border rounded px-3 py-2">
                        <option value="">選択してください</option>
                        @foreach(config('genres') as $genre)
                            <option>{{ $genre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- プロフィール --}}
                <div>
                    <label class="block font-medium mb-1">プロフィール</label>
                    <textarea name="profile" rows="4"
                        class="w-full border rounded px-3 py-2"></textarea>
                </div>

                {{-- SNS --}}
                <div>
                    <label class="block font-medium mb-1">YouTubeリンク</label>
                    <input type="url" name="youtube_link" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">SoundCloudリンク</label>
                    <input type="url" name="soundcloud_link" value="{{ old('soundcloud_link') }}"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">X(Twitter)リンク</label>
                    <input type="url" name="twitter_link" value="{{ old('twitter_link') }}"
                        class="w-full border rounded px-3 py-2">
                </div>

                <div class="text-center">
                    <button class="bg-pink-500 text-white px-6 py-2 rounded shadow">
                        登録
                    </button>
                </div>

            </form>
        </div>
        @endauth
    </div>
</x-app-layout>
