<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            お知らせ詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 md:p-12">
                {{-- ヘッダー部分 --}}
                <header class="border-b border-gray-100 pb-6 mb-8">
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="text-sm text-gray-500">{{ $information->created_at->format('Y.m.d') }}</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                            {{ $information->category == 'event' ? 'bg-pink-100 text-pink-600' : 'bg-blue-100 text-blue-600' }}">
                            {{ $information->category == 'event' ? '出演者募集' : strtoupper($information->category) }}
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight">
                        {{ $information->title }}
                    </h1>
                </header>

                {{-- 【追加】バナー画像がある場合に表示 --}}
                @if($information->banner_image)
                    <div class="mb-10">
                        <img src="{{ asset('storage/' . $information->banner_image) }}" 
                             alt="Banner" 
                             class="w-full h-auto rounded-xl shadow-md border border-gray-100">
                    </div>
                @endif

                {{-- 本文部分 --}}
                <div class="prose prose-indigo max-w-none text-gray-700 leading-relaxed text-lg mb-10">
                    {!! nl2br(e($information->content)) !!}
                </div>

                {{-- 【追加】外部リンクがある場合、目立つアクションボタンを表示 --}}
                @if($information->external_url)
                    <div class="mb-12 p-6 bg-blue-50 rounded-2xl border border-blue-100 text-center">
                        <p class="text-blue-800 font-bold mb-4">詳細・お申し込みは以下のリンク先をご確認ください</p>
                        <a href="{{ $information->external_url }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black text-xl rounded-full transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            🔗 公式・詳細ページを開く
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                @endif

                {{-- フッター（戻るボタンなど） --}}
                <footer class="mt-12 pt-8 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-indigo-600 font-bold hover:text-indigo-800 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        トップページへ戻る
                    </a>
                    
                    @auth
                        {{-- 管理者向け：編集ボタン --}}
                        <a href="{{ route('admin.informations.edit', $information->id) }}" class="text-sm text-gray-400 hover:text-gray-600 underline">
                            このお知らせを編集
                        </a>
                    @endauth
                </footer>
            </article>
        </div>
    </div>
</x-app-layout>