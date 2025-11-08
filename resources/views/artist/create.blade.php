<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アーティスト登録</title>
</head>
<body>
    <h1>アーティスト登録フォーム</h1>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('artist.store') }}" method="POST">
        @csrf
        <p>名前：<input type="text" name="name" value="{{ old('name') }}" required></p>
        <p>活動地域（県名）：
            <select name="prefecture" required>
                <option value="">選択してください</option>
                @foreach(config('prefectures') as $pref)
                    <option>{{ $pref }}</option>
                @endforeach
            </select>
        </p>
        <p>ジャンル：
            <select name="genre">
                <option value="">選択してください</option>
                @foreach(config('genres') as $genre)
                    <option value="{{ $genre }}" {{ old('genre') == $genre ? 'selected' : '' }}>
                        {{ $genre }}
                    </option>
                @endforeach
            </select>
        </p>
        <p>プロフィール：<br><textarea name="profile" rows="4">{{ old('profile') }}</textarea></p>
        <p>YouTubeリンク：<input type="url" name="youtube_link" value="{{ old('youtube_link') }}"></p>
        <p>SoundCloudリンク：<input type="url" name="soundcloud_link" value="{{ old('soundcloud_link') }}"></p>
        <p>X(Twitter)リンク：<input type="url" name="twitter_link" value="{{ old('twitter_link') }}"></p>

        <button type="submit">登録</button>
    </form>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
