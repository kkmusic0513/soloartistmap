<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AdminArtistController;
use App\Services\GmailService;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DmController;


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

// アーティストに紐づくイベント管理（ログイン・権限あり）
Route::middleware('auth')->group(function () {
    Route::get('artist/{artist}/events', [EventController::class, 'index'])->name('events.index');
    Route::get('artist/{artist}/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('artist/{artist}/events', [EventController::class, 'store'])->name('events.store');
    Route::delete('artist/{artist}/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

// DM機能
Route::middleware(['auth'])->group(function () {
    Route::get('/dm/{user}', [DmController::class, 'show'])->name('dm.show');
    Route::post('/dm/{user}', [DmController::class, 'send'])->name('dm.send');
});

// DM一覧画面
Route::middleware('auth')->group(function () {
    Route::get('/dm', [DmController::class, 'index'])->name('dm.index'); // スレッド一覧
    Route::get('/dm/{user}', [DmController::class, 'show'])->name('dm.show'); // チャット画面
    Route::post('/dm/{user}', [DmController::class, 'send'])->name('dm.send'); // メッセージ送信
    Route::get('/dm/{user}/messages', [DmController::class, 'messages'])
    ->name('dm.messages');

});



// --- 開発用リンク確認ページ ---
Route::get('/dev-links', function () {
    return view('dev-links');
})->name('dev.links');

require __DIR__.'/auth.php';