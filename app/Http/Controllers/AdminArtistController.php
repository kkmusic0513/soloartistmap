<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminArtistController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        // 未承認アーティスト
        $queryPending = Artist::with('user')
            ->where('is_approved', false);

        if ($keyword) {
            $queryPending->where('name', 'like', "%{$keyword}%");
        }

        $pendingArtists = $queryPending->orderBy('id', 'desc')->paginate(20)->withQueryString();

        // 承認済みアーティスト
        $queryApproved = Artist::with('user')
            ->where('is_approved', true);

        if ($keyword) {
            $queryApproved->where('name', 'like', "%{$keyword}%");
        }

        $approvedArtists = $queryApproved->orderBy('id', 'desc')->paginate(20)->withQueryString();

        return view('admin.artists', compact('pendingArtists', 'approvedArtists', 'keyword'));
    }

    public function approve($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->is_approved = true;
        $artist->save();

        return redirect()->route('admin.artists.index')
            ->with('success', "{$artist->name} さんを承認しました。");
    }

    public function disapprove($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->is_approved = false;
        $artist->save();

        return redirect()->route('admin.artists.index')
            ->with('success', "{$artist->name} さんを未承認に戻しました。");
    }
    /**
     * アーティストのピックアップ状態を切り替える
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function togglePickup($id)
    {
        // XSERVER環境での実行時間を考慮し、念のためfindOrFailを使用
        $artist = Artist::findOrFail($id);

        // 仕様：ピックアップは1サイトにつき1名（あるいは少数）を想定
        // もし「常に1人だけ」をピックアップしたい場合は以下のコメントアウトを解除してください
        // Artist::where('id', '!=', $id)->update(['is_pickup' => false]);

        // フラグを反転
        $artist->is_pickup = !$artist->is_pickup;
        $artist->save();

        $status = $artist->is_pickup ? 'ピックアップに設定しました' : 'ピックアップを解除しました';

        return redirect()->route('admin.artists.index')
            ->with('success', "{$artist->name} さんを{$status}。");
    }
}
