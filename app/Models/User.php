<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // 主キーの型を指定
    protected $keyType = 'string';

    // オートインクリメントを無効化
    public $incrementing = false;

    protected $fillable = [
        'id', // subをここに入れる
        'name',
        'email',
        'avatar_url',
        'self_introduction',
    ];

    // パスワードは不要なので $hidden などからも除外してOK
}
