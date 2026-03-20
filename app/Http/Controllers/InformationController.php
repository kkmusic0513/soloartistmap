<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function index()
    {
        // 管理者用：すべてのお知らせを取得（新しい順）
        $informations = Information::orderBy('created_at', 'desc')->get();
        return view('admin.informations.index', compact('informations'));
    }
    public function create()
    {
        // 作成画面を表示
        return view('admin.informations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|in:news,event,update',
            'content' => 'required',
            'is_public' => 'boolean',
            'external_url' => 'nullable|url', // バリデーション追加
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // バリデーション追加
        ]);

        // 画像のアップロード処理を追加
        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('banners', 'public');
            $validated['banner_image'] = $path;
        }

        Information::create($validated);

        return redirect()->route('home')->with('success', 'お知らせを公開しました！');
    }
    public function show(Information $information)
    {
        // 非公開のものは404にする（管理人は見れるようにするなら auth チェックを入れる）
        if (!$information->is_public && (!auth()->check() || auth()->user()->role !== 'admin')) {
            abort(404);
        }

        return view('informations.show', compact('information'));
    }
    public function edit(Information $information)
    {
        return view('admin.informations.edit', compact('information'));
    }

    public function update(Request $request, Information $information)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|in:news,event,update',
            'content' => 'required',
            'is_public' => 'boolean',
            'external_url' => 'nullable|url',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 画像が新しくアップロードされた場合
        if ($request->hasFile('banner_image')) {
            // 旧い画像があれば削除（手動運用の場合は残してもいいですが、掃除したほうが綺麗です）
            if ($information->banner_image) {
                \Storage::disk('public')->delete($information->banner_image);
            }
            $path = $request->file('banner_image')->store('banners', 'public');
            $validated['banner_image'] = $path;
        }

        $information->update($validated);

        return redirect()->route('admin.informations.index')->with('success', 'お知らせを更新しました！');
    }
    public function destroy(Information $information)
    {
        // 画像があればストレージからも削除（後ほど画像機能を使う時のため）
        if ($information->banner_image) {
            \Storage::disk('public')->delete($information->banner_image);
        }

        $information->delete();

        return redirect()->route('admin.informations.index')->with('success', 'お知らせを削除しました');
    }
}