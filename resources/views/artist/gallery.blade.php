
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $artist->name }} のギャラリー</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

<h1 class="text-3xl font-bold mb-4">{{ $artist->name }} のギャラリー</h1>

@if($artist->photos && count($artist->photos) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($artist->photos as $photo)
            <div class="bg-white p-2 rounded shadow">
                <img src="{{ asset('storage/' . $photo) }}" alt="写真" class="w-full h-48 object-cover rounded">
            </div>
        @endforeach
    </div>
@else
    <p>アップロードされた写真はありません。</p>
@endif

<a href="{{ route('artist.index') }}" class="mt-4 inline-block text-pink-500 hover:text-pink-700">戻る</a>

</body>
</html>
