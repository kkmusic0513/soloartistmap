<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">承認済みアーティスト一覧</h1>

        @if($artists->isEmpty())
            <p class="text-gray-500">現在、登録されているアーティストはいません。</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($artists as $artist)
                    <div class="bg-white shadow rounded-lg overflow-hidden">

                        {{-- サムネイル --}}
                        @php
                            // main_photo と sub_photo_1, sub_photo_2 を配列にまとめて表示
                            $photos = array_filter([
                                $artist->main_photo,
                                $artist->sub_photo_1,
                                $artist->sub_photo_2,
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

                            {{-- ステータス --}}
                            <span class="
                                inline-block px-2 py-1 text-xs rounded 
                                @if($artist->is_approved === 1) bg-green-100 text-green-700
                                @elseif($artist->is_approved === 0) bg-yellow-100 text-yellow-700
                                @else bg-gray-200 text-gray-700
                                @endif
                            ">
                                {{ $artist->is_approved === 1 ? '公開中' : ($artist->is_approved === 0 ? '承認待ち' : '非公開') }}
                            </span>

                            {{-- 操作ボタン --}}
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('artist.edit', $artist->id) }}"
                                class="text-blue-600 hover:underline">編集</a>

                                <form action="{{ route('artist.destroy', $artist->id) }}" method="POST" 
                                    onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">削除</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
