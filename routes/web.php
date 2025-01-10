<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('homepage');

// Guest routes
Route::middleware(['CekAuth:guest'])->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('login-page');
    Route::post('/login', [UserController::class, 'postLogin'])->name('postLogin');
    Route::get('/register', [UserController::class, 'register'])->name('register-page');
    Route::post('/register', [UserController::class, 'postRegister'])->name('postRegister');
    Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');
    Route::post('/payment', [PaymentController::class, 'postPayment'])->name('postPayment');
    Route::post('/overpaid', [PaymentController::class, 'overpaid'])->name('coins-overpaid');
});

// Authenticated user routes
Route::middleware(['CekAuth:auth'])->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile-images/update', [ProfileController::class, 'updateProfileImages'])->name('profile.updateProfileImages');
    
    // Friends Routes
    Route::get('/friends', [FriendController::class, 'index'])->name('friends');
    Route::post('/friends/add/{user}', [FriendController::class, 'addFriend'])->name('add-friends');
    Route::post('/friends/remove/{user}', [FriendController::class, 'removeFriend'])->name('remove-friends');
    Route::post('/friends/accept/{user}', [FriendController::class, 'acceptFriend'])->name('accept-friends');
    Route::post('/friends/reject/{user}', [FriendController::class, 'rejectFriend'])->name('reject-friends');

    // Chat Routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/messages/{friendId}', [ChatController::class, 'getMessages'])->name('get-messages');
    Route::post('/messages/{friendId}', [ChatController::class, 'sendMessages'])->name('send-messages');

    // Coin Routes
    Route::get('/topup', [CoinController::class, 'index'])->name('topup');
    Route::get('/add-coin', [CoinController::class, 'add_coin'])->name('add-coin');

    // Avatar Routes
    Route::get('/avatar/bought/{avatar_id}', [AvatarController::class, 'bought'])->name('bought-avatar');
    Route::post('/remove-profile', [ProfileController::class, 'invisibleProfile'])->name('invisible-profile');
    Route::post('/restore-profile', [ProfileController::class, 'visibleprofile'])->name('visible-profile');
    
    // Logout Route
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});

// Locale Change Route
Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('set-locale');
