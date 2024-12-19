<?php

use App\Http\Controllers\Api\V1\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\V1\TournamentController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\Teamcontroller;

Route::controller(AuthController::class)->prefix('v1')->group(function () {
    Route::post('register', 'register')->name('auth.register');
    Route::post('login', 'login')->name('auth.login')->middleware('throttle:api_login');
    Route::post('logout', 'logout')->name('auth.logout');
});
Route::prefix('v1')->group(function () {
    Route::controller(TournamentController::class)->group(function () {
        Route::get('tournament', 'index')->name('tournament.index');
        Route::get('tournament/search', 'search')->name('tournament.search');
        Route::get('tournament/{tournament}/matches', 'tournamentMatches')->name('tournament.matches');
    });
    Route::middleware(['api_auth'])->controller(ProfileController::class)->group(function () {
        Route::get('/profile/view', 'profileView')->name('profile.view');
        Route::post('/profile/update', 'profileUpdate')->name('profile.update');
    });
});
