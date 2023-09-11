<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\IsAuthenticated;
use App\Http\Middleware\IsNotAuthenticated;
use App\Http\Middleware\IsVerified;
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

Route::get("/", [PageController::class, 'home'])->name("page.home");


Route::get("/multi/{x}/{y}", function ($x, $y) {
    return $x + $y;
})->name("multi");

// Route::prefix("user")->group(function(){
//     Route::prefix("inventory")->controller(ItemController::class)->group(function(){
//         Route::get("/",'index')->name("item.index");
//         Route::get("/create",'create')->name("item.create");
//         Route::post("/",'store')->name("item.store");
//         Route::get("/{id}",'show')->name("item.show");
//         Route::delete("/{id}",'destroy')->name("item.destroy");
//         Route::get("/{id}/edit",'edit')->name("item.edit");
//         Route::put("/{id}",'update')->name("item.update");
//         });
// });


Route::controller(AuthController::class)->group(function () {

    Route::middleware(IsNotAuthenticated::class)->group(function(){
        Route::get("register", "register")->name("auth.register");
        Route::post("register", "store")->name("auth.store");
        Route::get("login", "login")->name("auth.login");
        Route::post("login", "check")->name("auth.check");

        Route::get("forgot", "forgot")->name("auth.forgot");
        Route::post("check-email", "checkEmail")->name("auth.checkEmail");
        Route::get("new-password","newPassword")->name("auth.newPassword");
        Route::post("reset-password","resetPassword")->name("auth.resetPassword");


    });

    Route::middleware(IsAuthenticated::class)->group(function(){

    Route::post("logout", "logout")->name("auth.logout");

    Route::middleware(IsVerified::class)->group(function(){
        Route::get("password-change", "passwordChange")->name("auth.passwordChange");
        Route::post("password-change", "passwordChanging")->name("auth.passwordChanging");

});

    Route::get("verify", "verify")->name("auth.verify");
    Route::post("verify", "verifying")->name("auth.verifying");

    });


});


Route::middleware(IsAuthenticated::class)->group(function () {

    Route::resource('item', ItemController::class);

    Route::resource("category", CategoryController::class);

    Route::controller(HomeController::class)->prefix("dashboard")->group(function () {
        Route::get("home", "home")->name("dashboard.home");
    });
});


