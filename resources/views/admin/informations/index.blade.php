<x-app-layout>
    <div class="max-w-6xl mx-auto py-12 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">📢 お知らせ管理一覧</h1>
            <a href="{{ route('admin.informations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">＋ 新規作成</a>
        </div>

        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">日付</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">タイトル</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">カテゴリ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">操作</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($informations as $info)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $info->created_at->format('Y/m/d') }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $info->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full {{ $info->category == 'event' ? 'bg-pink-100 text-pink-600' : 'bg-blue-100 text-blue-600' }}">
                                {{ strtoupper($info->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.informations.edit', $info->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold mr-4">編集</a>
                            <form action="{{ route('admin.informations.destroy', $info->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            <a href="/dev-links" class="text-gray-500 hover:underline">← 開発用リンクに戻る</a>
        </div>
    </div>
</x-app-layout>