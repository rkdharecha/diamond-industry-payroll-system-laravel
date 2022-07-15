<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkTypeController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\CashAdvanceController;

Route::get('/',[HomeController::class,'index']);

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'roles', 'as' => 'roles'], function () {
    Route::get('/', [RoleController::class,'index'])->name('.index');
    Route::get('create', [RoleController::class,'create'])->name('.create');
    Route::get('/edit/{id}',[RoleController::class,'edit'])->name('.edit');
    Route::get('/show/{id}',[RoleController::class,'show'])->name('.show');
    Route::get('/delete/{id}',[RoleController::class,'destroy'])->name('.destroy');
    Route::post('/store', [RoleController::class,'store'])->name('.store');
    Route::patch('/update/{id}', [RoleController::class,'update'])->name('.update');
});

Route::group(['middleware' => 'auth', 'prefix' => 'users', 'as' => 'users'], function () {
    Route::get('/', [UserController::class,'index'])->name('.index');
    Route::get('create', [UserController::class,'create'])->name('.create');
    Route::get('/edit/{id}',[UserController::class,'edit'])->name('.edit');
    Route::get('/show/{id}',[UserController::class,'show'])->name('.show');
    Route::get('/delete/{id}',[UserController::class,'destroy'])->name('.destroy');
    Route::post('/store', [UserController::class,'store'])->name('.store');
    Route::patch('/update/{id}', [UserController::class,'update'])->name('.update');
    Route::get('/advance/debit/{id}',[UserController::class,'advcashlist'])->name('.advcashlist');
});

Route::group(['middleware' => 'auth', 'prefix' => 'worktypes', 'as' => 'worktypes'], function () {
    Route::get('/', [WorkTypeController::class,'index'])->name('.index');
    Route::get('create', [WorkTypeController::class,'create'])->name('.create');
    Route::get('/edit/{id}',[WorkTypeController::class,'edit'])->name('.edit');
    Route::get('/delete/{id}',[WorkTypeController::class,'destroy'])->name('.destroy');
    Route::post('/store', [WorkTypeController::class,'store'])->name('.store');
    Route::post('/update/{id}', [WorkTypeController::class,'update'])->name('.update');
});

Route::group(['middleware' => 'auth', 'prefix' => 'timesheets', 'as' => 'timesheets'], function () {
    Route::post('/assign', [TimeSheetController::class,'assign'])->name('.assign');
    Route::post('/fetch_data',[TimeSheetController::class,'fetch_data'])->name('.fetch_data');
});

Route::group(['middleware' => 'auth', 'prefix' => 'advance/cash/', 'as' => 'cash'], function () {
    Route::get('/', [CashAdvanceController::class,'index'])->name('.index');
    Route::get('create', [CashAdvanceController::class,'create'])->name('.create');
    Route::get('/edit/{id}',[CashAdvanceController::class,'edit'])->name('.edit');
    Route::get('/delete/{id}',[CashAdvanceController::class,'destroy'])->name('.destroy');
    Route::post('/store', [CashAdvanceController::class,'store'])->name('.store');
    Route::post('/update/{id}', [CashAdvanceController::class,'update'])->name('.update');
    Route::post('/fetch_data',[CashAdvanceController::class,'fetch_data'])->name('.fetch_data');
});