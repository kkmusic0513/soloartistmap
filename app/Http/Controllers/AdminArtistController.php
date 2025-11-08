<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class AdminArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::orderBy('created_at', 'desc')->get();
        return view('admin.artists', compact('artists'));
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
