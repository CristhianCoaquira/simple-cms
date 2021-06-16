<?php

use App\Http\Livewire\Frontpage;
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

Route::group(['middleware' => ['auth:sanctum', 'verified', 'accessrole']], function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('pages', 'admin.pages')->name('pages');
    Route::view('menus', 'admin.navigation-menus')->name('navigation-menus');
    Route::view('users', 'admin.users')->name('users');
    Route::view('user-permissions', 'admin.user-permissions')->name('user-permissions');
});

Route::get('/', Frontpage::class);
Route::get('/{urlslug}', Frontpage::class);
