<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController; // Don't forget to import this at top
use App\Http\Controllers\PostController; // Don't forget to import this at top
use App\Models\Post; 

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
  $posts = Post::with(['author', 'tags']) 
                ->where('is_published', true)
                ->latest() 
                ->take(3) 
                ->get();

    // return view('home');
    return view('home', compact('posts'));

})->name('home'); 

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
    Route::get('/new-story', [PostController::class, 'create'])->name('posts.create');
    Route::post('/new-story', [PostController::class, 'store'])->name('posts.store');



});

// Route::get('/story/{slug}', [PostController::class, 'show'])->name('posts.show');
// The '@' is part of the static URL structure, {username} is the dynamic parameter
Route::get('/@{username}/{slug}', [PostController::class, 'show'])->name('posts.show');



