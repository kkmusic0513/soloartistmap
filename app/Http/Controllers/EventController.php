<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;
use Image;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    // イベント一覧（ダッシュボード用）
    public function index(Artist $artist)
    {
        $this->authorize('update', $artist); // 所有者または管理者のみ
        $events = $artist->events()->orderBy('start_at')->get();
        return view('events.index', compact('artist', 'events'));
    }

    // 作成フォーム
    public function create(Artist $artist)
    {
        $this->authorize('update', $artist);
        return view('events.create', compact('artist'));
    }

    // 保存
    public function store(Request $request, Artist $artist)
    {
        $this->authorize('update', $artist);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:5120',
        ]);

        // 画像保存
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('events', $filename, 'public');
            $validated['photo'] = $path;
        }

        $artist->events()->create($validated);

        return redirect()->route('events.index', $artist)->with('success', 'イベントを追加しました');
    }

    // 削除
    public function destroy(Artist $artist, Event $event)
    {
        $this->authorize('update', $artist);

        if ($event->photo && file_exists(storage_path('app/public/' . $event->photo))) {
            unlink(storage_path('app/public/' . $event->photo));
        }

        $event->delete();

        return redirect()->route('events.index', $artist)->with('success', 'イベントを削除しました');
    }
}
