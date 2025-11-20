<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AdminArtistController;
use App\Services\GmailService;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

// --- TOPページ ---
Route::get('/', [ArtistController::class, 'home'])->name('home');

// --- ダッシュボード ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- 管理用ルート ---
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/artists', [AdminArtistController::class, 'index'])->name('admin.artists.index');
    Route::post('/artists/{id}/approve', [AdminArtistController::class, 'approve'])->name('admin.artists.approve');
});

// --- アーティストルート ---
// show 以外を auth にする
Route::resource('artist', ArtistController::class)
    ->except(['show'])
    ->middleware('auth');

// show だけ公開
Route::get('/artist/{artist}', [ArtistController::class, 'show'])
    ->name('artist.show');


// --- 開発用リンク確認ページ ---
Route::get('/dev-links', function () {
    return view('dev-links');
})->name('dev.links');

require __DIR__.'/auth.php';