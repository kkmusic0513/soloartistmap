<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use Illuminate\Support\Facades\Mail;
use App\Services\GmailService;

class ArtistController extends Controller
{
    // 登録フォーム
    public function create()
    {
        return view('artist.create');
    }

    // 登録処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prefecture' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'profile' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'soundcloud_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
        ]);

        $artist = Artist::create($validated);

        // Gmail送信
        $to = 'あなたの管理者Gmail@gmail.com';
        $subject = '【ソロアーティストマップ】新規登録通知';
        $body = "新しいアーティスト登録がありました。\n\n名前: {$artist->name}\n地域: {$artist->prefecture}";

        $gmailService->sendMail($to, $subject, $body);

        return redirect()->route('artist.create')
            ->with('success', '登録が完了しました。承認をお待ちください。');
    }

    // 一般公開（承認済のみ）
    public function index()
    {
        $artists = Artist::where('is_approved', true)->get();
        return view('artist.index', compact('artists'));
    }

    // 管理画面（全件表示）
    public function admin()
    {
        $artists = Artist::all();
        return view('admin.artists', compact('artists'));
    }

    // 承認処理
    public function approve($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->is_approved = true;
        $artist->save();

        return redirect()->route('artist.admin')->with('success', '承認しました。');
    }

    // 承認済みリスト（indexと同等）
    public function approvedList()
    {
        $artists = Artist::where('is_approved', true)->orderBy('created_at', 'desc')->get();
        return view('artist.approved_list', compact('artists'));
    }
}
