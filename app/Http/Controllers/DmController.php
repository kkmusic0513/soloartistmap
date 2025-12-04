<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DmThread;
use App\Models\DmMessage;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DmController extends Controller
{
    // スレッド一覧（自分が参加しているスレッド）
    public function index()
    {
        $me = Auth::id();

        $threads = DmThread::where('user1_id', auth()->id())
            ->orWhere('user2_id', auth()->id())
            ->with(['user1', 'user2', 'messages' => function($q) {
                $q->orderBy('created_at', 'asc');
            }])
            ->get();

        $threads = $threads->sortByDesc(function($thread){
            return $thread->messages->last()->created_at ?? $thread->created_at;
        });

        return view('dm.index', compact('threads'));
    }

    /**
     * チャット画面（thread_id ベースで取得）
     *
     * @param  \App\Models\User  $user  // 会話相手ユーザー
     */
    // チャット画面（thread_idベース）。artist context を optional で受け渡します。
    public function show(User $user, Request $request)
    {
        $me = Auth::id();
        $otherId = $user->id;

        // スレッド検索 or 作成（eager load は messages を別に取得しているので不要）
        $thread = DmThread::where(function ($q) use ($me, $otherId) {
                $q->where('user1_id', $me)->where('user2_id', $otherId);
            })
            ->orWhere(function ($q) use ($me, $otherId) {
                $q->where('user1_id', $otherId)->where('user2_id', $me);
            })
            ->first();

        if (! $thread) {
            $thread = DmThread::create([
                'user1_id' => min($me, $otherId),
                'user2_id' => max($me, $otherId),
            ]);
        }

        // messages を確実に取得（空なら空コレクションになる）
        $messages = DmMessage::with(['fromArtist', 'toArtist', 'fromUser', 'toUser'])
            ->where('thread_id', $thread->id)
            ->orderBy('created_at', 'asc')
            ->get(); // ->get() は常に Collection を返す

        // 既読更新（自分宛ての未読のみ）
        DmMessage::where('thread_id', $thread->id)
            ->where('to_user_id', $me)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // fromArtist / toArtist のコンテクスト
        $fromArtist = null;
        $toArtist = null;
        if ($request->filled('from_artist_id')) {
            $fromArtist = Artist::where('id', $request->input('from_artist_id'))
                ->where('user_id', $me)
                ->first();
        }
        if ($request->filled('to_artist_id')) {
            $toArtist = Artist::where('id', $request->input('to_artist_id'))
                ->where('user_id', $otherId)
                ->first();
        }

        // ← ここが重要：ビューで使う自分のアーティスト一覧を確実に作る
        $myArtists = collect();
        if (Auth::check()) {
            // リレーションがあるなら Eloquent Collection、なければ空 collection
            $myArtists = auth()->user()->relationLoaded('artists')
                ? auth()->user()->artists
                : auth()->user()->artists()->get();
            // さらに null 防御（念のため）
            if (! $myArtists) {
                $myArtists = collect();
            }
        }

        $unreadCount = DmMessage::where('to_user_id', $me)->where('is_read', false)->count();

        // Ajax の場合は messages 部分だけ返す（既に実装しているならそのまま）
        if ($request->ajax()) {
            return view('dm.partials.messages', compact('messages'))->render();
        }

        return view('dm.show', compact('user', 'messages', 'thread', 'fromArtist', 'toArtist', 'unreadCount', 'myArtists'));
    }





    // メッセージ送信（from_artist_id, to_artist_id を受け取る）
    public function send(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            // フォーム側が name="artist_id" の場合と、以前の name="from_artist_id" の両方を許容する
            'artist_id'      => 'nullable|integer|exists:artists,id',
            'from_artist_id' => 'nullable|integer|exists:artists,id',
            'to_artist_id'   => 'nullable|integer|exists:artists,id',
        ]);

        $me = Auth::id();
        $otherId = $user->id;

        // スレッドを取得または作成（user ID を正規化して一意にする）
        $thread = DmThread::firstOrCreate([
            'user1_id' => min($me, $otherId),
            'user2_id' => max($me, $otherId),
        ]);

        // --- 送信者アーティストID の取得（フォーム側の name が artist_id か from_artist_id かの差異を吸収）
        $fromArtistId = $request->input('artist_id', $request->input('from_artist_id'));

        // 所有チェック：fromArtistId が自分のアーティストでなければ無効化（セキュリティ）
        if ($fromArtistId) {
            $ownerId = Artist::where('id', $fromArtistId)->value('user_id');
            if ($ownerId != $me) {
                $fromArtistId = null;
            }
        }

        // --- 宛先アーティストID の取得・検証
        $toArtistId = $request->input('to_artist_id');
        if ($toArtistId) {
            $ownerId = Artist::where('id', $toArtistId)->value('user_id');
            if ($ownerId != $otherId) {
                $toArtistId = null;
            }
        }

        // --- 送信テキスト整形（不要な空白を削る）
        $messageText = trim($request->input('message'));

        // 最低限の安全性チェック
        if ($messageText === '') {
            return back()->withErrors(['message' => 'メッセージが空です。']);
        }

        // 保存処理（トランザクション）
        DB::transaction(function () use ($thread, $me, $otherId, $fromArtistId, $toArtistId, $messageText) {
            DmMessage::create([
                'thread_id'       => $thread->id,
                'from_user_id'    => $me,
                'to_user_id'      => $otherId,
                'from_artist_id'  => $fromArtistId,
                'to_artist_id'    => $toArtistId,
                'message'         => $messageText,
                'is_read'         => false,
            ]);
        });

        // リダイレクトに付けるクエリ名は show() が参照している from_artist_id / to_artist_id に合わせる
        $params = [];
        if ($fromArtistId) $params['from_artist_id'] = $fromArtistId;
        if ($toArtistId)   $params['to_artist_id']   = $toArtistId;

        // UX: メッセージ欄にフォーカス / 最新までスクロールのために #dm-messages にアンカーを付ける
        // ※ Blade 側でアンカーを読み取る（location.hash）実装があれば有効
        $route = route('dm.show', array_merge([$user->id], $params)) . '#dm-messages';

        return redirect($route);
    }

    public function messages(User $user)
    {
        $me = Auth::id();
        $otherId = $user->id;

        $thread = DmThread::where(function ($q) use ($me, $otherId) {
                $q->where('user1_id', $me)->where('user2_id', $otherId);
            })
            ->orWhere(function ($q) use ($me, $otherId) {
                $q->where('user1_id', $otherId)->where('user2_id', $me);
            })
            ->first();

        if (!$thread) {
            return ''; // まだチャットしていない場合は空
        }

        $messages = DmMessage::with(['fromArtist', 'toArtist', 'fromUser', 'toUser'])
            ->where('thread_id', $thread->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('dm.partials.messages', compact('messages'))->render();
    }

}