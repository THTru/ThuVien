<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SachController;
use App\Http\Controllers\ThuvienController;
use App\Http\Controllers\BookController;

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
Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

Route::get('getuser',  [UserController::class, 'getuser']);
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);
Route::get('testapi', [UserController::class, 'testapi']);

Route::get('tacgia', [NewController::class, 'tacgia']);

Route::post('/test', [SachController::class, 'test']);
Route::get('/getbook', [SachController::class, 'getbook']);
Route::get('/getbookid', [SachController::class, 'getbookid']);
Route::get('/getreader', [SachController::class, 'getreader']);
Route::get('/getreaderid', [SachController::class, 'getreaderid']);
Route::get('/borrowform', [SachController::class, 'borrowform']);

Route::post('/getdetail', [SachController::class, 'getdetail']);
Route::post('/bookhistory', [SachController::class, 'bookhistory']);
Route::post('/readerhistory', [SachController::class, 'readerhistory']);
Route::post('/borrow', [SachController::class, 'borrow']);
Route::post('/returnbook', [SachController::class, 'returnbook']);
Route::post('/detailbyid', [SachController::class, 'detailbyid']);
Route::post('/formbyid', [SachController::class, 'formbyid']);
Route::post('/editdetail', [SachController::class, 'editdetail']);
Route::post('/deletedetail', [SachController::class, 'deletedetail']);
Route::post('/confirmlost', [SachController::class, 'confirmlost']);
Route::post('/editform', [SachController::class, 'editform']);
Route::post('/deleteform', [SachController::class, 'deleteform']);
Route::post('/sendmail', [SachController::class, 'sendmail']);
Route::post('/detailbydate', [SachController::class, 'detailbydate']);
Route::post('/exportreport', [SachController::class, 'exportreport']);
Route::post('/readerbyid', [SachController::class, 'readerbyid']);
Route::post('/editreader', [SachController::class, 'editreader']);
Route::post('/deletereader', [SachController::class, 'deletereader']);
Route::post('/newreader', [SachController::class, 'newreader']);

//=======================================================================

Route::get('/thuvienindex', [ThuvienController::class, 'thuvienindex']);
Route::post('/xoasach', [ThuvienController::class, 'xoasach']);
Route::get('/chondata', [ThuvienController::class, 'chondata']);
Route::post('/themsach', [ThuvienController::class, 'themsach']);
Route::post('/suasach', [ThuvienController::class, 'suasach']);
Route::post('/capnhatsach', [ThuvienController::class, 'capnhatsach']);
Route::post('/themmoinganh', [ThuvienController::class, 'themmoinganh']);
Route::post('/themmoilinhvuc', [ThuvienController::class, 'themmoilinhvuc']);
Route::post('/themmoitheloai', [ThuvienController::class, 'themmoitheloai']);
Route::post('/themmoitacgia', [ThuvienController::class, 'themmoitacgia']);
Route::post('/themmoinxb', [ThuvienController::class, 'themmoinxb']);
Route::post('/xoanganh', [ThuvienController::class, 'xoanganh']);
Route::post('/xoalinhvuc', [ThuvienController::class, 'xoalinhvuc']);
Route::post('/xoatheloai', [ThuvienController::class, 'xoatheloai']);
Route::post('/xoatacgia', [ThuvienController::class, 'xoatacgia']);
Route::post('/xoanxb', [ThuvienController::class, 'xoanxb']);
Route::get('/indexbandoc', [ThuvienController::class, 'indexbandoc']);
Route::get('/guiphieu', [ThuvienController::class, 'guiphieu']);
Route::post('/chitietbandoc', [ThuvienController::class, 'chitietbandoc']);
Route::get('/topmuon', [ThuvienController::class, 'topmuon']);
Route::post('/suanganh', [ThuvienController::class, 'suanganh']);
Route::post('/suatheloai', [ThuvienController::class, 'suatheloai']);
Route::post('/sualinhvuc', [ThuvienController::class, 'sualinhvuc']);
Route::post('/suanxb', [ThuvienController::class, 'suanxb']);
Route::post('/suatacgia', [ThuvienController::class, 'suatacgia']);

//=======================================================================

Route::post('/search', [BookController::class, 'SearchByName']);
Route::post('/status', [BookController::class, 'SearchTrangthaiByName']);

Route::get('/gettrangthai', [BookController::class, 'getTrangThai']);

