<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ReportController;

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:web');

Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth:web');

Route::get('users', [UserController::class, 'index'])->name('users');
Route::get('users/detail/{id}', [UserController::class, 'detail'])->name('users.detail')->middleware('auth:web');
Route::get('users/datatable', [UserController::class, 'getDataTable'])->middleware('auth:web');
Route::post('users/logout', [UserController::class, 'logoutAllUsers'])->name('users.logout')->middleware('auth:web');
Route::post('users/activate/{id}', [UserController::class, 'activateUser'])->middleware('auth:web');
Route::post('users/ban/{id}', [UserController::class, 'banUser'])->middleware('auth:web');
Route::post('users/delete/{id}', [UserController::class, 'delete'])->name('users.delete')->middleware('auth:web');
Route::post('users/notify/{id}', [UserController::class, 'notifyUser'])->name('users.notify')->middleware('auth:web');

Route::get('songs', [SongController::class, 'index'])->name('songs')->middleware('auth:web');
Route::get('songs/datatable', [SongController::class, 'getDataTable'])->middleware('auth:web');
Route::post('songs/remove/{id}', [SongController::class, 'removeSong'])->middleware('auth:web');

Route::get('albums', [AlbumController::class, 'index'])->name('albums')->middleware('auth:web');
Route::get('albums/datatable', [AlbumController::class, 'getDataTable'])->middleware('auth:web');

Route::get('genres', [GenreController::class, 'index'])->name('genres')->middleware('auth:web');
Route::get('genres/datatable', [GenreController::class, 'getDataTable'])->middleware('auth:web');
Route::post('genres/add', [GenreController::class, 'store'])->name('genres.add')->middleware('auth:web');
Route::post('genres/edit/{id}', [GenreController::class, 'update'])->name('genres.edit')->middleware('auth:web');
Route::post('genres/delete/{id}', [GenreController::class, 'delete'])->name('genres.delete')->middleware('auth:web');

Route::get('reports', [ReportController::class, 'index'])->name('reports')->middleware('auth:web');
Route::get('reports/detail/{id}', [ReportController::class, 'detail'])->name('reports.detail')->middleware('auth:web');
Route::get('reports/datatable', [ReportController::class, 'getDataTable'])->middleware('auth:web');
Route::post('reports/update-status/{idReport}', [ReportController::class, 'updateReportStatus'])->middleware('auth:web');

