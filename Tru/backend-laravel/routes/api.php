<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\SachController;

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