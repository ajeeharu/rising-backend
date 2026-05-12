<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VideoUploadController;

// api/users に対して一括でCRUDルートを割り当て
Route::apiResource('users', UserController::class);
// 動画アップロード用の署名付きURL取得エンドポイント
Route::post('/get-presigned-url', [VideoUploadController::class, 'getPresignedUrl']);
