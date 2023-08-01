<?php

use App\Http\Controllers\SubThemeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ThreadController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Theme;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return Inertia::render('IndexPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'authUser' => auth()->user() ?? false,
        'themes' => Theme::where('parent_id', null)->latest()->get()
    ]);
})->name('main.index');

// Default user routes for themes
Route::group([], function () {
    Route::get('/themes/{theme}', [ThemeController::class, 'show'])->name('theme.show');

});

Route::post('/create-thread', [ThreadController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('thread.store');
Route::get('/thread/{thread}', [ThreadController::class, 'show'])
    ->name('thread.show');
Route::get('/thread/{thread}/edit', [ThreadController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('thread.edit');
Route::patch('/thread/{thread}', [ThreadController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('thread.update');
Route::delete('/thread/{thread}/delete', [ThreadController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('thread.destroy');
// Admin routes for themes
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::post('/themes', [ThemeController::class, 'store'])->name('theme.store');
    Route::get('/themes/{theme}/edit', [ThemeController::class, 'edit'])->name('theme.edit');
    Route::patch('/themes/{theme}', [ThemeController::class, 'update'])->name('theme.update');
    Route::delete('/themes/{theme}', [ThemeController::class, 'destroy'])->name('theme.destroy');

    Route::group(['prefix' => '/sub-theme'], function () {
        Route::post('/', [SubThemeController::class, 'store'])->name('subTheme.store');
    });

});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
