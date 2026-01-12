<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Http\Request;

class ArtistVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private function convertYouTubeUrl(string $url): ?string
    {
        // 動画IDを正規表現で抽出
        if (preg_match('/(?:v=|youtu\.be\/)([\w-]+)/', $url, $matches)) {
            $videoId = $matches[1];
            return 'https://www.youtube.com/embed/' . $videoId;
        }

        return null; // URLが無効な場合
    }


    public function index(Artist $artist)
    {
        $this->authorize('update', $artist);

        $videos = $artist->videos()->orderBy('created_at', 'desc')->get();

        return view('videos.index', compact('artist', 'videos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Artist $artist)
    {
        $this->authorize('update', $artist); // 本人 or admin
        $videos = $artist->videos()->orderBy('created_at', 'desc')->get();
        return view('videos.create', compact('artist', 'videos'));
    }

    public function store(Request $request, Artist $artist)
    {
        $this->authorize('update', $artist);

        $request->validate([
            'youtube_url' => 'required|string',
            'title'       => 'nullable|string|max:255',
        ]);

        // 埋め込み用URLに変換
        $embedUrl = $this->convertYouTubeUrl($request->youtube_url);
        if (!$embedUrl) {
            return back()->withErrors(['youtube_url' => '無効なYouTube URLです']);
        }

        $artist->videos()->create([
            'youtube_url' => $embedUrl,
            'title'       => $request->title,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'YouTube動画を登録しました');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist, $videoId)
    {
        $video = $artist->videos()->findOrFail($videoId);
        $this->authorize('update', $artist);

        return view('videos.edit', compact('artist', 'video'));
    }

    public function update(Request $request, Artist $artist, $videoId)
    {
        $video = $artist->videos()->findOrFail($videoId);
        $this->authorize('update', $artist);

        $request->validate([
            'youtube_url' => 'required|string',
            'title' => 'nullable|string|max:255',
        ]);

        $embedUrl = $this->convertYouTubeUrl($request->youtube_url);
        if (!$embedUrl) {
            return back()->withErrors(['youtube_url' => '無効なYouTube URLです']);
        }

        $video->update([
            'youtube_url' => $embedUrl,
            'title' => $request->title,
        ]);

        return redirect()->route('artists.videos.index', $artist)
                        ->with('success', '動画を更新しました');
    }

    public function destroy(Artist $artist, $videoId)
    {
        $video = $artist->videos()->findOrFail($videoId);
        $this->authorize('update', $artist);

        $video->delete();

        return redirect()->route('artists.videos.index', $artist)
                        ->with('success', '動画を削除しました');
    }

    

}
