<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold mb-4">アーティスト承認管理</h1>

        {{-- 検索フォーム --}}
        <form method="GET" class="mb-6 flex gap-2">
            <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="アーティスト名で検索"
                   class="border rounded px-3 py-2 w-full">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">検索</button>
        </form>

        {{-- 未承認アーティスト --}}
        <h2 class="text-xl font-semibold mb-2">未承認アーティスト</h2>
        @if($pendingArtists->isEmpty())
            <p class="text-gray-500 mb-4">未承認のアーティストはありません。</p>
        @else
            <table class="w-full border-collapse border border-gray-300 mb-6">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">アーティスト名</th>
                        <th class="border p-2">メールアドレス</th>
                        <th class="border p-2">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingArtists as $artist)
                        <tr>
                            <td class="border p-2">{{ $artist->id }}</td>
                            <td class="border p-2">{{ $artist->name }}</td>
                            <td class="border p-2">{{ $artist->user->email ?? '-' }}</td>
                            <td class="border p-2">
                                <form action="{{ route('admin.artists.approve', $artist->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                        承認
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- 承認済アーティスト --}}
        <h2 class="text-xl font-semibold mb-2">承認済アーティスト</h2>
        @if($approvedArtists->isEmpty())
            <p class="text-gray-500">承認済のアーティストはありません。</p>
        @else
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">ユーザー名</th>
                        <th class="border p-2">アーティスト名</th>
                        <th class="border p-2">メールアドレス</th>
                        <th class="border p-2">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($approvedArtists as $artist)
                        <tr>
                            <td class="border p-2">{{ $artist->id }}</td>
                            <td class="border p-2">{{ $artist->user->name ?? '-' }}</td>
                            <td class="border p-2">{{ $artist->name }}</td>
                            <td class="border p-2">{{ $artist->user->email ?? '-' }}</td>
                            <td class="border p-2">
                                <form action="{{ route('admin.artists.disapprove', $artist->id) }}" method="POST"
                                      onsubmit="return confirm('本当に未承認に戻しますか？');">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        未承認に戻す
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</x-app-layout>
