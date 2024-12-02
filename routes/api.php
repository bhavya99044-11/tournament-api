<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\TournamentController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\Teamcontroller;

Route::get('/user', function (Request $request) {
    dd(1);
    return $request->user();
})->middleware('auth:api');
Route::get('/login', function () {
    return view('admin-panel.login');
});
//Auth routes
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/register',[AuthController::class,'register'])->name('register');

//Roles and pemission api
Route::get('roles', [RolePermissionController::class,'getRoles'])->name('roles.get');
Route::post('/permission/create', [RolePermissionController::class,'permissionCreate'])->name('permissionCreate');
Route::post('role-permission', [RolePermissionController::class,'assignRolePermission'])->name('role.permission.assign');
Route::post('role-permission-revoke', [RolePermissionController::class,'revokeRolePermission'])->name('role.permission.revoke');
Route::post('role-permission-update', [RolePermissionController::class,'updateRolePermission'])->name('role.permission.update');
Route::post('user-role-permission', [RolePermissionController::class,'assignRoleToUser'])->name('user.role');
Route::post('user-role-revoke', [RolePermissionController::class,'revokeRole'])->name('user.role.revoke');


//Tournamnet api
Route::post('tournaments/create', [TournamentController::class,'create'])->name('tournament.create');
Route::get('tournaments', [TournamentController::class,'index'])->name('tournament.index');
Route::get('tournaments/{id}', [TournamentController::class,'show'])->name('tournament.show');
Route::put('tournaments/{id}', [TournamentController::class,'update'])->name('tournament.update');
Route::delete('tournaments/{id}', [TournamentController::class,'destroy'])->name('tournament.destroy');
Route::get('tournaments/{id}/matches', [TournamentController::class,'matches'])->name('tournament.matches');
Route::post('tournament/team/create',[TournamentController::class,'registerTeam'])->name('register.team');

//Team api
Route::post('teams/create', [TeamController::class,'create'])->name('team.create');
Route::get('teams', [TeamController::class,'index'])->name('team.index');
Route::get('teams/{id}', [TeamController::class,'show'])->name('team.show');
Route::put('teams/{id}', [TeamController::class,'update'])->name('team.update');
Route::delete('teams/{id}', [TeamController::class,'destroy'])->name('team.destroy');
Route::get('teams/{id}/players', [TeamController::class,'players'])->name('team.players');
