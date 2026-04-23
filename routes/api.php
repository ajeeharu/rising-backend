use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// この定義があれば /api/users でアクセス可能
Route::get('/users', function () {
    return response()->json([
        ['id' => 1, 'name' => 'User 1'],
        ['id' => 2, 'name' => 'User 2']
    ]);
});
