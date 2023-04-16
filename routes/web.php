<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['auth']], function () {

    Route::get('/createEvents', [EventController::class, 'createEvents'])->name("createEvents");
    Route::post('/saveEvents', [EventController::class, 'saveEvents'])->name("saveEvents");
    Route::get('/listEvents', [EventController::class, 'listEvents'])->name("listEvents");
    Route::post('/getInvitedUsers', [EventController::class, 'getInvitedUsers'])->name("getInvitedUsers");
    Route::post('/removeInvitedUsers', [EventController::class, 'removeInvitedUsers'])->name("removeInvitedUsers");
    
});

