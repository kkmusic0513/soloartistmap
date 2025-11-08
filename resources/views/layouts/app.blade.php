<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ソロアーティストマップ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
    <header class="bg-white shadow mb-6">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-pink-600">🎵 ソロアーティストマップ</h1>
            <nav class="space-x-4">
                <a href="{{ route('artist.index') }}" class="text-gray-700 hover:text-pink-600">アーティスト一覧</a>
                <a href="{{ route('artist.create') }}" class="text-gray-700 hover:text-pink-600">新規登録</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-6">
        @yield('content')
    </main>
</body>
</html>
