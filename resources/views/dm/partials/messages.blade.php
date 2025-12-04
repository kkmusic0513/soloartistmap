@forelse($messages ?? collect() as $msg)
    @php
        $displayName = $msg->fromArtist
            ? $msg->fromArtist->name
            : ($msg->fromUser->name ?? '');
    @endphp

    @if(($msg->from_user_id ?? null) == auth()->id())
        {{-- 自分のメッセージ（右寄せ） --}}
        <div class="flex justify-end">
            <div class="bg-pink-100 px-3 py-2 rounded-lg max-w-xs">
                <div class="text-xs text-gray-500 mb-1">{{ $displayName }}</div>
                {{ $msg->message }}
            </div>
        </div>
    @else
        {{-- 相手のメッセージ（左寄せ） --}}
        <div class="flex justify-start">
            <div class="bg-gray-200 px-3 py-2 rounded-lg max-w-xs">
                <div class="text-xs text-gray-500 mb-1">{{ $displayName }}</div>
                {{ $msg->message }}
            </div>
        </div>
    @endif

@empty
    <div class="text-gray-500">メッセージはありません。</div>
@endforelse
