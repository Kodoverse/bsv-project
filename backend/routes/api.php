<?php

use App\Http\Controllers\Api\ApiSectionController;
use App\Http\Controllers\Api\ApiArticleController;
use App\Http\Controllers\Api\ApiCommentController;
use App\Http\Controllers\Api\AuthFrontEndController;
use App\Http\Controllers\Api\EventCategoryController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventRegistrationController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PartnerInfoController;
use App\Http\Controllers\Api\PointController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


Route::post('/login', [AuthFrontEndController::class, 'login']);
Route::post('/logout', [AuthFrontEndController::class, 'logout']);
Route::post('/register', [AuthFrontEndController::class, 'register']);
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/articles', [ApiArticleController::class ,'index']);
Route::get('/articles/{id}', [ApiArticleController::class ,'show']);
Route::get('/articles/{id}/comments', [ApiCommentController::class, 'getByArticle']);
// Route::get('/comments', [ApiCommentController::class ,'index']);
Route::post('/comments', [ApiCommentController::class ,'addComment']);
Route::get('/sections', [ApiSectionController::class, 'index']);
Route::post('/comments/flag', [ApiCommentController::class, 'flagComment']);

// Event Categories
Route::get('event-categories', [EventCategoryController::class, 'index']);
Route::get('event-categories/{eventCategory}', [EventCategoryController::class, 'show']);

// Protected Event Category Routes
Route::middleware(['auth', 'can:manage-events'])->group(function () {
    Route::post('event-categories', [EventCategoryController::class, 'store']);
    Route::put('event-categories/{eventCategory}', [EventCategoryController::class, 'update']);
    Route::delete('event-categories/{eventCategory}', [EventCategoryController::class, 'destroy']);
});

// Events
Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::get('/upcoming', [EventController::class, 'upcoming']);
    Route::get('/finished', [EventController::class, 'finished']);
    Route::get('/{event}', [EventController::class, 'show']);
    
    Route::middleware(['auth', 'can:manage-events'])->group(function () {
        Route::post('/', [EventController::class, 'store']);
        Route::put('/{event}', [EventController::class, 'update']);
        Route::delete('/{event}', [EventController::class, 'destroy']);
    });
});

// Event Registrations
Route::prefix('event-registrations')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/my-registrations', [EventRegistrationController::class, 'myRegistrations']);
        Route::post('/{event}/register', [EventRegistrationController::class, 'register']);
        Route::post('/{event}/cancel', [EventRegistrationController::class, 'cancel']);
    });

    Route::middleware(['auth', 'can:manage-events'])->group(function () {
        Route::get('/', [EventRegistrationController::class, 'index']);
        Route::put('/{registration}/status', [EventRegistrationController::class, 'updateStatus']);
    });
});

// Points System
Route::prefix('points')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [PointController::class, 'index']);
        Route::get('/my-points', [PointController::class, 'myPoints']);
    });

    Route::middleware(['auth', 'can:manage-points'])->group(function () {
        Route::post('/award', [PointController::class, 'awardPoints']);
        Route::get('/users/{user}', [PointController::class, 'userSummary']);
    });

    // Partner routes for point redemption
    Route::middleware(['auth', 'partner.role'])->group(function () {
        Route::post('/redeem', [PointController::class, 'redeemPoints']);
    });
});

// Product Management
Route::prefix('products')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::get('/{product}', [App\Http\Controllers\Api\ProductController::class, 'show']);
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/partner/stats', [App\Http\Controllers\Api\ProductController::class, 'salesStats']);
        Route::post('/', [App\Http\Controllers\Api\ProductController::class, 'store']);
        Route::put('/{product}', [App\Http\Controllers\Api\ProductController::class, 'update']);
        Route::post('/{product}', [App\Http\Controllers\Api\ProductController::class, 'update']); // For file uploads
        Route::delete('/{product}', [App\Http\Controllers\Api\ProductController::class, 'destroy']);
    });
});

