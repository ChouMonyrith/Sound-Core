<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SoundController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(FacadesAuth::check()){
        return redirect()->route('sounds.index');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (FacadesAuth::check()) {
        return redirect()->route('sounds.index');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('sounds', SoundController::class);

    Route::get('/sounds-pending', [SoundController::class, 'pending'])
        ->name('sounds.pending')
        ->middleware('can:viewAny,App\Models\Sound');

    Route::get('/sounds/{id}', [SoundController::class, 'show'])->name('sounds.show');


    Route::patch('/sounds/{id}/approve', [SoundController::class, 'approve'])
        ->name('sounds.approve')
        ->middleware('can:approve-sound');

    Route::patch('/sounds/{id}/reject', [SoundController::class, 'reject'])
        ->name('sounds.reject')
        ->middleware('can:approve-sound');

    Route::get('/sounds/download/{id}', [SoundController::class, 'download'])
        ->name('sounds.download');



});

require __DIR__.'/auth.php';
