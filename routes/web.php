<?php

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::resource('/member', App\Http\Controllers\Member\MemberController::class)->only('index', 'store', 'update');
Route::get('/member-bonus', [App\Http\Controllers\Member\MemberController::class, 'calculateBonus']);
Route::get('/fetch-data', [App\Http\Controllers\Member\MemberController::class, 'fetchData']);
