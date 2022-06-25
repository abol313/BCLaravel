<?php

// use App\Enums\Category;
// use App\Http\Controllers\TodoController;
// use App\Models as Models;

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(TodoController::class)
        ->prefix('/todos')
        ->name('todo.')
        ->group(function(){
            Route::get('/','listAll')->name('listAll');

            Route::get('/{todo}/edit','editView')->name('editView');
            Route::post('/{todo}/edit','editAPI')->name('editAPI');

            Route::get('/make','makeView')->name('makeView');
            Route::post('/make','makeAPI')->name('makeAPI');

            Route::get('/{todo}/delete','delete')->name('delete');

            Route::get('/{todo}','listOne')->name('listOne');

        });

Auth::routes();
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

