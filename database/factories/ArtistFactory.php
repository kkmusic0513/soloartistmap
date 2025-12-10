<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'        => 1, // 適当でOK（あとで変更可能）
            'name'           => $this->faker->name(),
            'prefecture'     => $this->faker->randomElement(config('prefectures')),
            'genre'          => $this->faker->randomElement(config('genres')),
            'profile'        => $this->faker->realText(80),
            'official_website' => $this->faker->url(),
            'youtube_link'   => null,
            'soundcloud_link'=> null,
            'twitter_link'   => null,
            'is_approved'    => true,
            'main_photo'     => null,
            'sub_photo_1'    => null,
            'sub_photo_2'    => null,
        ];
    }
}
