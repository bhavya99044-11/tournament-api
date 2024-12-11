<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\WebAuthMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MatchController;
Use App\Http\Controllers\TournamentController;
Use App\Http\Controllers\TeamController;
use App\Http\Controllers\Auth\SocialLoginController;

//admin routes login logout
Route::get('/admin/login', function () {
    return view('admin-panel.login');
})->name('admin.login');
Route::get('/',function(){
    return view('admin-panel.hello');
});
Route::group(['middleware'=>WebAuthMiddleware::class],function(){
    Route::get('/admin/dashboard',[DashboardController::class,'dashboard'])->name('admin.dashboard');
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
Route::get('/tournament/{id}/teams', [TournamentController::class,'tournamentTeams'])->name('tournament.teams');

//Team and playes registration routes
Route::get('/tournament/{id}/team/create', [TournamentController::class,'createTeamForm'])->name('team.create');
Route::get('/tournament/{id}/team/add', [TournamentController::class,'addTeam'])->name('team.add');
Route::get('/player/create/{id}', [TournamentController::class,'createPlayerForm'])->name('player.create');
Route::post('/team/register', [TournamentController::class,'registerTeam'])->name('team.register');
Route::post('/player/register', [TournamentController::class,'registerPlayer'])->name('player.register');
Route::get('/player/positions',[TeamController::class,'getPlayerPositions'])->name('getPlayerPositions');
Route::get('/team/{id}/players',[TeamController::class,'getTeamPlayers'])->name('getTeamPlayers');


//Tournament Match
Route::get('/tournament/{id}/matches', [MatchController::class,'matches'])->name('tournament.matches');
Route::get('/tournament/{id}/matches/rounds',[MatchController::class,'rounds'])->name('tournament.rounds');
Route::post('/tournament/match/create', [MatchController::class,'createMatch'])->name('match.create');
Route::get('/match/{id}/edit', [TournamentController::class,'editMatch'])->name('match.edit');
Route::put('/match/{id}/update', [TournamentController::class,'updateMatch'])->name('match.update');
Route::delete('/match/{id}/delete', [TournamentController::class,'destroyMatch'])->name('match.destroy');
Route::get('/match/{id}', [TournamentController::class,'showMatch'])->name('match.show');


//Social login
Route::get('/auth/google/redirect',[SocialLoginController::class,'redirect'])->name('auth.social.redirect');
Route::get('/auth/google/callback',[SocialLoginController::class,'callback'])->name('auth.social.callback');

Route::get('/tasks',function(){
    return view('admin-panel.tasks');
})->name('admin.tasks');
