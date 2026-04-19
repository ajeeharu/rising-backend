// routes/api.php
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

// 一括でRESTfulなエンドポイントを定義
Route::apiResource('posts', PostController::class);
