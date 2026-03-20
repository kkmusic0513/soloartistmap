<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4">
        <h1 class="text-2xl font-bold mb-6">📢 新規お知らせ投稿</h1>

        <form action="{{ route('admin.informations.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-px-8 pt-6 pb-8 mb-4 p-8">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">タイトル</label>
                <input type="text" name="title" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring" placeholder="例：リアルイベント企画会議のお知らせ">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">カテゴリー</label>
                <select name="category" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    <option value="news">NEWS (全般)</option>
                    <option value="event">EVENT (イベント関連)</option>
                    <option value="update">UPDATE (機能更新)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">バナー画像（出演募集など）</label>
                <input type="file" name="banner_image" class="w-full">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">外部リンク（外部応募フォームや詳細URL）</label>
                <input type="url" name="external_url" class="shadow border rounded w-full py-2 px-3" placeholder="https://...">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">内容</label>
                <textarea name="content" rows="5" class="shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="お知らせの詳細を入力"></textarea>
            </div>

            <input type="hidden" name="is_public" value="1">

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition">
                    🚀 お知らせを公開する
                </button>
                <a href="/dev-links" class="text-sm text-gray-500 hover:underline">戻る</a>
            </div>
        </form>
    </div>
</x-app-layout>