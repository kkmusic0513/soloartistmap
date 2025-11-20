<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-6">

        {{-- タイトル --}}
        <h1 class="text-2xl font-bold mb-6">ダッシュボード</h1>

        {{-- ステータスカード --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-gray-600 text-sm">公開中</p>
                <p class="text-2xl font-bold">{{ $count_public }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-gray-600 text-sm">承認待ち</p>
                <p class="text-2xl font-bold">{{ $count_pending }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-gray-600 text-sm">非公開</p>
                <p class="text-2xl font-bold">{{ $count_private }}</p>
            </div>
        </div>

        {{-- 新規追加ボタン --}}
        <div class="mb-6">
            <a href="{{ route('artist.create') }}"
               class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded shadow">
               ＋ アーティストを登録する
            </a>
        </div>

        {{-- 登録済みアーティスト一覧 --}}
        <h2 class="text-xl font-semibold mb-4">あなたの登録したアーティスト</h2>

        @if ($artists->isEmpty())
            <p class="text-gray-500">まだ登録がありません。</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($artists as $artist)
                    <div class="bg-white shadow rounded-lg overflow-hidden">

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
                            @auth
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

                                {{-- 操作ボタン（本人 or 管理者のみ表示） --}}
                            
                                @if (auth()->id() === $artist->user_id || auth()->user()->role === 'admin')
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
                                @endif
                            @endauth

                        </div>
                    </div>
                @endforeach
            </div>
        @endif


    </div>
</x-app-layout>
