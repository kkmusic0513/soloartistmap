<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminArtistController extends Controller
{
    public function index(Request $request)
    {

        $keyword = $request->input('keyword', ''); // 空文字で初期化

        // AdminArtistController.php
        $artists = Artist::with('user') // ← これを追加
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $query = \App\Models\Artist::query();

        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        $pendingArtists = (clone $query)->where('is_approved', 0)->get();
        $approvedArtists = (clone $query)->where('is_approved', 1)->get();

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
}
