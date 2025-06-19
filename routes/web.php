<?php

use App\Http\Controllers\admin\InfoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\AdminCourseController;
use App\Http\Controllers\backend\AdminCourseGoalController;
use App\Http\Controllers\backend\AdminCourseContentController;
use App\Http\Controllers\backend\AdminInstructorController;
use App\Http\Controllers\backend\AdminProfileController;
use App\Http\Controllers\backend\BackendOrderController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\CouponController;
use App\Http\Controllers\backend\CourseController;
use App\Http\Controllers\backend\CourseSectionController;
use App\Http\Controllers\backend\InstructorController;
use App\Http\Controllers\backend\InstructorProfileController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\SubcategoryController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\UserProfileController;
use App\Http\Controllers\backend\CourseLearningController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\frontend\FrontendDashboardController;
use App\Http\Controllers\frontend\WishlistController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\XenditController;



/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */



/* Admin Route   */

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');


Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'destroy'])
        ->name('logout');

    /*  control Profile */

    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::post('/profile/store', [AdminProfileController::class, 'store'])->name('profile.store');
    Route::get('/setting', [AdminProfileController::class, 'setting'])->name('setting');
    Route::post('/password/setting', [AdminProfileController::class, 'passwordSetting'])->name('passwordSetting');

    /*  control Category & Subcategory  */

    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubcategoryController::class);

    /* Control Slider */
    Route::resource('slider', SliderController::class);

     /* control Course  */

    Route::resource('course', AdminCourseController::class);
    Route::post('/course-status', [AdminCourseController::class, 'updateStatus'])->name('course.status');
    
    /* control Course Goals */
    Route::get('/course/{course}/goals', [AdminCourseGoalController::class, 'index'])->name('course.goals.index');
    Route::get('/course/{course}/goals/create', [AdminCourseGoalController::class, 'create'])->name('course.goals.create');
    Route::post('/course/{course}/goals', [AdminCourseGoalController::class, 'store'])->name('course.goals.store');
    Route::get('/course/{course}/goals/{goal}/edit', [AdminCourseGoalController::class, 'edit'])->name('course.goals.edit');
    Route::put('/course/{course}/goals/{goal}', [AdminCourseGoalController::class, 'update'])->name('course.goals.update');
    Route::delete('/course/{course}/goals/{goal}', [AdminCourseGoalController::class, 'destroy'])->name('course.goals.destroy');
    Route::post('/course-goals/store-multiple', [AdminCourseGoalController::class, 'storeMultiple'])->name('course.goals.storeMultiple');
    
    /* control Course Content */
    Route::get('/course/{course}/content', [AdminCourseContentController::class, 'index'])->name('course.content.index');
    Route::post('/course/{course}/sections', [AdminCourseContentController::class, 'storeSection'])->name('course.sections.store');
    Route::put('/course/{course}/sections/{section}', [AdminCourseContentController::class, 'updateSection'])->name('course.sections.update');
    Route::delete('/course/{course}/sections/{section}', [AdminCourseContentController::class, 'deleteSection'])->name('course.sections.destroy');
    Route::post('/course/{course}/sections/{section}/lectures', [AdminCourseContentController::class, 'storeLecture'])->name('course.lectures.store');
    Route::put('/course/{course}/sections/{section}/lectures/{lecture}', [AdminCourseContentController::class, 'updateLecture'])->name('course.lectures.update');
    Route::delete('/course/{course}/sections/{section}/lectures/{lecture}', [AdminCourseContentController::class, 'deleteLecture'])->name('course.lectures.destroy');
    Route::post('/course/{course}/sections/reorder', [AdminCourseContentController::class, 'reorderSections'])->name('course.sections.reorder');
    Route::post('/course/{course}/sections/{section}/lectures/reorder', [AdminCourseContentController::class, 'reorderLectures'])->name('course.lectures.reorder');

    /*  order controller  */
    Route::resource('order', BackendOrderController::class);

    /* Mange Info */
    Route::resource('info', InfoController::class);

    /* control instructor  */
    Route::resource('instructor', AdminInstructorController::class);
    Route::post('/update-status', [AdminInstructorController::class, 'updateStatus'])->name('instructor.status');
    Route::get('/instructor-active-list', [AdminInstructorController::class, 'instructorActive'])->name('instructor.active');

    /*  Setting Controller */
    Route::get('/mail-setting', [SettingController::class, 'mailSetting'])->name('mailSetting');
    Route::post('/mail-settings/update', [SettingController::class, 'updateMailSettings'])->name('mail.settings.update');

    Route::get('/google-setting', [SettingController::class, 'googleSetting'])->name('googleSetting');
    Route::post('/google-settings/update', [SettingController::class, 'updateGoogleSettings'])->name('admin.google.settings.update');


});


/*  Instructor Route  */
Route::get('/instructor/login', [InstructorController::class, 'login'])->name('instructor.login');
Route::get('/instructor/register', [InstructorController::class, 'register'])->name('instructor.register');
Route::middleware(['auth', 'verified', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [InstructorController::class, 'destroy'])
        ->name('logout');

    Route::get('/profile', [InstructorProfileController::class, 'index'])->name('profile');
    Route::post('/profile/store', [InstructorProfileController::class, 'store'])->name('profile.store');
    Route::get('/setting', [InstructorProfileController::class, 'setting'])->name('setting');
    Route::post('/password/setting', [InstructorProfileController::class, 'passwordSetting'])->name('passwordSetting');

    Route::resource('course', CourseController::class);
    Route::get('/get-subcategories/{categoryId}', [CategoryController::class, 'getSubcategories']);

    Route::resource('course-section', CourseSectionController::class);

    Route::resource('lecture', LectureController::class);

    Route::resource('coupon', CouponController::class);
});


