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
        ]);
    }

    public function home(Request $request)
    {
        $prefecture = $request->query('prefecture');
        $genre = $request->query('genre');

        $query = Artist::where('is_approved', true)->where('is_public', true);

        // 都道府県で絞り込み（指定があれば）
        if (!empty($prefecture)) {
            $query->where('prefecture', $prefecture);
        }

        // ジャンルで絞り込み（指定があれば）
        if (!empty($genre)) {
            $query->where('genre', $genre);
        }

        // 並びは新着順（必要なら変更）
        $artists = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        //新着アーティスト用(12アーティスト)
        $latestArtists = Artist::latest()->take(12)->get();

        //新着動画(10個)
        $latestVideos = ArtistVideo::with('artist')
            ->whereHas('artist', function($query) {
                $query->where('is_approved', true)->where('is_public', true);
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        //最新イベント(現在の日付に近い順)
        $upcomingEvents = Event::with('artist')
            ->whereHas('artist', function($query) {
                $query->where('is_approved', true)->where('is_public', true);
            })
            ->where('start_at', '>=', now())
            ->orderBy('start_at', 'asc')
            ->take(10)
            ->get();

        //最新イベント(登録された日付が新しい順)
        $recentEvents = Event::with('artist')
            ->whereHas('artist', function($query) {
                $query->where('is_approved', true)->where('is_public', true);
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('home', [
            'artists' => $artists,
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
        return view('artist.create');
    }

    public function store(Request $request)
    {
        // デバッグ: リクエスト情報をログに記録
        \Log::info('Artist store request', [
            'method' => $request->method(),
            'has_files' => $request->hasFile('main_photo'),
            'user_agent' => $request->userAgent(),
            'all_data' => $request->all()
        ]);

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'main_photo' => [
                'required',
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
            'prefecture' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
            'profile' => 'nullable|string|max:1000',
            'official_website' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'soundcloud_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
        ], [
            'main_photo.image' => 'メイン画像は画像ファイルを選択してください。',
            'main_photo.mimes' => 'メイン画像はJPEG、PNG、GIF、WebP形式のみ対応しています。',
            'main_photo.max' => 'メイン画像のサイズは10MB以下にしてください。',
            'main_photo.dimensions' => 'メイン画像のサイズは幅100-8000px、高さ100-8000pxの範囲にしてください。',

            'sub_photo_1.image' => 'サブ画像1は画像ファイルを選択してください。',
            'sub_photo_1.mimes' => 'サブ画像1はJPEG、PNG、GIF、WebP形式のみ対応しています。',
            'sub_photo_1.max' => 'サブ画像1のサイズは10MB以下にしてください。',
            'sub_photo_1.dimensions' => 'サブ画像1のサイズは幅100-8000px、高さ100-8000pxの範囲にしてください。',

            'sub_photo_2.image' => 'サブ画像2は画像ファイルを選択してください。',
            'sub_photo_2.mimes' => 'サブ画像2はJPEG、PNG、GIF、WebP形式のみ対応しています。',
            'sub_photo_2.max' => 'サブ画像2のサイズは10MB以下にしてください。',
            'sub_photo_2.dimensions' => 'サブ画像2のサイズは幅100-8000px、高さ100-8000pxの範囲にしてください。',

            'name.required' => 'アーティスト名は必須です。',
            'name.max' => 'アーティスト名は255文字以内で入力してください。',

            'prefecture.required' => '活動地域は必須です。',

            'profile.max' => 'プロフィールは1000文字以内で入力してください。',

            'official_website.url' => '公式ウェブサイトは正しいURL形式で入力してください。',
            'youtube_link.url' => 'YouTubeリンクは正しいURL形式で入力してください。',
            'soundcloud_link.url' => 'SoundCloudリンクは正しいURL形式で入力してください。',
            'twitter_link.url' => 'X(Twitter)リンクは正しいURL形式で入力してください。',
        ]);
        // user_id を追加
        $validated['user_id'] = auth()->id();
        \Log::info('Artist user_id set', ['user_id' => auth()->id()]);

        // ====== 画像保存処理 ======
        $paths = [];
        foreach (['main_photo', 'sub_photo_1', 'sub_photo_2'] as $photoField) {
            if ($request->hasFile($photoField)) {
                \Log::info('Processing image', ['field' => $photoField]);
                $file = $request->file($photoField);
                \Log::info('File info', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'error' => $file->getError()
                ]);

                $paths[$photoField] = $file->store('artist_photos', 'public');
                \Log::info('Image stored', ['field' => $photoField, 'path' => $paths[$photoField]]);
            }
        }

        // DB作成
        \Log::info('Creating artist in database', array_merge($validated, $paths));
        $artist = Artist::create(array_merge($validated, $paths));
        \Log::info('Artist created successfully', ['artist_id' => $artist->id]);

        return redirect()->route('dashboard')->with('success', 'アーティストの登録が完了しました！');
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
                'prefecture'   => 'required|string|max:255',
                'genre'        => 'nullable|string|max:255',
                'profile'      => 'nullable|string',
                'official_website' => 'nullable|url',
                'youtube_link' => 'nullable|url',
                'soundcloud_link' => 'nullable|url',
                'twitter_link' => 'nullable|url',
                'is_public'    => 'nullable|boolean',
            ]);
            Log::debug('Validation passed', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::debug('Validation failed', $e->errors());
            throw $e;
        }

        $validated['user_id'] = $artist->user_id; // または auth()->id()
        $validated['is_public'] = $request->has('is_public'); // チェックボックスなので明示的に設定
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
