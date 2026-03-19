<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>開発用リンク一覧</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #fafafa;
            padding: 2rem;
            line-height: 1.8;
        }
        h1 {
            color: #333;
            margin-bottom: 1rem;
        }
        a {
            display: block;
            padding: 0.6rem 1rem;
            margin: 0.4rem 0;
            background: #fff;
            border-radius: 8px;
            text-decoration: none;
            color: #007BFF;
            border: 1px solid #ddd;
            transition: all 0.2s ease;
        }
        a:hover {
            background: #007BFF;
            color: #fff;
        }
        section {
            margin-bottom: 2rem;
        }
        h2 {
            color: #555;
            border-left: 4px solid #007BFF;
            padding-left: 0.5rem;
        }
    </style>
</head>
<body>
    <h1>🔧 開発用リンク一覧</h1>

    <section>
        <h2>🎛 管理用</h2>
        <a href="{{ route('admin.artists.index') }}">アーティスト管理一覧</a>
        <p style="margin-left:1rem; color:#888;">※承認ボタンテスト用は別途POST</p>
    </section>

    <section>
        <h2>👤 一般ユーザー用</h2>
        <a href="{{ route('artist.create') }}">アーティスト登録フォーム</a>
    </section>

</body>
</html>