//user Route

Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-courses', [UserController::class, 'myCourses'])->name('my.courses');
    Route::get('/messages', [UserController::class, 'messages'])->name('messages');
    Route::get('/purchase-history', [UserController::class, 'purchaseHistory'])->name('purchase.history');
    
    // Course Learning Routes
    Route::get('/course/{courseId}/learn', [CourseLearningController::class, 'show'])->name('course.learn');
    Route::get('/course/{courseId}/lecture/{lectureId}', [CourseLearningController::class, 'lecture'])->name('course.lecture');
    Route::post('/lecture/{lectureId}/complete', [CourseLearningController::class, 'completeLecture'])->name('lecture.complete');
    
    Route::post('/logout', [UserController::class, 'destroy'])
        ->name('logout');

    //Profile

    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::post('/profile/store', [UserProfileController::class, 'store'])->name('profile.store');
    Route::get('/setting', [UserProfileController::class, 'setting'])->name('setting');
    Route::post('/password/setting', [UserProfileController::class, 'passwordSetting'])->name('passwordSetting');

    /* Wishlist controller */

    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('/wishlist-data', [WishlistController::class, 'getWishlist']);
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});


//Frontend Route

Route::get('/', [FrontendDashboardController::class, 'home'])->name('frontend.home');
Route::get('/all-courses', [FrontendDashboardController::class, 'allCourses'])->name('all.courses');
Route::get('/courses/category/{slug}', [FrontendDashboardController::class, 'coursesByCategory'])->name('courses.by.category');
Route::get('/course-details/{slug}', [FrontendDashboardController::class, 'view'])->name('course-details');

/* wishlist controller  */

Route::get('/wishlist/all', [WishlistController::class, 'allWishlist']);
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist']);

/* Cart Controller */
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/all', [CartController::class, 'cartAll']);
Route::get('/fetch/cart', [CartController::class, 'fetchCart']);
Route::post('/remove/cart', [CartController::class, 'removeCart']);
Route::post('/cart/clear-after-payment', [CartController::class, 'clearCartAfterPayment'])->name('cart.clear');


/*  Checkout */
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
/* Coupon Apply    */
Route::post('/apply-coupon', [CouponController::class, 'applyCoupon']);


/* Auth Protected Route */

Route::middleware('auth')->group(function () {

    /* Order  */
    Route::post('/order', [OrderController::class, 'order'])->name('order');
    Route::get('/payment-success', [OrderController::class, 'success'])->name('success');
    Route::get('/payment-cancel', [OrderController::class, 'cancel'])->name('cancel');
    
    /* Xendit Payment Routes */
    Route::get('/xendit/payment', [XenditController::class, 'redirectToCheckout'])->name('xendit.payment.redirect');
    Route::post('/xendit/payment', [XenditController::class, 'createPayment'])->name('xendit.payment');
    Route::get('/xendit/status', [XenditController::class, 'checkStatus'])->name('xendit.status');
    
    //Route::resource('rating', RatingController::class);
});

/* Xendit Webhook (No Auth Required) */
Route::post('/xendit/webhook', [XenditController::class, 'webhook'])->name('xendit.webhook');

/* Payment Pages */
Route::get('/payment/success', [XenditController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [XenditController::class, 'failed'])->name('payment.failed');


// Test route to debug Google OAuth configuration
Route::get('/test-google-config', function () {
    return [
        'client_id' => config('services.google.client_id'),
        'client_secret' => config('services.google.client_secret') ? 'SET' : 'NOT SET',
        'redirect' => config('services.google.redirect'),
        'app_url' => config('app.url'),
        'current_url' => url('/auth/google-callback'),
    ];
});

// Test route untuk melihat URL redirect Google OAuth
Route::get('/test-google-redirect', function () {
    try {
        $socialite = Laravel\Socialite\Facades\Socialite::driver('google');
        // Get the redirect URL by building it manually
        $clientId = config('services.google.client_id');
        $redirectUri = config('services.google.redirect');
        
        return [
            'config_redirect' => $redirectUri,
            'client_id' => $clientId,
            'client_secret_set' => config('services.google.client_secret') ? 'YES' : 'NO',
            'google_oauth_url' => 'https://accounts.google.com/o/oauth2/auth?client_id=' . $clientId . '&redirect_uri=' . urlencode($redirectUri),
            'note' => 'URL redirect ini harus sama persis dengan yang ada di Google Console',
            'instructions' => [
                '1. Buka Google Cloud Console',
                '2. Pilih project dengan Client ID di atas',
                '3. Buka APIs & Services > Credentials',
                '4. Edit OAuth 2.0 Client ID',
                '5. Tambahkan URL: ' . $redirectUri,
                '6. Save'
            ]
        ];
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'config_redirect' => config('services.google.redirect'),
            'client_id' => config('services.google.client_id')
        ];
    }
});

// Test route untuk Google OAuth langsung
Route::get('/test-google-auth', function () {
    try {
        return Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'config' => [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret') ? 'SET' : 'NOT SET',
                'redirect' => config('services.google.redirect')
            ]
        ];
    }
});

// Debug route untuk Google OAuth
Route::get('/debug-google', function () {
    $config = config('services.google');
    return view('debug-google', compact('config'));
});




require __DIR__ . '/auth.php';
