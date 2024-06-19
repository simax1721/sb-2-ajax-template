<?php

use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminProdiController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return '<a href="login">Login</a>';
// });
Route::get('/', function () {
    return redirect('login');
});

Auth::routes();
Route::get('/register', function () {
    return redirect('/login');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::auto('/admin/role', AdminRoleController::class);
Route::auto('/admin/menu', AdminMenuController::class);
Route::auto('/admin/prodi', AdminProdiController::class);
Route::auto('/admin/user', AdminUserController::class);

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/about', function () {
    return view('about');
})->name('about');
