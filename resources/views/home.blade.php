<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">承認済みアーティスト一覧</h1>

        @if($artists->isEmpty())
            <p class="text-gray-500">現在、登録されているアーティストはいません。</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($artists as $artist)
                    <a href="{{ route('artist.gallery', $artist->id) }}" class="bg-white rounded shadow hover:shadow-lg transition overflow-hidden">
                        @if(!empty($artist->photos))
                            @php
                                $photos = json_decode($artist->photos, true);
                            @endphp
                            <img src="{{ asset('storage/' . $photos[0]) }}" alt="{{ $artist->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                        <div class="p-4">
                            <h2 class="font-bold text-lg text-gray-800">{{ $artist->name }}</h2>
                            <p class="text-gray-600">{{ $artist->prefecture }}</p>
                            @if($artist->genre)
                                <p class="text-gray-500 text-sm">{{ $artist->genre }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
