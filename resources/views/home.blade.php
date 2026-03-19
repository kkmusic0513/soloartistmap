<x-app-layout>


    {{-- ピックアップアーティスト セクション --}}
    <section class="relative bg-[#131313] py-16 mb-12 [box-shadow:0_0_0_100vmax_#fff] [clip-path:inset(0_-100vmax)]">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h2 class="text-white text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
                    PICK UP ARTIST
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    今注目のソロアーティストをご紹介
                </p>
            </div>

            @if($pickupArtist)
                <div class="relative rounded-2xl overflow-hidden bg-gray-900 lg:grid lg:grid-cols-2 lg:gap-0 shadow-2xl">
                    <div class="relative h-64 sm:h-72 md:h-96 lg:h-full">
                        {{-- 画像パスは main_photo を参照 --}}
                        <img class="absolute inset-0 w-full h-full object-cover" 
                            src="{{ $pickupArtist->main_photo ? asset('storage/' . $pickupArtist->main_photo) : asset('images/default-artist.jpg') }}" 
                            alt="{{ $pickupArtist->name }}">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/50 to-transparent lg:hidden"></div>
                    </div>
                    
                    <div class="relative px-6 py-12 sm:px-12 lg:px-16 flex flex-col justify-center">
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Recommended
                            </span>
                        </div>
                        <h3 class="text-3xl font-bold text-white sm:text-4xl mb-4">{{ $pickupArtist->name }}</h3>
                        {{-- カラム名を profile に修正 --}}
                        <p class="text-lg text-gray-300 mb-8 line-clamp-3">
                            {{ $pickupArtist->profile ?? 'アーティストのプロフィールがここに表示されます。' }}
                        </p>
                        <div class="flex flex-wrap gap-4">
                            {{-- ルート名を単数形の artist.show に修正 --}}
                            <a href="{{ route('artist.show', $pickupArtist) }}" 
                            class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-white hover:bg-gray-50 transition-colors">
                                詳細プロフィールを見る
                            </a>
                            {{-- カラム名を youtube_link に修正 --}}
                            @if($pickupArtist->youtube_link)
                            <a href="{{ $pickupArtist->youtube_link }}" target="_blank"
                            class="inline-flex items-center justify-center px-5 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-white/10 transition-colors">
                                YouTubeをチェック
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- キービジュアル --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold border-l-4 border-blue-500 pl-4 mb-4">
                ソロアーティストマップについて
            </h2>
            <div
                x-data="keyVisualCarousel({ total: 3 })"
                class="relative overflow-hidden rounded-lg"
            >
                {{-- スライド全体 --}}
                <div
                    class="flex transition-transform duration-700 ease-in-out"
                    :style="`transform: translateX(-${currentTranslate}vw);`"
                >
                    {{-- キービジュアル画像1 --}}
                    <div class="flex-shrink-0" style="width: 100vw;">
                        <div class="relative" style="height: 400px;">
                            <img src="{{ asset('images/keyvisual-1.jpg') }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center text-white px-4">
                                    <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold mb-4">全国ソロアーティストマップ</h1>
                                    <p class="text-lg md:text-xl">ソロアーティストのためのプラットフォーム</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- キービジュアル画像2 --}}
                    <div class="flex-shrink-0" style="width: 100vw;">
                        <div class="relative" style="height: 400px;">
                            <img src="{{ asset('images/keyvisual-2.jpg') }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center text-white px-4">
                                    <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold mb-4">あなたの音楽を届ける</h1>
                                    <p class="text-lg md:text-xl">アーティスト登録で<br>動画作品・イベント情報を発信</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- キービジュアル画像3 --}}
                    <div class="flex-shrink-0" style="width: 100vw;">
                        <div class="relative" style="height: 400px;">
                            <img src="{{ asset('images/keyvisual-3.jpg') }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center text-white px-4">
                                    <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold mb-4">イベント・動画を共有</h1>
                                    <p class="text-lg md:text-xl">ライブ情報や作品をファンと共有</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- インジケーター --}}
                <div class="flex justify-center mt-4 space-x-3 mb-4">
                    <template x-for="i in total">
                        <button
                            @click="goToSlide(i - 1)"
                            class="w-3 h-3 rounded-full transition-all duration-300"
                            :class="currentIndex === (i - 1) ? 'bg-white scale-125' : 'bg-white bg-opacity-50'"
                        ></button>
                    </template>
                </div>

                <div class="bg-[#252525] mb-10 p-8 rounded-2xl shadow-xl text-white">
                    <h2 class="text-2xl font-bold mb-4 flex items-center">
                        全国ソロアーティストマップへようこそ！
                    </h2>
                    <p class="text-lg leading-relaxed opacity-90">
                        ここは、一人で活動する表現者たちが主役のプラットフォームです。<br>
                        「自分のホームページを持つのは大変だけど、ライブ情報や動画をまとめておきたい」<br>
                        そんなアーティストの願いを一箇所で叶えます。<br>
                        現在は、「一人で」活動している方のみの登録をお願いします。
                    </p>
                </div>
            </div>
        </div>

    
        
        <h2 class="text-xl font-bold border-l-4 border-blue-500 pl-4 mb-4">新着アーティスト</h2>

        <div x-data="carousel({ total: {{ $latestArtists->count() }} })" class="top-slide relative mb-6">
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

    function keyVisualCarousel({ total }) {
        return {
            total,
            currentIndex: 0,
            currentTranslate: 0,
            autoSlideInterval: null,

            init() {
                this.startAutoSlide();
            },

            updateTranslate() {
                this.currentTranslate = this.currentIndex * 100; // 100vw単位で移動
            },

            next() {
                this.currentIndex = (this.currentIndex + 1) % this.total;
                this.updateTranslate();
            },

            goToSlide(index) {
                this.currentIndex = index;
                this.updateTranslate();
                this.resetAutoSlide();
            },

            startAutoSlide() {
                this.autoSlideInterval = setInterval(() => this.next(), 5000);
            },

            resetAutoSlide() {
                this.stopAutoSlide();
                this.startAutoSlide();
            },

            stopAutoSlide() {
                if (this.autoSlideInterval) {
                    clearInterval(this.autoSlideInterval);
                }
            }
        }
    }
    </script>

    {{-- 最新動画 セクション（フルワイド背景） --}}
    <section class="relative bg-[#252525] py-12 mb-12 [box-shadow:0_0_0_100vmax_#252525] [clip-path:inset(0_-100vmax)]">
        {{-- コンテンツ部分は中央揃えの最大幅を維持 --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-white text-xl font-bold border-l-4 border-blue-500 pl-4 mb-4">最新動画</h2>
                <a href="{{ route('videos.index') }}" class="text-white text-sm font-medium transition">
                    もっと見る →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestVideos as $video)
                    {{-- カード自体も少しダークにして、動画が浮き立つように調整 --}}
                    <div class="bg-[#ffffff] shadow-xl rounded-lg p-3 group transition-transform hover:-translate-y-1">
                        
                        <div class="overflow-hidden rounded shadow-inner">
                            <iframe class="w-full aspect-video"
                                src="{{ $video->youtube_url }}"
                                title="{{ $video->title }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('artist.show', $video->artist) }}" class="font-semibold text-blue-400 hover:text-blue-300 transition-colors">
                                {{ $video->artist->name }}
                            </a>
                            @if($video->title)
                                <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $video->title }}</p>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold border-l-4 border-blue-500 pl-4 mb-4">最新イベント（開催日順）</h2>
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
                            <a href="{{ route('events.show', $event) }}" class="block border rounded p-4 bg-white shadow hover:shadow-lg transition-shadow">
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
        @endif

    </div>

    <section class="relative bg-[#e5e7eb] py-12 [box-shadow:0_0_0_100vmax_#2d2d2d] [clip-path:inset(0_-100vmax)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-xl font-bold border-l-4 border-blue-500 pl-4 mb-4">最新イベント（登録日順）</h2>

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
                                <a href="{{ route('events.show', $event) }}" class="block border rounded p-4 bg-white shadow hover:shadow-lg transition-shadow">
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
            @endif
        </div>
    </section>


    {{-- <h1 class="text-3xl font-bold text-gray-800 mb-6">アーティスト一覧</h1> --}}

    <section id="artist-list" class="relative bg-[#252525] py-12 [box-shadow:0_0_0_100vmax_#252525] [clip-path:inset(0_-100vmax)]">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-white text-xl font-bold border-l-4 border-blue-500 pl-4 mb-4">登録アーティスト</h2>

            {{-- 絞り込みフォーム --}}
            <form method="GET" action="{{ route('home') }}#artist-list" class="mb-6 bg-white p-4 rounded shadow">
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
                        {{-- ジャンル（検索用セレクトボックス） --}}
                        <select name="genre" class="w-full border px-2 py-1 rounded">
                            <option value="">すべて</option>
                            @foreach($genres as $g)
                                {{-- $selected_genre と一致するか判定 --}}
                                <option value="{{ $g }}" @selected($selected_genre === $g)>
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
                                    <p class="text-sm text-gray-600">
                                        {{-- 都道府県の表示修正 --}}
                                        @if(is_array($artist->prefecture))
                                            {{ implode('・', $artist->prefecture) }}
                                        @else
                                            {{ $artist->prefecture }}
                                        @endif / 
                                        {{ is_array($artist->genre) ? implode(', ', $artist->genre) : $artist->genre }}
                                    </p>
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
    </section>
</x-app-layout>
