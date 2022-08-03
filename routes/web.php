<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\ContactController;

use App\Http\Middleware\Auth_profile;
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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth_profile')->group(function() {
    Route::group(['middleware' => ['auth_profile']], function() {
        Route::get('contacts', [ContactController::class, 'index']);
        Route::get('add-contact', [ContactController::class, 'create']);
        Route::post('add-contact', [ContactController::class, 'store']);
        Route::get('edit-contact/{id}', [ContactController::class, 'edit']);
        Route::post('update-contact/{id}', [ContactController::class, 'update']);
        Route::get('delete-contact/{id}', [ContactController::class, 'destroy']);

        Route::get('get-firebase-data', [FirebaseController::class, 'index'])->name('firebase.index');
    });


});
