<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory; // 1. これを追加
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    // 主キーの型を指定
    protected $keyType = 'string';

    // オートインクリメントを無効化
    public $incrementing = false;

    // タイムスタンプの自動更新を有効化（デフォルトでtrueなので、書かなくてもOKです）
    public $timestamps = true;

    protected $fillable = [
        'id', // subをここに入れる
        'name',
        'email',
        'avatar_url',
        'self_introduction',
    ];

    // パスワードは不要なので $hidden などからも除外してOK
}
