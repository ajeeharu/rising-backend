<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * ユーザー一覧を取得する (GET /api/users)
     */
    public function index()
    {
        // データベースから全ユーザーを取得してJSONで返す
        return response()->json(User::all(), 200);
    }
    /**
     * Cognitoから渡された情報でユーザーを登録、または更新する
     */
    public function store(Request $request)
    {
        // 1. バリデーション
        $validated = $request->validate([
            'sub'               => 'required|string', // CognitoのID
            'name'              => 'required|string|max:255',
            'email'             => 'required|email',
            'avatar_url'        => 'nullable|url',
            'self_introduction' => 'nullable|string',
        ]);

        // 2. 保存処理 (updateOrCreateなら、既存ユーザーがいれば更新、いなければ新規作成)
        $user = User::updateOrCreate(
            ['id' => $validated['sub']], // 検索条件
            [
                'name'              => $validated['name'],
                'email'             => $validated['email'],
                'avatar_url'        => $validated['avatar_url'] ?? null,
                'self_introduction' => $validated['self_introduction'] ?? null,
            ]
        );

        // 3. レスポンスを返す
        return response()->json([
            'message' => 'User saved successfully',
            'user'    => $user
        ], 201);
    }
}
