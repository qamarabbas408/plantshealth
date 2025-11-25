<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController; // Don't forget to import this at top

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'es', 'fr','ur'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('switchLang');



// Guest Routes (Only for people NOT logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

     // ADD THESE:
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Logout Route (Only for logged in users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ADMIN ROUTES GROUP
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        // Double check: If user is NOT admin, stop them.
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.dashboard');
    })->name('admin.dashboard'); // <--- THIS LINE IS CRITICAL

});


// Author/User Dashboard Route
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        
        // EDGE CASE FIX:
        // If the logged-in user is an Admin, bounce them to the Admin Dashboard
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Otherwise, show the normal Author dashboard
        return view('dashboard');
        
    })->name('dashboard');

});
