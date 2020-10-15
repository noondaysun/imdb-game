<?php

use App\Http\Controllers\Index;
use App\Http\Controllers\Rounds;
use Illuminate\Support\Facades\Route;

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

Route::get('/', Index::class);
Route::post('/challenger', [Rounds::class, 'challenger']);
Route::post('/round', [Rounds::class, 'round']);
Route::get('/results', [Rounds::class, 'results']);