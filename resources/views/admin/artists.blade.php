@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">アーティスト承認管理</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">ID</th>
                <th class="border p-2">アーティスト名</th>
                <th class="border p-2">メールアドレス</th>
                <th class="border p-2">ステータス</th>
                <th class="border p-2">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($artists as $artist)
                <tr>
                    <td class="border p-2">{{ $artist->id }}</td>
                    <td class="border p-2">{{ $artist->name }}</td>
                    <td class="border p-2">{{ $artist->email }}</td>
                    <td class="border p-2">
                        @if ($artist->is_approved)
                            <span class="text-green-600 font-semibold">承認済み</span>
                        @else
                            <span class="text-gray-500">未承認</span>
                        @endif
                    </td>
                    <td class="border p-2">
                        @if (!$artist->is_approved)
                            <form action="{{ route('admin.artists.approve', $artist->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                    承認
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400">－</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
