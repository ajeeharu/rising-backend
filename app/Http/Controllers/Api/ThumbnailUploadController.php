<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ThumbnailUploadController extends Controller
{
    public function getThumbnailPresignedUrl(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string',
            'file_type' => 'required|string', // image/jpeg など?
        ]);

        $fileName = $request->input('file_name');
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        // ファイル名の重複を避けるため UUID などを付与
        $path = 'thumbnails/' . Str::uuid() . '.' . $extension;

        // 5分間有効な PUT 用の署名付きURLを発行
        $url = Storage::disk('s3')->temporaryUploadUrl(
            $path,
            now()->addMinutes(5)
        );

        return response()->json([
            's3_presigned' => $url,
            'path' => $path, // 後で DB に保存するためにパスも返しておくと便利
        ]);
    }
}
