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
            'avatar_url'        => 'nullable|string',
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
    /**
     * 【重要】個別のユーザーを取得するメソッドを追加
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // フロントエンドの型定義に合わせてキー名をマッピング
        return response()->json([
            'id'               => $user->id,
            'name'             => $user->name,
            'email'            => $user->email,
            'avatar_url'       => $user->avatar_url, // 変換
            'self_introduction' => $user->self_introduction, // 変換
        ]);
    }
    /**
     * ユーザーを削除する (DELETE /api/users/{id})
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
    /**
     * 既存ユーザーの情報を更新する (PUT/PATCH /api/users/{id})
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // バリデーション（更新したい項目だけを許可）
        $validated = $request->validate([
            'name'              => 'sometimes|string|max:255',
            'email'             => 'sometimes|email',
            'avatar_url'        => 'nullable|url',
            'self_introduction' => 'nullable|string',
        ]);

        // 更新実行
        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user'    => $user
        ]);
    }
}
