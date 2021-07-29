<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\ExportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/category/{category}/tasks', [ColumnController::class, 'tasks']);
Route::resource('/category', ColumnController::class);
Route::resource('/task', CardController::class);

//Columns Routes
Route::get('columns', [ColumnController::class, 'index']);
Route::post('columns', [ColumnController::class, 'store']);
Route::patch('columns/order', [ColumnController::class, 'update']);
Route::delete('columns', [ColumnController::class, 'destroy']);

// Cards Route
Route::post('cards', [CardController::class, 'store']);
Route::patch('cards', [CardController::class, 'update']);

// Download Dump
Route::get('download-db-dump', [ExportController::class, 'export']);
