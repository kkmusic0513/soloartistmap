<x-app-layout>
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6">DM一覧</h1>

        @if($threads->isEmpty())
            <p class="text-gray-500">まだメッセージはありません。</p>
        @else
            <ul class="space-y-4">
                @foreach($threads as $thread)
                    @php
                        $otherUser = $thread->user1_id == auth()->id() ? $thread->user2 : $thread->user1;
                        $latestMessage = $thread->messages->last();
                        $unreadCount = $thread->unreadCountFor(auth()->id());
                    @endphp

                    <li class="flex justify-between items-center p-4 bg-white shadow rounded-lg">
                        <a href="{{ route('dm.show', $otherUser->id) }}" class="flex-1">

                            <!-- 相手ユーザー名 -->
                            <div class="font-semibold">{{ $otherUser->name }}</div>

                            <!-- 送信アーティスト名 -->
                            @if($latestMessage->fromArtist)
                                <div class="text-xs text-gray-500">
                                    {{ $latestMessage->fromArtist->name }} として送信
                                </div>
                            @endif


                            <!-- 最新メッセージ -->
                            @if($latestMessage)
                                <div class="{{ $unreadCount > 0 ? 'font-bold' : 'text-gray-500' }} text-sm truncate">
                                    {{ $latestMessage->message }}
                                </div>
                            @endif
                        </a>

                        @if($unreadCount > 0)
                            <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </li>

                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
