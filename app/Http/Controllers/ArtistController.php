<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Artist;
use App\Mail\ArtistApprovedMail;
use App\Models\ArtistPhoto;
use Intervention\Image\Facades\Image;

class ArtistController extends Controller
{
    public function __construct()
    {
    }
    // 登録フォーム
    public function create()
    {
        return view('artist.create');
    }

    // 登録処理（管理者通知）
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prefecture' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'profile' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'soundcloud_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'photos.*' => 'image|max:5120', // 1枚最大5MBまで
        ]);

        // アーティスト作成
        $artist = Artist::create($validated);

        // --- 写真アップロード処理 ---
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                $path = storage_path('app/public/artists/' . $filename);

                // 画像をリサイズ＆圧縮
                Image::make($photo)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 75) // JPEG品質75%
                    ->save($path);

                $photoPaths[] = 'artists/' . $filename;
            }

            // DBにパスをJSONで保存する例（Artistモデルに photos カラムを追加しておく）
            $artist->photos = json_encode($photoPaths);
            $artist->save();
        }

        // --- 登録通知（ログ出力） ---
        Log::debug("新しいアーティスト登録がありました。名前: {$artist->name}, 地域: {$artist->prefecture}");

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

    // 承認処理（アーティスト通知）
    public function approve($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->is_approved = true;
        $artist->save();

        // 承認通知（ローカルはログ、本番はSMTP）
        $recipient = $artist->email ?? 'dummy@example.com'; // email カラムがあれば本番はそこに送信
        Mail::to($recipient)->send(new ArtistApprovedMail($artist));

        return redirect()->route('artist.admin')->with('success', '承認しました。');
    }

    // 承認済みリスト（indexと同等）
    public function approvedList()
    {
        $artists = Artist::where('is_approved', true)->orderBy('created_at', 'desc')->get();
        return view('artist.approved_list', compact('artists'));
    }
    public function gallery($id)
    {
        $artist = Artist::findOrFail($id);
        return view('artist.gallery', compact('artist'));
    }
    // TOPページ用
    public function home()
    {
        $artists = Artist::where('is_approved', true)->get();
        return view('home', compact('artists'));
    }

}
