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

        {{-- DM一覧 --}}
        @php
            $unreadTotal = \App\Models\DmMessage::where('to_user_id', auth()->id())
                ->where('is_read', false)
                ->count();
        @endphp

        {{-- <a href="{{ route('dm.index') }}" 
        class="relative inline-flex items-center bg-white p-4 mb-6 rounded-lg shadow hover:bg-gray-50 w-full">
            <span class="font-semibold text-lg">DM一覧</span>

            @if($unreadTotal > 0)
                <span class="absolute right-3 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                    {{ $unreadTotal }}
                </span>
            @endif
        </a> --}}



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
                                    @if($artist->is_approved === 1 && $artist->is_public === 1) bg-green-100 text-green-700
                                    @elseif($artist->is_approved === 1 && $artist->is_public === 0) bg-gray-200 text-gray-700
                                    @elseif($artist->is_approved === 0) bg-yellow-100 text-yellow-700
                                    @else bg-gray-200 text-gray-700
                                    @endif
                                ">
                                    @if($artist->is_approved === 1 && $artist->is_public === 1)
                                        公開中
                                    @elseif($artist->is_approved === 1 && $artist->is_public === 0)
                                        非公開
                                    @elseif($artist->is_approved === 0)
                                        承認待ち
                                    @else
                                        非公開
                                    @endif
                                </span>

                                {{-- 操作ボタン（本人 or 管理者のみ表示） --}}

                                @if (auth()->id() === $artist->user_id || auth()->user()->role === 'admin')
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <a href="{{ route('artist.edit', $artist->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-medium">編集</a>

                                        <form action="{{ route('artist.destroy', $artist->id) }}" method="POST"
                                            onsubmit="return confirm('本当に削除しますか？');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-medium">削除</button>
                                        </form>

                                        <a href="{{ route('artist.events.index', $artist) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-medium">イベントを登録/編集</a>

                                        <a href="{{ route('artists.videos.create', $artist) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm font-medium">YouTube動画を登録/編集</a>



                                        {{-- 🔥 DMボタン（相手: アーティスト作者） --}}
                                        @if (auth()->id() != $artist->user_id)
                                            <a href="{{ route('dm.show', $artist->user_id) }}"
                                                class="relative text-pink-600 hover:underline">

                                                DM

                                                {{-- 未読がある場合のみ表示 --}}
                                                @php
                                                    $unread = \App\Models\DmMessage::where('from_user_id', $artist->user_id)
                                                        ->where('to_user_id', auth()->id())
                                                        ->where('is_read', false)
                                                        ->count();
                                                @endphp

                                                @if ($unread > 0)
                                                    <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-1 rounded-full">
                                                        {{ $unread }}
                                                    </span>
                                                @endif
                                            </a>
                                        @endif

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
