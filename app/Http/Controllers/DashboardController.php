<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\DmMessage;
use App\Models\ArtistVideo;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ユーザーが登録したアーティスト一覧
        $artists = Artist::where('user_id', $user->id)
                         ->orderBy('created_at', 'desc')
                         ->get();

        // ステータスごとの件数
        $count_public  = $artists->where('is_approved', 1)->count();
        $count_pending = $artists->where('is_approved', 0)->count();
        $count_private = 0; // 非公開機能を使う場合は別途条件追加

        // DM未読DM件数
        $dm_unread_count = DmMessage::where('to_user_id', $user->id)
                                ->where('is_read', false)
                                ->count();


        return view('dashboard', compact(
            'artists',
            'count_public',
            'count_pending',
            'count_private',
            'dm_unread_count'
        ));
    }
}
