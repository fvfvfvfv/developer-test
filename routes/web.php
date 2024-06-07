<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware(['guest']);

Route::group(['middleware' => ['auth', 'active']], function () {
    Route::get('/dashboard', function() {
        return Inertia::render('Dashboard');
    })->middleware('auth')->name('dashboard');

    Route::get('accounts', [AccountController::class, 'index'])
        ->name('accounts.index');
    Route::post('accounts', [AccountController::class, 'store'])
        ->name('accounts.store');
    Route::get('accounts/create', [AccountController::class, 'create'])
        ->name('accounts.create');
    Route::get('accounts/{account}/edit', [AccountController::class, 'edit'])
        ->name('accounts.edit');
    Route::get('accounts/{account}', [AccountController::class, 'show'])
        ->name('accounts.show');
    Route::put('accounts/{account}', [AccountController::class, 'update'])
        ->name('accounts.update');
    Route::delete('accounts/{account}', [AccountController::class, 'destroy'])
        ->name('accounts.destroy');

    Route::get('contacts', [ContactController::class, 'index'])
        ->name('contacts.index');
    Route::post('contacts', [ContactController::class, 'store'])
        ->name('contacts.store');
    Route::get('contacts/create', [ContactController::class, 'create'])
        ->name('contacts.create');
    Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])
        ->name('contacts.edit');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])
        ->name('contacts.show');
    Route::put('contacts/{contact}', [ContactController::class, 'update'])
        ->name('contacts.update');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])
        ->name('contacts.destroy');
});

require __DIR__.'/auth.php';
