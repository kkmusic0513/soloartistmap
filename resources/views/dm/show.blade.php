<x-app-layout>
<div class="max-w-3xl mx-auto py-6">

    <a href="{{ route('dm.index') }}" 
    class="inline-block mb-4 text-blue-600 hover:underline">
        ← DM一覧に戻る
    </a>

    <h1 class="text-2xl font-bold mb-4">
        @if(!empty($toArtist))
            {{ $toArtist->name }} さんへのDM
        @else
            {{ $user->name }} さんとのDM
        @endif
    </h1>

    @if(!empty($fromArtist))
        <div class="mb-3 text-sm text-gray-600">
            あなたは「{{ $fromArtist->name }}」として送信しています。
        </div>
    @endif

    @php
        $myArtists = \App\Models\Artist::where('user_id', auth()->id())->get();
    @endphp

    {{-- ★★★ メッセージ表示枠（高さ固定 ＋ スクロール） ★★★ --}}
    <div id="dm-messages"
        class="border rounded p-4 mb-4 h-96 overflow-y-scroll bg-white shadow flex flex-col gap-3">

        @include('dm.partials.messages', ['messages' => $messages])
    </div>

    {{-- ★★★ メッセージ送信フォーム ★★★ --}}
    <form action="{{ route('dm.send', $user->id) }}" method="POST" class="mt-2">
        @csrf

        {{-- 送信元アーティスト選択 --}}
        <select name="artist_id" class="border rounded px-3 py-2 mb-3 w-full">
            <option value="">（あなたのアーティストを選択しない — ユーザー名で送信）</option>
            @foreach($myArtists as $artist)
                <option value="{{ $artist->id }}"
                    {{ (!empty($fromArtist) && $fromArtist->id == $artist->id) ? 'selected' : '' }}>
                    {{ $artist->name }}
                </option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <input type="text" name="message"
                class="flex-1 border rounded px-3 py-2"
                placeholder="メッセージを入力" required>

            <button class="bg-pink-500 text-white px-4 py-2 rounded">
                送信
            </button>
        </div>
    </form>

    {{-- 自動スクロール --}}
    <script>
        window.onload = function() {
            const box = document.getElementById("dm-messages");
            if (box) {
                box.scrollTop = box.scrollHeight;
            }
        };
    </script>
    <script>
        setInterval(() => {
            fetch("{{ route('dm.messages', $user->id) }}")
                .then(res => res.text())
                .then(html => {
                    const box = document.getElementById("dm-messages");

                    // 内容が変わったときだけ更新してスクロール
                    if (box && box.innerHTML !== html) {
                        box.innerHTML = html;
                        box.scrollTop = box.scrollHeight;
                    }
                });
        }, 1000);
    </script>



</div>
</x-app-layout>
