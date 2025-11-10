<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AdminArtistController;
use App\Services\GmailService;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// 管理用ルート
Route::get('/admin/artists', [AdminArtistController::class, 'index'])->name('admin.artists.index');
Route::post('/admin/artists/{id}/approve', [AdminArtistController::class, 'approve'])->name('admin.artists.approve');

// 一般ユーザー用
Route::get('/artist/create', [ArtistController::class, 'create'])->name('artist.create');
Route::post('/artist/store', [ArtistController::class, 'store'])->name('artist.store');
Route::get('/artist', [ArtistController::class, 'approvedList'])->name('artist.index'); // ← 承認済み一覧ページ


Route::get('/google/auth', function (GmailService $gmailService) {
    $client = $gmailService->getClient();
    $authUrl = $client->createAuthUrl();
    return redirect($authUrl);
});

Route::get('/google/callback', function (Request $request, GmailService $gmailService) {
    $client = $gmailService->getClient();
    $client->fetchAccessTokenWithAuthCode($request->code);
    $token = $client->getAccessToken();

    // ローカル用: トークン保存（DBや.env に保存する場合はここで保存）
    session(['google_token' => $token]);

    return '認証完了！これで Gmail API で送信できます';
});

Route::get('/artist/{id}/gallery', [ArtistController::class, 'gallery'])->name('artist.gallery');


//各ページ確認用
Route::get('/dev-links', function () {
    return view('dev-links');
})->name('dev.links');