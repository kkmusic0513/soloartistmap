<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Artist;
use App\Mail\ArtistApprovedMail;
use Image;

class ArtistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'approvedList', 'home', 'gallery']);
    }

    public function create()
    {
        return view('artist.create');
    }

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
            'photos.*' => 'image|max:5120',
        ]);

        $artist = new Artist($validated);
        $artist->user_id = Auth::id();
        $artist->is_approved = false;
        $artist->save();

        $artistDir = storage_path('app/public/artists');
        if (!file_exists($artistDir)) {
            mkdir($artistDir, 0755, true);
        }

        // store メソッド内
        if ($request->hasFile('photos')) {

            $artistDir = storage_path('app/public/artists');
            if (!file_exists($artistDir)) {
                mkdir($artistDir, 0755, true);
            }

            \Log::info('アップロードファイル数: ' . count($request->file('photos')));
            

            $photoPaths = [];
            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                $path = $artistDir . '/' . $filename;

                // Intervention Image でリサイズ + 保存
                Image::make($photo)
                    ->resize(1080, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 60)
                    ->save($path);

                $photoPaths[] = 'artists/' . $filename;
            }

            $artist->photos = json_encode($photoPaths);
            $artist->save();
        }

        Log::debug("新しいアーティスト登録: {$artist->name}, ユーザーID: {$artist->user_id}");

        return redirect()->route('dashboard')->with('success', '登録が完了しました。承認をお待ちください。');
    }

    public function index()
    {
        $artists = Artist::where('is_approved', true)->get();
        return view('artist.index', compact('artists'));
    }

    public function approvedList()
    {
        $artists = Artist::where('is_approved', true)->orderBy('created_at', 'desc')->get();
        return view('artist.approved_list', compact('artists'));
    }

    public function edit(Artist $artist)
    {
        $this->authorize('update', $artist);
        return view('artist.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $this->authorize('update', $artist);

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prefecture' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'profile' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'soundcloud_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            // 'photos.*' => 'image|max:5120',
        ]);

        // アーティスト情報更新（画像は除く）
        $artist->update($validated);

        // 写真アップロード処理
        if ($request->hasFile('photos')) {
            // dd($artist->getRawOriginal('photos'));
            // DB にある元の JSON 文字列を取得
            $oldPhotosRaw = $artist->getRawOriginal('photos');

            // JSON → 配列
            $oldPhotos = is_string($oldPhotosRaw) ? json_decode($oldPhotosRaw, true) : [];

            // 配列を確認
            if (!empty($oldPhotos)) {
                foreach ($oldPhotos as $oldPath) {
                    // 配列の中身が空でない文字列かチェック
                    if (is_string($oldPath) && $oldPath !== '') {
                        $fullPath = storage_path('app/public/' . $oldPath);
                        
                        // ファイルが存在するか確認
                        if (file_exists($fullPath)) {
                            unlink($fullPath);
                        }
                    }
                }
            }


            // 2. 新しい画像を保存
            $photoPaths = [];
            $artistDir = storage_path('app/public/artists');
            if (!file_exists($artistDir)) mkdir($artistDir, 0755, true);

            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                $path = $artistDir . '/' . $filename;

                Image::make($photo)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 60)
                    ->save($path);

                $photoPaths[] = 'artists/' . $filename;
            }

            // DB 更新（casts により自動で JSON に変換）
            $artist->photos = $photoPaths;
            $artist->save();

        }

        return redirect()->route('dashboard')->with('success', 'アーティスト情報を更新しました。');
    }




    public function destroy(Artist $artist)
    {
        $this->authorize('delete', $artist);
        $artist->delete();
        return redirect()->route('dashboard')->with('success', 'アーティストを削除しました。');
    }

    public function gallery(Artist $artist)
    {
        return view('artist.gallery', compact('artist'));
    }

    public function home()
    {
        $artists = Artist::where('is_approved', true)->get();
        return view('home', compact('artists'));
    }
}
