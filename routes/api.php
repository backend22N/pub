<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DrinkController;
use App\Http\Controllers\api\TypeController;
use App\Http\Controllers\api\PackageController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\CityController;
use App\Http\Controllers\api\ProfileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post( "/register", [ UserController::class, "register" ]);
Route::post( "/login", [ UserController::class, "login" ]);
Route::post( "/logout", [ UserController::class, "logout" ]);
Route::get( "/users", [ UserController::class, "getUsers" ]);
Route::get( "/tokens", [ UserController::class, "getTokens" ]);

Route::get( "/drinks", [ DrinkController::class, "getDrinks" ]);
Route::get( "/drink", [ DrinkController::class, "getOneDrink" ]);
Route::get( "/amount", [ DrinkController::class, "getAmount" ]);
Route::post( "/new", [ DrinkController::class, "addDrink" ]);
Route::put( "/modify", [ DrinkController::class, "modifyDrink" ]);
Route::delete( "/destroy", [ DrinkController::class, "destroy" ]);

Route::get( "/types", [ TypeController::class, "getTypes" ]);
Route::post( "/newtype", [ TypeController::class, "newType" ]);
Route::put( "/modtype", [ TypeController::class, "modifyType" ]);
Route::delete( "/desttype", [ TypeController::class, "destroyType" ]);

Route::get( "/packages", [ PackageController::class, "getPackages" ]);
Route::get( "/package", [ PackageController::class, "getPackage" ]);
Route::post( "/newpackage", [ PackageController::class, "newPackage" ]);
Route::put( "/modpackage", [ PackageController::class, "modifyPackage" ]);
Route::delete( "/destpackage", [ PackageController::class, "destroyPackage" ]);

Route::post( "/newcity", [ CityController::class, "addCity" ]);
Route::get( "/userprofile", [ ProfileController::class, "getProfile" ]);
Route::put( "/modifyprofile", [ ProfileController::class, "setProfile" ]);
Route::put( "/modifypassword", [ ProfileController::class, "setPassword" ]);
Route::post("/deleteprofile", [ ProfileController::class, "deleteProfile" ]);
