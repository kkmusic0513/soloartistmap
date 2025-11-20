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
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'main_photo'   => 'nullable|image|max:5120',
            'sub_photo_1'  => 'nullable|image|max:5120',
            'sub_photo_2'  => 'nullable|image|max:5120',
            'prefecture' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'profile' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'soundcloud_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
        ]);
        // user_id を追加
        $validated['user_id'] = auth()->id();

        // ====== 画像保存処理 ======
        $paths = [];
        foreach (['main_photo', 'sub_photo_1', 'sub_photo_2'] as $photoField) {
            if ($request->hasFile($photoField)) {
                $paths[$photoField] = $request->file($photoField)->store('artist_photos', 'public');
            }
        }

        // DB作成
        $artist = Artist::create(array_merge($validated, $paths));

        return redirect()->route('artist.create')->with('success', '登録が完了しました！');
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
        // \Log::debug('update called', $request->all());
        // 確認用。これでフォームの内容が見える
        // dd($request->all()); 

        // Log::debug('Update called for artist id=' . $artist->id);
        $this->authorize('update', $artist);
        // Log::debug('Authorization passed');


        // バリデーション
        // Log::debug('Before validate');
        try {
            $validated = $request->validate([
                'name'         => 'required|string|max:255',
                'main_photo'   => 'nullable|image|max:5120',
                'sub_photo_1'  => 'nullable|image|max:5120',
                'sub_photo_2'  => 'nullable|image|max:5120',
                'prefecture'   => 'required|string|max:255',
                'genre'        => 'nullable|string|max:255',
                'profile'      => 'nullable|string',
                'youtube_link' => 'nullable|url',
                'soundcloud_link' => 'nullable|url',
                'twitter_link' => 'nullable|url',
            ]);
            Log::debug('Validation passed', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::debug('Validation failed', $e->errors());
            throw $e;
        }

        $validated['user_id'] = $artist->user_id; // または auth()->id()
        // Log::debug('After validate', $validated);

        $artistDir = storage_path('app/public/artist_photos');
        if (!file_exists($artistDir)) mkdir($artistDir, 0755, true);

        // ★画像差し替え処理
        foreach (['main_photo', 'sub_photo_1', 'sub_photo_2'] as $photoField) {
            if ($request->hasFile($photoField)) {
                // 古い画像削除
                $oldPhoto = $artist->getRawOriginal($photoField);
                if (!empty($oldPhoto) && file_exists(storage_path('app/public/' . $oldPhoto))) {
                    unlink(storage_path('app/public/' . $oldPhoto));
                }

                // 新しい画像を保存
                $file = $request->file($photoField);
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $artistDir . '/' . $filename;

                Image::make($file)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 60)
                    ->save($path);

                // パスをバリデート配列にセット
                $validated[$photoField] = 'artist_photos/' . $filename;
            }
        }

        // データ更新
        // Log::debug('Before update: ' . json_encode($artist));
        $artist->update($validated);
        // Log::debug('After update: ' . json_encode($artist->fresh()));


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
