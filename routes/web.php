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
use App\Http\Controllers\ArtistVideoController;



// --- TOPページ ---
Route::get('/', [ArtistController::class, 'home'])->name('home');
Route::get('/videos', [ArtistController::class, 'videos'])->name('videos.index');
Route::get('/events', [ArtistController::class, 'events'])->name('events.index');
Route::get('/help', function () {
    return view('help');
})->name('help');

// --- ダッシュボード ---
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- 管理用ルート ---
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/artists', [AdminArtistController::class, 'index'])->name('admin.artists.index');
    Route::post('/artists/{id}/approve', [AdminArtistController::class, 'approve'])->name('admin.artists.approve');
    Route::post('/artists/{id}/disapprove', [AdminArtistController::class, 'disapprove'])->name('admin.artists.disapprove');
});

// --- アーティストルート ---
// show 以外を auth にする
Route::resource('artist', ArtistController::class)
    ->except(['show'])
    ->middleware('auth');

// show だけ公開
Route::get('/artist/{artist}', [ArtistController::class, 'show'])
    ->name('artist.show');

// イベント単一ページ（公開）
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// アーティストに紐づくイベント管理（ログイン・権限あり）
Route::middleware('auth')->group(function () {
    Route::get('artist/{artist}/events', [EventController::class, 'index'])->name('artist.events.index');
    Route::get('artist/{artist}/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('artist/{artist}/events', [EventController::class, 'store'])->name('events.store');
    Route::get('artist/{artist}/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('artist/{artist}/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('artist/{artist}/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});
// アーティストに紐づく動画管理
Route::resource('artists.videos', ArtistVideoController::class)
    ->middleware('auth');


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