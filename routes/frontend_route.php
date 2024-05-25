<?php

use App\Http\Controllers\DishController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DishController::class, 'showForm']);
Route::get('/get-restaurants', [DishController::class, 'getRestaurants']);
Route::get('/get-dishes', [DishController::class, 'getDishes']);
Route::post('/submit-order', [DishController::class, 'submitOrder'])->name('submitOrder');
