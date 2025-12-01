<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\InteractionController; // Don't forget to import this at top
use App\Http\Controllers\PageController;
use App\Http\Controllers\PasswordResetController; // Don't forget to import this at top
use App\Http\Controllers\PostController; // Don't forget to import this at top
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\NotificationController; 

use App\Models\Post; // Import at top
use Illuminate\Support\Facades\Route; // Import at top

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
        ->published() // <--- Use scope
        ->latest()
        ->take(6)
        ->get();

    // return view('home');
    return view('home', compact('posts'));

})->name('home');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'es', 'fr', 'ur'])) {
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

    // FORGOT PASSWORD ROUTES
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

    // RESET PASSWORD ROUTES
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Logout Route (Only for logged in users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ADMIN ROUTES GROUP
// ADMIN ROUTES GROUP
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Admin Post Management
    // 1. View the Draft (We use ID here because Slug might change)
    Route::get('/posts/{id}/review', [AdminController::class, 'review'])->name('admin.posts.review');
    
    // 2. Approve (Publish)
    Route::post('/posts/{id}/approve', [AdminController::class, 'approve'])->name('admin.posts.approve');
    
    // 3. Reject (Send back to draft)
    Route::delete('/posts/{id}/reject', [AdminController::class, 'reject'])->name('admin.posts.reject');
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
        // NEW LOGIC: Fetch posts WITH counts
        $posts = Auth::user()
            ->posts()
            ->withCount(['likes', 'bookmarks', 'comments']) // <--- THE MAGIC
            ->latest()
            ->get();

        return view('dashboard', compact('posts'));

    })->name('dashboard');
    // Profile Update Route
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/new-story', [PostController::class, 'create'])->name('posts.create');
    Route::post('/new-story', [PostController::class, 'store'])->name('posts.store');

    // Edit Story Routes
    Route::get('/p/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/p/{id}/update', [PostController::class, 'update'])->name('posts.update');

    Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/posts/{id}/toggle-comments', [PostController::class, 'toggleCommentStatus'])->name('posts.toggleComments');

    // Delete Post Route
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/settings/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    // Password & Security Page
    Route::get('/settings/password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::post('/settings/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Interactions
    Route::post('/post/{id}/like', [InteractionController::class, 'toggleLike'])->name('post.like');
    Route::post('/post/{id}/bookmark', [InteractionController::class, 'toggleBookmark'])->name('post.bookmark');

       // Stats
    Route::get('/me/stats', [StatsController::class, 'index'])->name('stats.index');

      // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');

});

// Route::get('/story/{slug}', [PostController::class, 'show'])->name('posts.show');
// The '@' is part of the static URL structure, {username} is the dynamic parameter
Route::get('/@{username}/{slug}', [PostController::class, 'show'])->name('posts.show');

// Blog Archive Route
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');

Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/editorial-board', [PageController::class, 'editorial'])->name('pages.editorial');
