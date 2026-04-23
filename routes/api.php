<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

// api/users に対して一括でCRUDルートを割り当て
Route::apiResource('users', UserController::class);
