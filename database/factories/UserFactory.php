<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            // id に Cognito の sub のようなランダムな文字列を生成
            'id' => (string) Str::uuid(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'avatar_url' => fake()->imageUrl(200, 200, 'people'),
            'self_introduction' => fake()->realText(50),
            // 不要なカラム（password, remember_token, email_verified_at）は削除
        ];
    }
}
