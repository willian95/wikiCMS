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

Route::get('/', "AuthController@index")->middleware("guest");
Route::post("login", "AuthController@login");

Route::middleware(['auth'])->group(function () {

    Route::get("/home", "DashboardController@index");

    Route::get("/institutions", "InstitutionsController@index")->name("institutions.index");

    Route::get("/category", "CategoryController@index")->name("categories.index")->middleware("auth");
    Route::post("category/store", "CategoryController@store")->middleware("auth");
    Route::post("category/search", "CategoryController@search")->middleware("auth");
    Route::get("/category/fetch/{page}", "CategoryController@fetch")->middleware("auth");
    Route::post("/category/update", "CategoryController@update")->middleware("auth");
    Route::post("/category/delete", "CategoryController@delete")->middleware("auth");
    Route::get("/category/all", "CategoryController@all")->middleware("auth");
    

});