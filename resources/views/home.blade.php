<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">アーティスト一覧</h1>

        @if($artists->isEmpty())
            <p class="text-gray-500">現在、登録されているアーティストはいません。</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($artists as $artist)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <a href="{{ route('artist.show', $artist->id) }}" class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">
                            {{-- サムネイル --}}
                            @php
                                // main_photo と sub_photo_1, sub_photo_2 を配列にまとめて表示
                                $photos = array_filter([
                                    $artist->main_photo,
                                    // $artist->sub_photo_1,
                                    // $artist->sub_photo_2,
                                ]);
                            @endphp

                            @if (!empty($photos))
                                @foreach ($photos as $photo)
                                    <img src="{{ asset('storage/' . $photo) }}" class="w-full h-40 object-cover mb-2">
                                @endforeach
                            @else
                                <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif

                            {{-- カード本体 --}}
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2">{{ $artist->name }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
