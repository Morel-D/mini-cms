<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Authentication System 

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Role Base access Control
Route::middleware('auth:sanctum', 'permission:admin-access')->get('/admin-data', function(){
    return response()->json(['data'=>'Admin data']);
});

Route::middleware('auth:sanctum', 'permission:user-access')->get('/user-data', function(){
    return reponse()->json(['data'=>'User data']);
});

Route::post('/assign-role', [RoleController::class, 'assignRole']);


/// POST Route operation
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
});

/// POST Route operation (Done olny by the admin)
Route::middleware('auth:sanctum', 'permission:admin-access')->group(function(){
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
   
});