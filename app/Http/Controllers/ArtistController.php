<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Artist;
use App\Models\ArtistVideo;
use App\Models\Event;
use App\Models\User;
use App\Mail\ArtistApprovedMail;
use App\Models\Information;
use Image;

class ArtistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except([
            //ログインなしでも見れるリスト
            'index',
            'approvedList',
            'home',
            'show',
            'videos', // 追加
            'events', // 追加
        ]);
    }

    public function home(Request $request)
    {
        $prefecture = $request->query('prefecture');
        $genre = $request->query('genre');

        // --- 1. ベースクエリを定義（承認済み且つ公開中） ---
        $baseQuery = Artist::where('is_approved', true)->where('is_public', true);

        // --- 2. ピックアップアーティスト（ベースから1件ランダム） ---
        // 変数未定義エラーを防ぐため、ここで確実に取得
        // 1. まずピックアップフラグが立っている人を探す
        $pickupArtist = (clone $baseQuery)->where('is_pickup', true)->first();

        // 2. もし誰も選ばれていなければ、ランダムで1人出す（保険）
        if (!$pickupArtist) {
            $pickupArtist = (clone $baseQuery)->inRandomOrder()->first();
        }

        // --- 3. メインの検索一覧用 ---
        $query = (clone $baseQuery);

        // --- 0. お知らせデータの取得（追加） ---
        $informations = Information::where('is_public', true)
            ->orderBy('created_at', 'desc')
            ->take(5) // 最新5件
            ->get();

        // 都道府県で絞り込み
        if (!empty($prefecture)) {
            $query->where('prefecture', 'like', '%' . $prefecture . '%');
        }

        // ジャンルで絞り込み
        if (!empty($genre)) {
            $query->where(function($q) use ($genre) {
                $q->whereJsonContains('genre', $genre)
                  ->orWhere('genre', 'like', '%' . $genre . '%');
            });
        }

        // --- 4. 各種データの取得 ---
        $artists = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        
        $latestArtists = (clone $baseQuery)->latest()->take(12)->get();

        $latestVideos = ArtistVideo::with('artist')
            ->whereHas('artist', function($q) {
                $q->where('is_approved', true)->where('is_public', true);
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $upcomingEvents = Event::with('artist')
            ->whereHas('artist', function($q) {
                $q->where('is_approved', true)->where('is_public', true);
            })
            ->where('start_at', '>=', now())
            ->orderBy('start_at', 'asc')
            ->take(10)
            ->get();

        $recentEvents = Event::with('artist')
            ->whereHas('artist', function($q) {
                $q->where('is_approved', true)->where('is_public', true);
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('home', [
            'informations' => $informations,
            'artists' => $artists,
            'pickupArtist' => $pickupArtist, // 追加
            'latestArtists' => $latestArtists,
            'latestVideos' => $latestVideos,
            'upcomingEvents' => $upcomingEvents,
            'recentEvents' => $recentEvents,
            'prefectures' => config('prefectures'),
            'genres' => config('genres'),
            'selected_prefecture' => $prefecture,
            'selected_genre' => $genre,
        ]);
    }

    public function videos()
    {
        $videos = ArtistVideo::with('artist')
            ->whereHas('artist', function($query) {
                $query->where('is_approved', true)->where('is_public', true);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('videos.index', compact('videos'));
    }

    public function events()
    {
        $events = Event::with('artist')
            ->whereHas('artist', function($query) {
                $query->where('is_approved', true)->where('is_public', true);
            })
            ->where('start_at', '>=', now())
            ->orderBy('start_at', 'asc')
            ->paginate(20);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('artist.create', [
            'artist' => new \App\Models\Artist()
        ]);
    }

    public function store(Request $request)
    {
        // デバッグ: リクエスト情報をログに記録
        \Log::info('Artist store request', [
            'all_data' => $request->all()
        ]);

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'main_photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240|dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
            'sub_photo_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240|dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
            'sub_photo_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240|dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
            'prefecture' => 'required|array',
            'prefecture.*' => 'string',
            'genre' => 'nullable|array',
            'genre.*' => 'string|max:255',
            'profile' => 'nullable|string|max:1000',
            'official_website' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'soundcloud_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url',
            'tiktok_link'    => 'nullable|url',
            'is_public'      => 'nullable|boolean', // ← 追加
        ]);

        // 基本データの準備
        $data = $validated;
        $data['user_id'] = auth()->id();
        // 公開フラグの判定（チェックボックスが空なら0、あれば1）
        $data['is_public'] = $request->has('is_public') ? 1 : 0;

        // ====== 画像保存処理（WebP軽量化を適用） ======
        $artistDir = 'artist_photos';
        $storagePath = storage_path('app/public/' . $artistDir);
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        foreach (['main_photo', 'sub_photo_1', 'sub_photo_2'] as $photoField) {
            if ($request->hasFile($photoField)) {
                $file = $request->file($photoField);
                
                // WebPとして保存するためのファイル名生成
                $filename = time() . '_' . uniqid() . '.webp'; 
                $savePath = $storagePath . '/' . $filename;

                // Intervention Image で WebP 変換（横1200px / 画質70%）
                Image::make($file)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('webp', 70) // jpg 60% より WebP 70% の方が綺麗で軽いです
                    ->save($savePath);

                $data[$photoField] = $artistDir . '/' . $filename;
            }
        }

        // DB作成
        $artist = Artist::create($data);
        \Log::info('Artist created successfully', ['artist_id' => $artist->id]);

        return redirect()->route('dashboard')->with('success', 'アーティストの登録が完了しました！');
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
                'main_photo' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:10240', // 10MB
                    'dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
                ],
                'sub_photo_1' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:10240', // 10MB
                    'dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
                ],
                'sub_photo_2' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif,webp',
                    'max:10240', // 10MB
                    'dimensions:min_width=100,min_height=100,max_width=8000,max_height=8000',
                ],
                'prefecture' => 'required|array',
                'prefecture.*' => 'string',
                'genre' => 'nullable|array',
                'genre.*' => 'string|max:255',
                'profile'      => 'nullable|string',
                'official_website' => 'nullable|url',
                'youtube_link' => 'nullable|url',
                'soundcloud_link' => 'nullable|url',
                'twitter_link' => 'nullable|url',
                'instagram_link' => 'nullable|url',
                'tiktok_link'    => 'nullable|url',
                'delete_sub_photo_1' => 'nullable|boolean',
                'delete_sub_photo_2' => 'nullable|boolean',
                'is_public'    => 'nullable|boolean',
            ]);
            Log::debug('Validation passed', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::debug('Validation failed', $e->errors());
            throw $e;
        }

        $validated['user_id'] = $artist->user_id; // または auth()->id()
        $validated['is_public'] = $request->has('is_public'); // チェックボックスなので明示的に設定
        // 重要：チェックボックスが空の場合は空配列で上書き
        $validated['genre'] = $request->input('genre', []);
        $validated['prefecture'] = $request->input('prefecture', []);
        $validated['is_public'] = $request->has('is_public');
        // Log::debug('After validate', $validated);

        $artistDir = storage_path('app/public/artist_photos');
        if (!file_exists($artistDir)) mkdir($artistDir, 0755, true);


        // 画像削除処理
        foreach (['sub_photo_1', 'sub_photo_2'] as $field) {
            if ($request->has("delete_$field")) {
                $oldPath = $artist->getRawOriginal($field);
                // XSERVERの物理パスを指定して削除
                if ($oldPath && file_exists(storage_path('app/public/' . $oldPath))) {
                    unlink(storage_path('app/public/' . $oldPath));
                }
                // DB上のパスをクリア
                $artist->$field = null;
            }
        }

        // ★画像差し替え処理（WebP変換版）
        foreach (['main_photo', 'sub_photo_1', 'sub_photo_2'] as $photoField) {
            if ($request->hasFile($photoField)) {
                // 古い画像削除（以前のJPGやPNGも消せるように currentPath で判定）
                $oldPhoto = $artist->getRawOriginal($photoField);
                if (!empty($oldPhoto) && file_exists(storage_path('app/public/' . $oldPhoto))) {
                    unlink(storage_path('app/public/' . $oldPhoto));
                }

                // 新しい画像を WebP として保存
                $file = $request->file($photoField);
                $filename = time() . '_' . uniqid() . '.webp'; // 拡張子を強制的に webp に
                $path = $artistDir . '/' . $filename; // $artistDir は storage_path(...)

                Image::make($file)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('webp', 70) 
                    ->save($path);

                $validated[$photoField] = 'artist_photos/' . $filename;
            }
        }

        // データ更新
        // Log::debug('Before update: ' . json_encode($artist));
        $artist->update($validated);
        // Log::debug('After update: ' . json_encode($artist->fresh()));


        return redirect()->route('dashboard')->with('success', 'アーティスト情報を更新しました。');
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

    public function destroy(Artist $artist)
    {
        $this->authorize('delete', $artist);

        $files = [$artist->main_photo, $artist->sub_photo_1, $artist->sub_photo_2];

        foreach ($files as $file) {
            if (empty($file)) continue;

            // 【デバッグ】実際に判定しているフルパスをログに出す
            $fullPath = \Storage::disk('public')->path($file);
            \Log::info("削除試行中のフルパス: " . $fullPath);

            if (\Storage::disk('public')->exists($file)) {
                \Storage::disk('public')->delete($file);
                \Log::info("削除成功: " . $file);
            } else {
                // ここを通る場合、DBの文字列と実ファイルの場所がズレています
                \Log::warning("ファイルが存在しません（判定失敗）: " . $file);
            }
        }

        $artist->delete();
        return redirect()->route('dashboard')->with('success', 'アーティストを削除しました。');
    }

    public function show(Artist $artist)
    {

        // アーティストに関連する動画を取得
        $videos = $artist->videos()->orderBy('created_at', 'desc')->get();

        // 公開済みなら誰でも見れる
        if ($artist->is_approved) {
            return view('artist.show', compact('artist', 'videos'));
        }

        // ↓未承認の場合のみ制御が必要↓
        if (!auth()->check()) {
            abort(403, 'このアーティストは非公開です');
        }

        if (auth()->id() !== $artist->user_id && auth()->user()->role !== 'admin') {
            abort(403, '閲覧権限がありません');
        }

        return view('artist.show', compact('artist', 'videos'));
    }
}
