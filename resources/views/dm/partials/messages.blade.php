{{-- @forelse($messages ?? collect() as $msg)
    @php
        $displayName = $msg->fromArtist
            ? $msg->fromArtist->name
            : ($msg->fromUser->name ?? '');
    @endphp

    @if(($msg->from_user_id ?? null) == auth()->id())
        <div class="flex justify-end">
            <div class="bg-pink-100 px-3 py-2 rounded-lg max-w-xs">
                <div class="text-xs text-gray-500 mb-1">{{ $displayName }}</div>
                {{ $msg->message }}
            </div>
        </div>
    @else
        <div class="flex justify-start">
            <div class="bg-gray-200 px-3 py-2 rounded-lg max-w-xs">
                <div class="text-xs text-gray-500 mb-1">{{ $displayName }}</div>
                {{ $msg->message }}
            </div>
        </div>
    @endif

@empty
    <div class="text-gray-500">メッセージはありません。</div>
@endforelse --}}
@forelse($messages ?? collect() as $msg)
    @php
        $displayName = $msg->fromArtist
            ? $msg->fromArtist->name
            : ($msg->fromUser->name ?? '');
    @endphp

    @if(($msg->from_user_id ?? null) == auth()->id())
        <div class="flex justify-end">
            <div class="bg-pink-100 px-3 py-2 rounded-lg max-w-xs">
                <div class="text-xs text-gray-500 mb-1">{{ $displayName }}</div>

                @if($msg->image_path)
                    <div class="mb-2">
                        <a href="{{ Storage::url($msg->image_path) }}" target="_blank" rel="noopener">
                            <img src="{{ Storage::url($msg->image_path) }}" 
                                 class="rounded w-full h-auto max-w-xs">
                        </a>
                    </div>
                @endif

                @if(!empty($msg->message))
                    <div>{{ $msg->message }}</div>
                @endif
            </div>
        </div>
    @else
        <div class="flex justify-start">
            <div class="bg-gray-200 px-3 py-2 rounded-lg max-w-xs">
                <div class="text-xs text-gray-500 mb-1">{{ $displayName }}</div>

                @if($msg->image_path)
                    <div class="mb-2">
                        <a href="{{ Storage::url($msg->image_path) }}" target="_blank" rel="noopener">
                            <img src="{{ Storage::url($msg->image_path) }}" 
                                 class="rounded w-full h-auto max-w-xs">
                        </a>
                    </div>
                @endif

                @if(!empty($msg->message))
                    <div>{{ $msg->message }}</div>
                @endif
            </div>
        </div>
    @endif

@empty
    <div class="text-gray-500">メッセージはありません。</div>
@endforelse

