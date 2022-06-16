<?php

// use App\Enums\Category;
// use App\Http\Controllers\TodoController;
// use App\Models as Models;

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
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
            Route::get('/{todo}','listOne');
            Route::get('/','listAll');
            Route::get('/make','make');
            Route::get('/delete/{id}','delete')->name('delete');
            Route::get('/query','query');
        });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*practices
*
/

Route::any('/any/{id1}',fn($id1)=>"any verb ;) $id1");

Route::match(['get','post'],'/match',fn()=>"ijij")->name('route.match');

Route::permanentRedirect('/a','/match',301);
Route::view('/view','welcome');

Route::pattern('name','\d+');
Route::get('/optional/{name?}',function($a = 'No name',$name = ':/'){
    return $a.$name;
})->name('route.optional');

Route::get('/b',fn(Request $request)=>response()->json([$request->route()->named('rote.a')]))->name('route.a');

Route::prefix('/pre')->middleware('test')->controller(TodoController::class)
    ->group(
        function(){
            Route::get('/list','listAll');
        }
    );

Route::get('/usersTodos/{userTodo}/commanders/{user}',function(Models\UserTodo $userTodo, Models\User $user){
    // foreach($todo as $t)
    //     print_r($t->getAttributes());
    return response()->json(['todo'=>($userTodo->getAttributes()),'user'=>($user->getAttributes())]);
})->where('todo','.*')->missing(fn()=>response()->json(["No matched!"]));


Route::get('/category/{category}',function(Category  $category){
    return $category->value;
});
//*/

Route::get('/a/{a}/b/{b}',function ($a,Request $request){
    return "$a";
});