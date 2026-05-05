<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 既存のusersテーブルを一旦削除して作り直す、または構成を大きく変える場合
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            // Cognitoのsub(UUID)を主キーにする
            $table->string('id')->primary();

            $table->string('name');
            $table->string('email')->unique(); // 検索・通知用に保持（トークンから同期）
            $table->string('avatar_url')->nullable();
            $table->text('self_introduction')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
