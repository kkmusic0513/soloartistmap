<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- 戻るボタンとシェアボタンの並び --}}
        <div class="flex justify-between items-center mb-6">
            {{-- 修正：全イベント一覧ではなく、そのアーティストの詳細ページへ戻るように変更 --}}
            <a href="{{ route('artist.show', $event->artist) }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow text-sm transition">
                ← {{ $event->artist->name }} のページに戻る
            </a>

            {{-- X シェアボタン (省略なし) --}}
            @php
                $eventDate = \Carbon\Carbon::parse($event->event_date)->format('Y年m月d日');
                $shareText = urlencode(
                    "【ソロアーティストマップ：イベント情報】\n" .
                    "イベント：{$event->title}\n" .
                    "開催日：{$eventDate}\n" .
                    "会場：{$event->venue}\n" .
                    "アーティスト：{$event->artist->name}\n"
                );
                $shareUrl = urlencode(Request::url());
            @endphp

            <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}&hashtags=ソロアーティストマップ"
               target="_blank"
               rel="nofollow noopener"
               class="bg-black hover:opacity-80 text-white px-4 py-2 rounded-full flex items-center shadow transition">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                </svg>
                <span class="text-xs font-bold">Xでシェア</span>
            </a>
        </div>

        <article class="bg-white shadow-lg rounded-lg overflow-hidden">
            {{-- イベント画像 --}}
            @if($event->photo)
                <div class="w-full flex items-center justify-center bg-gray-100 p-4">
                    <img src="{{ asset('storage/' . $event->photo) }}" class="max-w-full max-h-screen object-contain" alt="{{ $event->title }}">
                </div>
            @else
                <div class="w-full h-64 md:h-80 lg:h-96 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-lg">画像なし</span>
                </div>
            @endif

            <div class="p-6 md:p-8">
                {{-- イベントタイトル --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>

                {{-- アーティスト情報 --}}
                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <h2 class="text-lg font-semibold text-blue-900 mb-2">出演アーティスト</h2>
                    <div class="flex items-center space-x-3">
                        @if($event->artist->main_photo)
                            <img src="{{ asset('storage/' . $event->artist->main_photo) }}" class="w-12 h-12 rounded-full object-cover" alt="{{ $event->artist->name }}">
                        @endif
                        <div>
                            <a href="{{ route('artist.show', $event->artist) }}" class="text-blue-600 hover:text-blue-800 font-medium text-lg">
                                {{ $event->artist->name }}
                            </a>
                            @if($event->artist->prefecture || $event->artist->genre)
                                <p class="text-sm text-gray-600">
                                    {{-- 地域 (配列なら連結、そうでなければそのまま) --}}
                                    @if(is_array($event->artist->prefecture))
                                        {{ implode('・', $event->artist->prefecture) }}
                                    @else
                                        {{ $event->artist->prefecture }}
                                    @endif

                                    {{-- セパレーター --}}
                                    @if($event->artist->prefecture && $event->artist->genre) / @endif

                                    {{-- ジャンル (配列なら連結、そうでなければそのまま) --}}
                                    @if(is_array($event->artist->genre))
                                        {{ implode('・', $event->artist->genre) }}
                                    @else
                                        {{ $event->artist->genre }}
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- イベント詳細情報 --}}
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    {{-- 日時情報 --}}
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">📅 日時</h3>
                        <div class="space-y-2">
                            <p class="text-gray-700">
                                <span class="font-medium">開始:</span> {{ $event->start_at->format('Y年m月d日 H:i') }}
                            </p>
                            @if($event->end_at)
                                <p class="text-gray-700">
                                    <span class="font-medium">終了:</span> {{ $event->end_at->format('Y年m月d日 H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- 会場情報 --}}
                    @if($event->location)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">📍 会場</h3>
                            <p class="text-gray-700">{{ $event->location }}</p>
                        </div>
                    @endif
                </div>

                {{-- イベント説明 --}}
                @if($event->description)
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">イベント詳細</h3>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                        </div>
                    </div>
                @endif

                {{-- アクションボタン --}}
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('artist.show', $event->artist) }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow transition duration-200">
                        🎵 アーティストページを見る
                    </a>
                    {{-- 修正：全イベントではなく、アーティスト詳細のイベントセクション（アンカー）へ飛ばす --}}
                    <a href="{{ route('artist.show', $event->artist) }}#events"
                       class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow transition duration-200">
                        📅 このアーティストの他のイベント
                    </a>
                </div>
            </div>
        </article>

        {{-- 関連イベント（同じアーティストの他のイベント） --}}
        @php
            $otherEvents = $event->artist->events()
                ->where('id', '!=', $event->id)
                ->where('start_at', '>=', now())
                ->orderBy('start_at', 'asc')
                ->take(3)
                ->get();
        @endphp

        @if($otherEvents->count() > 0)
            <section class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">同じアーティストの他のイベント</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($otherEvents as $otherEvent)
                        <a href="{{ route('events.show', $otherEvent) }}" class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                            @if($otherEvent->photo)
                                <img src="{{ asset('storage/' . $otherEvent->photo) }}" class="w-full h-32 object-cover" alt="{{ $otherEvent->title }}">
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-1">{{ $otherEvent->title }}</h3>
                                <p class="text-sm text-gray-600">
                                    📅 {{ $otherEvent->start_at->format('Y/m/d H:i') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

    </div>
</x-app-layout></contents>
</xai:function_call name="write">
<parameter name="file_path">resources/views/events/show.blade.php