// Purchase Management
Route::prefix('purchases')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\Api\PurchaseController::class, 'index']);
    Route::post('/', [App\Http\Controllers\Api\PurchaseController::class, 'store']);
    Route::get('/stats', [App\Http\Controllers\Api\PurchaseController::class, 'partnerStats']);
    Route::post('/verify', [App\Http\Controllers\Api\PurchaseController::class, 'verify']);
    Route::get('/{purchase}', [App\Http\Controllers\Api\PurchaseController::class, 'show']);
    Route::post('/{purchase}/confirm', [App\Http\Controllers\Api\PurchaseController::class, 'confirm']);
    Route::post('/{purchase}/complete', [App\Http\Controllers\Api\PurchaseController::class, 'complete']);
    Route::post('/{purchase}/cancel', [App\Http\Controllers\Api\PurchaseController::class, 'cancel']);
});

// Partner Info routes
Route::prefix('businesses')->group(function () {
    // Public routes
    Route::get('/', [PartnerInfoController::class, 'index']);
    Route::get('/categories', [PartnerInfoController::class, 'categories']);
    Route::get('/{id}', [PartnerInfoController::class, 'showBusiness']);
    
    // Protected routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/my/info', [PartnerInfoController::class, 'show']);
        Route::post('/', [PartnerInfoController::class, 'store']);
        Route::post('/update', [PartnerInfoController::class, 'store']); // For file uploads
    });
});

// Partner Management
Route::apiResource('partners', PartnerController::class);

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard-stats', [App\Http\Controllers\Api\AdminController::class, 'dashboardStats']);
    Route::get('/users', [App\Http\Controllers\Api\AdminController::class, 'users']);
    Route::put('/users/{user}/role', [App\Http\Controllers\Api\AdminController::class, 'updateUserRole']);
    
        // Enhanced event management routes
        Route::prefix('events')->group(function () {
            Route::get('/', [EventController::class, 'index']);
            Route::post('/', [EventController::class, 'store']);
            Route::get('/{event}', [EventController::class, 'show']);
            Route::put('/{event}', [EventController::class, 'update']);
            Route::post('/{event}', [EventController::class, 'update']); // For file uploads with _method=PUT
            Route::delete('/{event}', [EventController::class, 'destroy']);
            
            // Event registrations management
            Route::get('/{event}/registrations', [EventRegistrationController::class, 'index']);
            
            // Event attendance management (volunteer events only)
            Route::get('/{event}/attendance', [App\Http\Controllers\Api\AttendanceController::class, 'getEventAttendance']);
            Route::post('/{event}/attendance', [App\Http\Controllers\Api\AttendanceController::class, 'confirmAttendance']);
            Route::post('/{event}/attendance/bulk', [App\Http\Controllers\Api\AttendanceController::class, 'bulkUpdateAttendance']);
        });
    
    // Enhanced category management
    Route::prefix('categories')->group(function () {
        Route::get('/', [EventCategoryController::class, 'index']);
        Route::post('/', [EventCategoryController::class, 'store']);
        Route::get('/{eventCategory}', [EventCategoryController::class, 'show']);
        Route::put('/{eventCategory}', [EventCategoryController::class, 'update']);
        Route::delete('/{eventCategory}', [EventCategoryController::class, 'destroy']);
    });
    
    // Partner management
    Route::prefix('partners')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\AdminPartnerController::class, 'index']);
        Route::get('/stats', [App\Http\Controllers\Api\AdminPartnerController::class, 'stats']);
        Route::post('/', [App\Http\Controllers\Api\AdminPartnerController::class, 'store']);
        Route::get('/{partner}', [App\Http\Controllers\Api\AdminPartnerController::class, 'show']);
        Route::put('/{partner}', [App\Http\Controllers\Api\AdminPartnerController::class, 'update']);
        Route::put('/{partner}/toggle-status', [App\Http\Controllers\Api\AdminPartnerController::class, 'toggleStatus']);
        Route::delete('/{partner}', [App\Http\Controllers\Api\AdminPartnerController::class, 'destroy']);
    });
});

// Temporary debug route
Route::get('/debug-db', function () {
    try {
        DB::connection()->getPdo();
        $dbName = DB::connection()->getDatabaseName();
        return response()->json([
            'connected' => true,
            'database' => $dbName,
            'connection' => config('database.default'),
            'host' => config('database.connections.mysql.host'),
            'username' => config('database.connections.mysql.username')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'connected' => false,
            'error' => $e->getMessage(),
            'connection' => config('database.default'),
            'host' => config('database.connections.mysql.host'),
            'username' => config('database.connections.mysql.username')
        ], 500);
    }
});
