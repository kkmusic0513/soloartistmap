<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <h2 class="text-xl font-bold mb-4">新着アーティスト</h2>

        <div 
            x-data="carousel({ total: {{ $latestArtists->count() }} })"
            class="top-slide relative mb-6"
        >
            {{-- スライド全体 --}}
            <div 
                class="flex transition-transform duration-500"
                :style="`transform: translateX(-${currentTranslate}px);`"
                @touchstart="startTouch($event)"
                @touchmove="moveTouch($event)"
                @touchend="endTouch()"
            >
                @foreach($latestArtists as $artist)
                    <div
                        class="px-2 flex-shrink-0"
                        :style="`width: ${itemWidth}px`"
                    >
                        <a href="{{ route('artist.show', $artist) }}" class="block border rounded p-2 bg-white shadow hover:shadow-lg transition-shadow">
                            @if($artist->main_photo)
                                <img
                                    src="{{ asset('storage/'.$artist->main_photo) }}"
                                    class="w-full h-40 object-cover rounded"
                                >
                            @endif
                            <p class="font-semibold mt-2">{{ $artist->name }}</p>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- 左右ナビ --}}
            <button 
                @click="prev()" 
                class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full p-2 hidden md:block"
            >‹</button>

            <button 
                @click="next()" 
                class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full p-2 hidden md:block"
            >›</button>

            {{-- インジケータ --}}
            <div class="flex justify-center mt-2 space-x-2">
                <template x-for="i in total">
                    <div 
                        class="w-3 h-3 rounded-full transition"
                        :class="currentIndex === (i - 1) ? 'bg-blue-600' : 'bg-gray-300'"
                    ></div>
                </template>
            </div>
        </div>

        <script>
        function carousel({ total }) {
            return {
                total,
                currentIndex: 0,
                itemWidth: 0,
                currentTranslate: 0,
                dragging: false,
                startX: 0,
                autoSlideInterval: null,

                init() {
                    this.updateItemWidth();
                    window.addEventListener('resize', () => this.updateItemWidth());
                    this.startAutoSlide();
                },

                updateItemWidth() {
                    const carousel = this.$root;
                    const containerWidth = carousel.clientWidth;

                    const w = document.documentElement.clientWidth; // ← これに変更！

                    if (w < 640) this.itemsPerView = 1;
                    else if (w < 1024) this.itemsPerView = 2;
                    else this.itemsPerView = 3;

                    this.itemWidth = Math.floor(containerWidth / this.itemsPerView);
                    this.updateTranslate();
                },

                updateTranslate() {
                    this.currentTranslate = this.currentIndex * this.itemWidth;
                },

                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.total;
                    this.updateTranslate();
                },

                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.total) % this.total;
                    this.updateTranslate();
                },

                startAutoSlide() {
                    this.autoSlideInterval = setInterval(() => this.next(), 3000);
                },

                stopAutoSlide() {
                    clearInterval(this.autoSlideInterval);
                },

                // --- スワイプ操作 ---
                startTouch(e) {
                    this.dragging = true;
                    this.startX = e.touches[0].clientX;
                    this.stopAutoSlide();
                },

                moveTouch(e) {
                    if (!this.dragging) return;
                    const diff = e.touches[0].clientX - this.startX;
                    this.currentTranslate = this.currentIndex * this.itemWidth - diff;
                },

                endTouch() {
                    if (!this.dragging) return;

                    const moved = this.startX - event.changedTouches[0].clientX;

                    if (moved > 80) this.next();
                    if (moved < -80) this.prev();

                    this.dragging = false;
                    this.updateTranslate();
                    this.startAutoSlide();
                }
            }
        }
        </script>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">最新動画</h2>
            <a href="{{ route('videos.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                もっと見る →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @foreach($latestVideos as $video)
                <div class="bg-white shadow rounded p-2">

                    <iframe class="w-full aspect-video"
                        src="{{ $video->youtube_url }}"
                        title="{{ $video->title }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>

                    <p class="font-semibold mt-2">{{ $video->artist->name }}</p>
                    @if($video->title)
                        <p class="text-sm text-gray-600">{{ $video->title }}</p>
                    @endif

                </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">最新イベント（開催日順）</h2>
            <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                もっと見る →
            </a>
        </div>

        @if($upcomingEvents->isEmpty())
            <p class="text-gray-500 mb-6">現在、開催予定のイベントはありません。</p>
        @else
            <div
                x-data="carousel({ total: {{ $upcomingEvents->count() }} })"
                class="top-slide relative mb-6"
            >
                {{-- スライド全体 --}}
                <div
                    class="flex transition-transform duration-500"
                    :style="`transform: translateX(-${currentTranslate}px);`"
                    @touchstart="startTouch($event)"
                    @touchmove="moveTouch($event)"
                    @touchend="endTouch()"
                >
                    @foreach($upcomingEvents as $event)
                        <div
                            class="px-2 flex-shrink-0"
                            :style="`width: ${itemWidth}px`"
                        >
                            <div class="border rounded p-4 bg-white shadow hover:shadow-lg transition-shadow">
                                @if($event->photo)
                                    <img src="{{ asset('storage/' . $event->photo) }}" class="w-full h-32 object-cover rounded mb-2">
                                @endif
                                <h3 class="font-semibold text-lg mb-1">{{ $event->title }}</h3>
                                <p class="font-medium text-blue-600 mb-1">{{ $event->artist->name }}</p>
                                <p class="text-sm text-gray-600 mb-1">
                                    📅 {{ $event->start_at->format('Y/m/d H:i') }}
                                    @if($event->end_at)
                                        ～ {{ $event->end_at->format('H:i') }}
                                    @endif
                                </p>
                                @if($event->location)
                                    <p class="text-sm text-gray-600 mb-1">📍 {{ $event->location }}</p>
                                @endif
                                @if($event->description)
                                    <p class="text-sm text-gray-700">{{ Str::limit($event->description, 80) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- 左右ナビ --}}
                <button
                    @click="prev()"
                    class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full p-2 hidden md:block"
                >‹</button>

                <button
                    @click="next()"
                    class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full p-2 hidden md:block"
                >›</button>

                {{-- インジケータ --}}
                <div class="flex justify-center mt-2 space-x-2">
                    <template x-for="i in total">
                        <div
                            class="w-3 h-3 rounded-full transition"
                            :class="currentIndex === (i - 1) ? 'bg-blue-600' : 'bg-gray-300'"
                        ></div>
                    </template>
                </div>
            </div>
        @endif

        <h2 class="text-xl font-bold mb-4">最新イベント（登録日順）</h2>

        @if($recentEvents->isEmpty())
            <p class="text-gray-500 mb-6">現在、登録されているイベントはありません。</p>
        @else
            <div
                x-data="carousel({ total: {{ $recentEvents->count() }} })"
                class="top-slide relative mb-6"
            >
                {{-- スライド全体 --}}
                <div
                    class="flex transition-transform duration-500"
                    :style="`transform: translateX(-${currentTranslate}px);`"
                    @touchstart="startTouch($event)"
                    @touchmove="moveTouch($event)"
                    @touchend="endTouch()"
                >
                    @foreach($recentEvents as $event)
                        <div
                            class="px-2 flex-shrink-0"
                            :style="`width: ${itemWidth}px`"
                        >
                            <div class="border rounded p-4 bg-white shadow hover:shadow-lg transition-shadow">
                                @if($event->photo)
                                    <img src="{{ asset('storage/' . $event->photo) }}" class="w-full h-32 object-cover rounded mb-2">
                                @endif
                                <h3 class="font-semibold text-lg mb-1">{{ $event->title }}</h3>
                                <p class="font-medium text-green-600 mb-1">{{ $event->artist->name }}</p>
                                <p class="text-sm text-gray-600 mb-1">
                                    📅 {{ $event->start_at->format('Y/m/d H:i') }}
                                    @if($event->end_at)
                                        ～ {{ $event->end_at->format('H:i') }}
                                    @endif
                                </p>
                                @if($event->location)
                                    <p class="text-sm text-gray-600 mb-1">📍 {{ $event->location }}</p>
                                @endif
                                @if($event->description)
                                    <p class="text-sm text-gray-700">{{ Str::limit($event->description, 80) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- 左右ナビ --}}
                <button
                    @click="prev()"
                    class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full p-2 hidden md:block"
                >‹</button>

                <button
                    @click="next()"
                    class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full p-2 hidden md:block"
                >›</button>

                {{-- インジケータ --}}
                <div class="flex justify-center mt-2 space-x-2">
                    <template x-for="i in total">
                        <div
                            class="w-3 h-3 rounded-full transition"
                            :class="currentIndex === (i - 1) ? 'bg-blue-600' : 'bg-gray-300'"
                        ></div>
                    </template>
                </div>
            </div>
        @endif



        {{-- <h1 class="text-3xl font-bold text-gray-800 mb-6">アーティスト一覧</h1> --}}

        <h2 class="text-xl font-bold mb-4">登録アーティスト</h2>

        {{-- 絞り込みフォーム --}}
        <form method="GET" action="{{ route('home') }}" class="mb-6 bg-white p-4 rounded shadow">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- 都道府県 --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">活動地域</label>
                    <select name="prefecture" class="w-full border px-2 py-1 rounded">
                        <option value="">すべて</option>
                        @foreach($prefectures as $pref)
                            <option value="{{ $pref }}" @selected(($selected_prefecture ?? '') === $pref)>
                                {{ $pref }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ジャンル --}}
                <div>
                    <label class="block text-sm text-gray-600 mb-1">ジャンル</label>
                    <select name="genre" class="w-full border px-2 py-1 rounded">
                        <option value="">すべて</option>
                        @foreach($genres as $g)
                            <option value="{{ $g }}" @selected(($selected_genre ?? '') === $g)>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 検索ボタン --}}
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">
                        検索
                    </button>
                </div>
            </div>
        </form>

        @if($artists->isEmpty())
            <p class="text-gray-500">現在、登録されているアーティストはいません。</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($artists as $artist)
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <a href="{{ route('artist.show', $artist->id) }}" class="block bg-white hover:shadow-lg transition">
                            {{-- サムネイル --}}
                            @php
                                $photos = array_filter([
                                    $artist->main_photo,
                                    // $artist->sub_photo_1,
                                    // $artist->sub_photo_2,
                                ]);
                            @endphp

                            @if($artist->main_photo)
                                <img src="{{ asset('storage/' . $artist->main_photo) }}" class="w-full h-40 object-cover mb-2">
                            @endif


                            {{-- カード本体 --}}
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2">{{ $artist->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $artist->prefecture }} / {{ $artist->genre }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- ページネーション --}}
            <div class="mt-6">
                {{ $artists->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
