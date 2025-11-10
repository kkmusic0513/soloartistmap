@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-2xl font-bold">ソロアーティスト一覧</h1>

    @if ($artists->isEmpty())
        <p>まだ承認されたアーティストはいません。</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($artists as $artist)
                <div class="border rounded-lg p-4 shadow">
                    @if($artist->photos->count())
                        <div class="artist-gallery">
                            @foreach($artist->photos as $photo)
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $artist->name }}" width="200">
                            @endforeach
                        </div>
                    @endif
                    <h2 class="text-xl font-semibold">{{ $artist->name }}</h2>
                    <p class="text-gray-600">活動地域：{{ $artist->prefecture }}</p>
                    <p class="text-gray-600">ジャンル：{{ $artist->genre }}</p>
                    @if ($artist->image_path)
                        <img src="{{ asset('storage/'.$artist->image_path) }}" alt="{{ $artist->name }}" class="mt-2 rounded">
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
