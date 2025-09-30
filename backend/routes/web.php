<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\FlaggedCommentController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Partner\PartnerDashboardController;
use App\Http\Controllers\Partner\PartnerProductController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match ($user->user_role) {
            'admin' => redirect()->route('admin.dashboard'),
            'partner' => redirect()->route('partner.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
})->name('dashboard');


Route::middleware(['auth'])->get('/admin', [AdminController::class, 'dashboardStats'])->name('admin.dashboard');
Route::middleware(['auth'])->get('/partner', [PartnerController::class, 'partnerDashboardStats'])->name('partner.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('articles', ArticleController::class);
    Route::resource('tags', TagController::class);

    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/flagged_comments', [FlaggedCommentController::class, 'index'])->name('flagged_comments.index');
    Route::get('/partner/products', [PartnerProductController::class, 'index'])->name('partner.products');

    // Sales partner
    Route::get('/partner/sales', [PartnerDashboardController::class, 'sales'])->name('partner.sales');

    // Redemptions partner
    Route::get('/partner/redemptions', [PartnerDashboardController::class, 'redemptions'])->name('partner.redemptions');

    // Profile partner
    Route::get('/partner/profile', [PartnerDashboardController::class, 'profile'])->name('partner.profile');

});

Route::middleware(['web', 'auth'])->group(function () {
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    Route::post('/comments', [CommentController::class, 'addComment']);
    Route::post('/comments/{commentId}/like', [CommentController::class, 'toggleLike']);
    Route::post('/article/{articleId}/like', [ArticleController::class, 'toggleLikeArticle']);
    Route::put('/comments/{comment}', [CommentController::class, 'update']);

});

/*


Route::get('/tags', [TagController::class, 'index'])->name('tags.index');

Route::delete('/tags{id}', [TagController::class, 'destroy'])->name('tags.destroy');
Route::get('/tags/{id}', [TagController::class, 'edit'])->name('tags.edit');
Route::patch('/tags{id}', [TagController::class, 'update'])->name('tags.update');
*/
require __DIR__ . '/auth.php';
