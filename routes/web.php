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

// --- アーティストリソースルート ---
// Route::resource('artist', ArtistController::class)
//     ->except(['show']) // galleryを代わりに使う
//     ->middleware('auth');
Route::resource('artist', ArtistController::class)->middleware('auth');

// ギャラリー表示は別メソッド
Route::get('artist/{artist}/gallery', [ArtistController::class, 'gallery'])->name('artist.gallery');

// --- プロフィール管理 ---
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// --- 開発用リンク確認ページ ---
Route::get('/dev-links', function () {
    return view('dev-links');
})->name('dev.links');

require __DIR__.'/auth.php';