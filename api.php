<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bookcontroller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/showall', [Bookcontroller::class, 'Showall']);

Route::put('/updatebook/{id}',  [Bookcontroller::class, 'UpdateBookbyID']);

Route::post('/search', [Bookcontroller::class, 'SearchByName']);

Route::post('/addbook', [Bookcontroller::class, 'AddBook']);

Route::post('/status', [Bookcontroller::class, 'SearchTrangthaiByName']);

Route::put('/updatestatus/{id}',  [Bookcontroller::class, 'SuaTrangthai']);

Route::get('/test',  [Bookcontroller::class, 'test']);

//=======================================================
Route::get('/gettheloai', [Bookcontroller::class, 'getTheLoai']);
Route::get('/gettacgia', [Bookcontroller::class, 'getTacGia']);
Route::get('/getnxb', [Bookcontroller::class, 'getNXB']);
Route::get('/getlinhvuc', [Bookcontroller::class, 'getLinhVuc']);
Route::get('/getnganh', [Bookcontroller::class, 'getNganh']);
Route::get('/gettrangthai', [Bookcontroller::class, 'getTrangThai']);