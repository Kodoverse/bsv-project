<?php

use App\Http\Controllers\Admin\AdminPartnerController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\UsersStatsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\PartnerDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Partner\PartnerSalesController;

use App\Http\Controllers\FlaggedCommentController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;



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

//rotte admin
Route::middleware(['auth'])->get('/admin', [AdminController::class, 'dashboardStats'])->name('admin.dashboard');

//rotte partner
Route::prefix('partner')->name('partner.')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [PartnerDashboardController::class, 'partnerDashboardStats'])
        ->name('dashboard');

    Route::resource('products', ProductController::class)
        ->names('products');

    Route::patch('/sales/{id}/status', [PartnerSalesController::class, 'updateStatus'])
        ->name('sales.updateStatus');

    Route::patch('products/{product}/toggle', [ProductController::class, 'toggleAvailability'])
        ->name('products.toggleAvailability');

    Route::resource('business', BusinessController::class)->names('business');

    // Rotte per la sidebar
    Route::view('/notifiche', 'partner.sidebarLink.notifiche')->name('notifiche');
    Route::view('/profilo', 'partner.sidebarLink.profilo')->name('profilo');
    Route::view('/impostazioni', 'partner.sidebarLink.impostazioni')->name('impostazioni');
});

//rotte web
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('articles', ArticleController::class);
    Route::resource('tags', TagController::class);

    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/flagged_comments', [FlaggedCommentController::class, 'index'])->name('flagged_comments.index');


    Route::resource('events', EventController::class);
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('partners', AdminPartnerController::class);
        Route::resource('users', UsersStatsController::class);
        Route::resource('stats', StatisticController::class);
    });


    // Route::get('/admin/partners', [AdminPartnerController::class, 'index'])->name('admin.partners.index');
    // Route::get('/admin/partners', [AdminPartnerController::class, 'create'])->name('admin.partners.create');



    // Route::get('/events', [EventController::class, 'index'])->name('event.index');
    // Route::get('/event/{event}', [EventController::class, 'show'])->name('event.show');
    // Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
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
