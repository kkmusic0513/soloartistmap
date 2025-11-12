{{-- resources/views/artist/create.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto py-10">

        @guest
        <div class="bg-white shadow-lg rounded-lg p-6 text-center space-y-4">
            <h1 class="text-2xl font-bold mb-4">アーティスト登録にはログインが必要です</h1>
            <p class="mb-4 text-gray-700">まずはアカウントにログイン、もしくは新規登録してください。</p>
            
            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}"
                    class="inline-block bg-pink-500 hover:bg-pink-600 text-white font-semibold px-6 py-2 rounded shadow">
                    ログイン
                </a>
                <a href="{{ route('register') }}"
                    class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded shadow">
                    新規登録
                </a>
            </div>
        </div>
        @endguest


        @auth
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4 text-center">アーティスト登録フォーム</h1>

                @if(session('success'))
                    <p class="text-green-600 font-semibold mb-4 text-center">{{ session('success') }}</p>
                @endif

                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('artist.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    {{-- 名前 --}}
                    <div>
                        <label class="block font-medium mb-1">名前</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    </div>

                    {{-- 写真アップロード --}}
                    <div>
                        <label class="block font-medium mb-1">写真アップロード（複数可）</label>
                        <label for="photos"
                            class="relative z-10 cursor-pointer inline-block bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded shadow">
                            ファイルを選択
                        </label>
                        <span id="file-names" class="ml-2 text-gray-600">まだ選択されていません</span>
                        <input type="file" name="photos[]" id="photos" accept="image/*" multiple class="hidden">
                    </div>

                    <script>
                        const fileInput = document.getElementById('photos');
                        const fileNames = document.getElementById('file-names');
                        fileInput.addEventListener('change', () => {
                            const names = Array.from(fileInput.files).map(f => f.name).join(', ');
                            fileNames.textContent = names || 'まだ選択されていません';
                        });
                    </script>

                    {{-- 活動地域 --}}
                    <div>
                        <label class="block font-medium mb-1">活動地域（県名）</label>
                        <select name="prefecture" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                            <option value="">選択してください</option>
                            @foreach(config('prefectures') as $pref)
                                <option value="{{ $pref }}" {{ old('prefecture') == $pref ? 'selected' : '' }}>
                                    {{ $pref }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ジャンル --}}
                    <div>
                        <label class="block font-medium mb-1">ジャンル</label>
                        <select name="genre"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                            <option value="">選択してください</option>
                            @foreach(config('genres') as $genre)
                                <option value="{{ $genre }}" {{ old('genre') == $genre ? 'selected' : '' }}>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- プロフィール --}}
                    <div>
                        <label class="block font-medium mb-1">プロフィール</label>
                        <textarea name="profile" rows="4"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">{{ old('profile') }}</textarea>
                    </div>

                    {{-- SNSリンク --}}
                    <div>
                        <label class="block font-medium mb-1">YouTubeリンク</label>
                        <input type="url" name="youtube_link" value="{{ old('youtube_link') }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">SoundCloudリンク</label>
                        <input type="url" name="soundcloud_link" value="{{ old('soundcloud_link') }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">X(Twitter)リンク</label>
                        <input type="url" name="twitter_link" value="{{ old('twitter_link') }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    </div>

                    {{-- 送信ボタン --}}
                    <div class="text-center">
                        <button type="submit"
                            class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-6 py-2 rounded shadow">
                            登録
                        </button>
                    </div>
                </form>
            </div>
        @endauth
    </div>
</x-app-layout>
