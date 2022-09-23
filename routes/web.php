<?php
use app\Models\tbl_katalog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Barang;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [LoginController::class, 'index']);
Route::post('/', [LoginController::class, 'authenticate']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);


Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/logout', [DashboardController::class, 'logout']);
Route::post('/dashboard', [DashboardController::class, 'store']);

Route::get('/getData', [Barang::class, 'getData']);
Route::post('/{user}/{post}/post', 'PhotoController@store');
