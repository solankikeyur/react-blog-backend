<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("login", [AuthController::class, "login"])->name("login");

Route::post("register", [AuthController::class, "register"])->name("register");

Route::middleware("auth:api")->post("logout", [AuthController::class, "logout"])->name("logout");
Route::middleware("auth:api")->post("changePassword", [AuthController::class, "changePassword"])->name("change_password");


Route::get("blog/get/{id}", [BlogController::class, "get"])->name("blog.get");
Route::get("blog/getAllBlogs", [BlogController::class, "getAllBlogs"])->name("blog.get_all_blogs");


Route::middleware("auth:api")->group(function () {

    //User Routes
    Route::prefix("user")->group(function () {
        Route::get("profile", [UserController::class, "getProfile"])->name("user.profile");
        Route::post("profile", [UserController::class, "updateProfile"])->name("user.profile_update");
    });

    //Blog Routes
    Route::prefix("blog")->group(function () {
        Route::post("add", [BlogController::class, "add"])->name("blog.add");
        Route::post("update/{id}", [BlogController::class, "update"])->name("blog.update");
        Route::delete("delete/{id}", [BlogController::class, "delete"])->name("blog.delete");
        Route::get("getUserBlogs", [BlogController::class, "getUserBlogs"])->name("blog.get_user_blogs");
    });
});
