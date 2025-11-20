<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminArtistController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        // 未承認アーティスト
        $queryPending = Artist::with('user')
            ->where('is_approved', false);

        if ($keyword) {
            $queryPending->where('name', 'like', "%{$keyword}%");
        }

        $pendingArtists = $queryPending->orderBy('id', 'desc')->paginate(20)->withQueryString();

        // 承認済みアーティスト
        $queryApproved = Artist::with('user')
            ->where('is_approved', true);

        if ($keyword) {
            $queryApproved->where('name', 'like', "%{$keyword}%");
        }

        $approvedArtists = $queryApproved->orderBy('id', 'desc')->paginate(20)->withQueryString();

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
