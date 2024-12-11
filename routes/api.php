<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\V1\TournamentController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\Teamcontroller;


Route::prefix('V1')->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::post('register','register')->name('auth.register');
        Route::post('login','login')->name('auth.login');
        Route::post('logout','logout')->name('auth.logout');
        Route::post('refresh','refresh')->name('auth.refresh');
    });

    Route::controller(TournamentController::class)->group(function(){
        Route::get('tournament','index')->name('tournament.index');
        Route::get('tournament/search','search')->name('tournament.search');
    });
});
