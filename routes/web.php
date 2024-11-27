<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\WebAuthMiddleware;

Route::get('/admin/login', function () {
    return view('admin-panel.login');
})->name('admin.login');
Route::middleware([WebAuthMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('welcome');
    })->name('admin.dashboard');
});
