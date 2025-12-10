<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Artist;
use App\Models\User;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存ユーザーを取得
        $users = User::all();

        if ($users->count() === 0) {
            $users = collect([
                User::create([
                    'name' => 'ダミーユーザー',
                    'email' => 'dummy@example.com',
                    'password' => bcrypt('password'),
                ])
            ]);
        }

        // Seeder 用のダミー画像（database/seeders/dummy_images/ に配置しておく）
        $dummyImages = collect(Storage::disk('seeders')->files('dummy_images'));

        for ($i = 1; $i <= 20; $i++) {

            // ランダムな画像ファイルを選ぶ
            $randomImage = $dummyImages->random();

            // 保存先（アップロードと同じパス）
            $newName = 'artist_photos/' . Str::random(40) . '.jpg';

            // storage/app/seeders/dummy_images → storage/app/public/artist_photos へコピー
            Storage::disk('public')->put(
                $newName,
                Storage::disk('seeders')->get($randomImage)
            );

            Artist::create([
                'user_id'        => $users->random()->id,
                'name'           => "テストアーティスト $i",
                'prefecture'     => Arr::random(config('prefectures')),
                'genre'          => Arr::random(config('genres')),
                'profile'        => "テストアーティスト{$i}のプロフィールテキストです。",
                'official_website' => null,
                'main_photo'     => $newName,  // ← 本物と同じ形式のパスが入る
                'sub_photo_1'    => null,
                'sub_photo_2'    => null,
                'photos'         => json_encode([]),
                'youtube_link'   => null,
                'soundcloud_link'=> null,
                'twitter_link'   => null,
                'is_approved'    => 1,
            ]);
        }
    }
}
