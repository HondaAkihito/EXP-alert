<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Mmo\Faker\PicsumProvider;
use Mmo\Faker\UnsplashProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // `faker` に PicsumProvider を追加
        $this->faker->addProvider(new PicsumProvider($this->faker));

        // 1️⃣ 一時ディレクトリに画像をダウンロード
        $tempPath = $this->faker->picsum(null, 640, 480); // `null` で一時フォルダに保存

        if (!$tempPath) {
            throw new \Exception("画像が生成されませんでした。ディレクトリの権限を確認してください。");
        }

        // 2️⃣ `storage/app/public/items/` に保存
        $storagePath = Str::random(10) . '.jpg'; // 10文字のランダムなファイル名を作成
        Storage::disk('public')->put('items/' . $storagePath, file_get_contents($tempPath)); // `storage/app/public/items/` に保存

        return [
            'name' => $this->faker->word(),
            'expiration_type' => $this->faker->boolean(),
            'deadline' => $this->faker->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'comment' => $this->faker->realText(10),
            'image_path' => $storagePath, // ✅ `storage/items/` に保存されたパス
            'user_id' => 1,
        ];
    }
}
