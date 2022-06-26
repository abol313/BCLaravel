<?php

// use App\Enums\Category;
// use App\Http\Controllers\TodoController;
// use App\Models as Models;

use App\Http\Controllers\TodoController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// use phpDocumentor\Reflection\Types\Boolean;

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
Route::redirect('/','/todos');

Route::controller(TodoController::class)
        ->prefix('/todos')
        ->name('todo.')
        ->group(function(){
            Route::get('/','listAll')->name('listAll');

            Route::get('/{todo}/edit','edit')->name('edit');
            Route::post('/{todo}/update','update')->name('update');

            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');

            Route::get('/{todo}/delete','delete')->name('delete');

            Route::get('/{todo}','listOne')->name('listOne');

        });


Auth::routes();
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/setLocale/{locale}',[LocalizationController::class,'setLocale'])->name('setLocale');
