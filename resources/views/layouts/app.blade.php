<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
        {{-- タイトルを動的に --}}
        {{-- <title>@yield('title', config('app.name', 'ソロアーティストマップ'))</title> --}}
        <title>全国ソロアーティストマップ（β版）|　ソロアーティスト　弾き語り　ライブ情報　シンガーソングライター　東京　大阪　名古屋</title>
        
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        {{-- 共通設定 --}}
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ Request::url() }}">
        <meta property="og:site_name" content="{{ config('app.name', 'ソロアーティストマップ') }}">
        <meta name="twitter:card" content="summary_large_image">

        {{-- ここから各ページで上書き可能にする --}}
        @hasSection('meta')
            @yield('meta')
        @else
            {{-- デフォルト設定（トップページやその他のページ用） --}}
            <meta property="og:title" content="{{ config('app.name', 'ソロアーティストマップ') }}">
            <meta property="og:description" content="ソロアーティストに特化した情報マップ。あなたの好きなアーティストを見つけよう。">
            <meta property="og:image" content="{{ asset('ogp-main.png') }}">
            <meta name="twitter:title" content="{{ config('app.name', 'ソロアーティストマップ') }}">
            <meta name="twitter:description" content="ソロアーティストに特化した情報マップ。">
            <meta name="twitter:image" content="{{ asset('ogp-main.png') }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    </head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-40C7B6T3DH"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-40C7B6T3DH');
    </script>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
        <script>
            const lightbox = GLightbox({
                selector: '.glightbox'
            });
        </script>

    </body>
</html>
