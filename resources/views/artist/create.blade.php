{{-- resources/views/artist/create.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">

        @auth
        <div class="bg-white shadow-lg rounded-lg p-6">
            <a href="{{ route('dashboard') }}"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded shadow">
            ← ダッシュボードに戻る
            </a>
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
                    <label class="block font-medium mb-1">メイン画像 <span class="text-red-500">*</span></label>
                    <input type="file" name="main_photo" accept="image/*" required
                        class="w-full border rounded px-3 py-2">
                    <p class="text-sm text-gray-600 mt-1">
                        JPEG、PNG、GIF、WebP形式 / 最大10MB / 推奨サイズ: 100x100px 以上、8000x8000px 以下
                    </p>
                </div>

                {{-- ★ サブ画像1 --}}
                <div>
                    <label class="block font-medium mb-1">サブ画像 1</label>
                    <input type="file" name="sub_photo_1" accept="image/*"
                        class="w-full border rounded px-3 py-2">
                    <p class="text-sm text-gray-600 mt-1">
                        JPEG、PNG、GIF、WebP形式 / 最大10MB / 推奨サイズ: 100x100px 以上、8000x8000px 以下
                    </p>
                </div>

                {{-- ★ サブ画像2 --}}
                <div>
                    <label class="block font-medium mb-1">サブ画像 2</label>
                    <input type="file" name="sub_photo_2" accept="image/*"
                        class="w-full border rounded px-3 py-2">
                    <p class="text-sm text-gray-600 mt-1">
                        JPEG、PNG、GIF、WebP形式 / 最大10MB / 推奨サイズ: 100x100px 以上、8000x8000px 以下
                    </p>
                </div>

                {{-- 活動地域（複数選択可） --}}
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-3">
                        活動地域（複数選択可）
                    </label>
                    
                    {{-- 
                        grid-cols-2 (スマホ: 2列) 
                        sm:grid-cols-3 (少し広いスマホ: 3列)
                        md:grid-cols-4 (タブレット: 4列)
                        lg:grid-cols-6 (PC: 6列) 
                    --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-y-2 gap-x-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        @foreach(config('prefectures') as $pref)
                            <label class="flex items-center space-x-2 text-sm cursor-pointer hover:bg-white p-1.5 rounded transition-colors group">
                                <input type="checkbox" name="prefecture[]" value="{{ $pref }}"
                                    @checked(in_array($pref, old('prefecture', is_array($artist->prefecture ?? null) ? $artist->prefecture : ($artist->prefecture ? [$artist->prefecture] : []))))
                                    class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition cursor-pointer">
                                <span class="text-gray-700 group-hover:text-blue-700">{{ $pref }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('prefecture')
                        <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ジャンル（複数選択） --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block font-bold mb-2 text-gray-700">ジャンル（複数選択可）</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach(config('genres') as $genre)
                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-white p-1 rounded transition">
                                <input type="checkbox" name="genre[]" value="{{ $genre }}"
                                    {{ is_array(old('genre')) && in_array($genre, old('genre')) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-pink-500 focus:ring-pink-500">
                                <span class="text-sm text-gray-600">{{ $genre }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('genre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- プロフィール --}}
                <div>
                    <label class="block font-medium mb-1">プロフィール</label>
                    <textarea name="profile" rows="4"
                        class="w-full border rounded px-3 py-2"></textarea>
                    <p class="text-sm text-gray-600 mt-1">1000文字以内</p>
                </div>

                <div>
                    <label class="block font-medium mb-1">公式WEBサイト</label>
                    <input type="url" name="official_website" class="w-full border rounded px-3 py-2">
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
                <div>
                    <label class="block font-medium mb-1">Instagramリンク</label>
                    <input type="url" name="instagram_link" value="{{ old('instagram_link', $artist->instagram_link ?? '') }}"
                        placeholder="https://www.instagram.com/..."
                        class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">TikTokリンク</label>
                    <input type="url" name="tiktok_link" value="{{ old('tiktok_link', $artist->tiktok_link ?? '') }}"
                        placeholder="https://www.tiktok.com/@..."
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
