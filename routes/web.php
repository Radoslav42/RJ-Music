<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AlbumController;
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

Route::get('/', [HomeController::class, 'index']);
Route::get('/about',[AboutController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
//user
Route::get('/beforeLogin', [UserController::class, 'beforeLogin']);
Route::get('/beforeRegistration', [UserController::class, 'beforeRegistration']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/beforeUpdateUser', [UserController::class, 'beforeUpdateUser']);
Route::post('/updateUser', [UserController::class, 'updateUser']);
//user-change password, ak stihnem, mozem spravit na zaver
Route::get('/beforeChangePassword', [UserController::class, 'beforeChangePassword']);
Route::post('/changePassword', [UserController::class, 'changePassword']);
Route::get('/beforeSendMailForRecoveryPassword', [UserController::class, 'beforeSendMailForRecoveryPassword']);
Route::post('/sendMailForRecoveryPassword', [UserController::class, 'sendMailForRecoveryPassword']);

Route::get('/verifyUserEmail', [UserController::class, 'verifyUserEmail']);


//author
Route::get('/beforeActionWithAuthor', [AuthorController::class, 'beforeActionWithAuthor']);
Route::post('/updateAuthor', [AuthorController::class, 'updateAuthor']);
Route::post('/deleteAuthor', [AuthorController::class, 'deleteAuthor']);
//authors
Route::get('/beforeSelectAuthor', [AuthorController::class, 'beforeSelectAuthor']);

//albums
Route::get('/beforeActionWithAlbums', [AlbumController::class, 'beforeActionWithAlbums']);
Route::post('/createAlbum', [AlbumController::class, 'createAlbum']);
Route::post('/editAlbum', [AlbumController::class, 'editAlbum']);
Route::get('/deleteAlbum/{albumId}', [AlbumController::class, 'deleteAlbum']);
//Route::post('/createAlbum', [AuthorController::class, 'createAlbum']);

//Route::post('/getAlbum', [AuthorController::class, 'getAlbum']);
//Route::get('/beforeUpdateOrDeleteAlbum', [AuthorController::class, 'beforeUpdateOrDeleteAlbum']);
//Route::post('/updateAlbum', [AuthorController::class, 'updateAlbum']);
//Route::post('/deleteAlbum', [AuthorController::class, 'deleteAlbum']);

//in album, songs

Route::get('/beforeUpdateAlbum/{albumId}', [AlbumController::class, 'beforeCreateUpdateAlbum'])->name("beforeUpdateAlbum");
Route::get('/beforeCreateAlbum', [AlbumController::class, 'beforeCreateAlbum']);

