<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrganizerController;
use App\Http\Controllers\Api\RolePermissionController;

use Illuminate\Support\Facades\Log;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

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


//Tournamnet api
Route::post('tournaments/create', [OrganizerController::class,'create'])->name('tournament.create');
Route::get('tournaments', [OrganizerController::class,'index'])->name('tournament.index');
Route::get('tournaments/{id}', [OrganizerController::class,'show'])->name('tournament.show');
Route::put('tournaments/{id}', [OrganizerController::class,'update'])->name('tournament.update');
Route::delete('tournaments/{id}', [OrganizerController::class,'destroy'])->name('tournament.destroy');
Route::get('tournaments/{id}/matches', [OrganizerController::class,'matches'])->name('tournament.matches');

