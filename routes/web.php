<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CryptoController::class, 'index']);
Route::get('/search', [CryptoController::class, 'search']);
Route::get('/cryptocurrencies/{title}', [CryptoController::class, 'show']);


