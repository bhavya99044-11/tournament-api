<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\WebAuthMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
Use App\Http\Controllers\TournamentController;


//admin routes login logout
Route::get('/admin/login', function () {
    return view('admin-panel.login');
})->name('admin.login');
Route::group(['middleware'=>WebAuthMiddleware::class,['role:admin|super admin']],function(){
    Route::get('/admin/dashboard',    function(){
        return view('admin-panel.dashboard');
    })->name('admin.dashboard');
});
Route::post('/admin/login', [AuthController::class,'login'])->name('admin.login');
Route::get('token/{name}',[DashboardController::class,'token'])->name('token')->middleware([WebAuthMiddleware::class]);
Route::get('auth/logout',[AuthController::class,'logout'])->name('auth.logout');

//Tournament routes
Route::get('/tournament', [TournamentController::class,'index'])->name('tournament.index');
Route::get('/tournament/create/{id}', [TournamentController::class,'create'])->name('tournament.create');

Route::get('/tournament/all', [TournamentController::class,'allTournaments'])->name('tournament.all');
Route::get('/tournament/search', [TournamentController::class,'searchTournaments'])->name('tournament.search');
Route::get('/tournament/filter/{id}', [TournamentController::class,'filterTournaments'])->name('tournament.filter');
Route::get('/tournament/my-tournaments', [TournamentController::class,'myTournaments'])->name('tournament.my');
Route::get('/tournament/participate', [TournamentController::class,'participateTournaments'])->name('tournament.participate');
Route::post('/tournament/store', [TournamentController::class,'store'])->name('tournament.store');
Route::get('/tournament/{id}/edit', [TournamentController::class,'edit'])->name('tournament.edit');
Route::put('/tournament/{id}/update', [TournamentController::class,'update'])->name('tournament.update');
Route::delete('/tournament/{id}/delete', [TournamentController::class,'destroy'])->name('tournament.destroy');
Route::get('/tournament/{id}', [TournamentController::class,'show'])->name('tournament.show');
