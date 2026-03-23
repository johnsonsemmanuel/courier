<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Static pages
Route::get('/about', [App\Http\Controllers\PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [App\Http\Controllers\PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [App\Http\Controllers\PageController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/privacy', [App\Http\Controllers\PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/terms', [App\Http\Controllers\PageController::class, 'terms'])->name('pages.terms');
Route::get('/personal', [App\Http\Controllers\PageController::class, 'personal'])->name('pages.personal');
Route::get('/business', [App\Http\Controllers\PageController::class, 'business'])->name('pages.business');
Route::get('/loans', [App\Http\Controllers\PageController::class, 'loans'])->name('pages.loans');
Route::get('/investments', [App\Http\Controllers\PageController::class, 'investments'])->name('pages.investments');
Route::get('/support', [App\Http\Controllers\PageController::class, 'support'])->name('pages.support');

// Password Reset routes
Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'reset'])->name('password.update');

// Email verification (logged-in users may be unverified)
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('dashboard')->with('success', 'Your email has been verified. Welcome!');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

// Protected routes (email must be verified)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/send-money', [TransactionController::class, 'showSendMoney'])->name('send-money');
    Route::post('/send-money', [TransactionController::class, 'sendMoney'])->middleware('throttle:10,1');
    Route::get('/deposit', [TransactionController::class, 'showDeposit'])->name('deposit');
    Route::post('/deposit', [TransactionController::class, 'deposit'])->middleware('throttle:10,1');
    Route::post('/deposit/stripe', [TransactionController::class, 'depositStripe'])->name('deposit.stripe')->middleware('throttle:10,1');
    Route::post('/deposit/bank', [TransactionController::class, 'depositBank'])->name('deposit.bank')->middleware('throttle:10,1');
    Route::get('/withdraw', [TransactionController::class, 'showWithdraw'])->name('withdraw');
    Route::post('/withdraw', [TransactionController::class, 'withdraw'])->middleware('throttle:10,1');
    Route::get('/transactions/{id}/receipt', [App\Http\Controllers\StatementController::class, 'downloadReceipt'])->name('transactions.receipt');
    
    // Statements
    Route::get('/statements', [App\Http\Controllers\StatementController::class, 'index'])->name('statements.index');
    Route::post('/statements/download', [App\Http\Controllers\StatementController::class, 'download'])->name('statements.download');
    
    // Beneficiaries
    Route::resource('beneficiaries', App\Http\Controllers\BeneficiaryController::class);
    
    // Recurring Transfers
    Route::get('/recurring-transfers', [App\Http\Controllers\RecurringTransferController::class, 'index'])->name('recurring-transfers.index');
    Route::get('/recurring-transfers/create', [App\Http\Controllers\RecurringTransferController::class, 'create'])->name('recurring-transfers.create');
    Route::post('/recurring-transfers', [App\Http\Controllers\RecurringTransferController::class, 'store'])->name('recurring-transfers.store');
    Route::post('/recurring-transfers/{recurringTransfer}/pause', [App\Http\Controllers\RecurringTransferController::class, 'pause'])->name('recurring-transfers.pause');
    Route::post('/recurring-transfers/{recurringTransfer}/resume', [App\Http\Controllers\RecurringTransferController::class, 'resume'])->name('recurring-transfers.resume');
    Route::post('/recurring-transfers/{recurringTransfer}/cancel', [App\Http\Controllers\RecurringTransferController::class, 'cancel'])->name('recurring-transfers.cancel');
    Route::delete('/recurring-transfers/{recurringTransfer}', [App\Http\Controllers\RecurringTransferController::class, 'destroy'])->name('recurring-transfers.destroy');
    
    // Bill Payments
    Route::get('/bills', [App\Http\Controllers\BillPaymentController::class, 'index'])->name('bills.index');
    Route::get('/bills/create', [App\Http\Controllers\BillPaymentController::class, 'create'])->name('bills.create');
    Route::post('/bills', [App\Http\Controllers\BillPaymentController::class, 'store'])->name('bills.store')->middleware('throttle:10,1');
    Route::get('/bills/payees', [App\Http\Controllers\BillPaymentController::class, 'payees'])->name('bills.payees');
    Route::get('/bills/payees/create', [App\Http\Controllers\BillPaymentController::class, 'createPayee'])->name('bills.create-payee');
    Route::post('/bills/payees', [App\Http\Controllers\BillPaymentController::class, 'storePayee'])->name('bills.store-payee');
    Route::get('/bills/payees/{payee}/edit', [App\Http\Controllers\BillPaymentController::class, 'editPayee'])->name('bills.edit-payee');
    Route::put('/bills/payees/{payee}', [App\Http\Controllers\BillPaymentController::class, 'updatePayee'])->name('bills.update-payee');
    Route::delete('/bills/payees/{payee}', [App\Http\Controllers\BillPaymentController::class, 'destroyPayee'])->name('bills.destroy-payee');
    Route::post('/bills/payees/{payee}/favorite', [App\Http\Controllers\BillPaymentController::class, 'toggleFavorite'])->name('bills.toggle-favorite');
    
    // Virtual Cards
    Route::get('/cards', [App\Http\Controllers\CardController::class, 'index'])->name('cards.index');
    Route::get('/cards/create', [App\Http\Controllers\CardController::class, 'create'])->name('cards.create');
    Route::post('/cards', [App\Http\Controllers\CardController::class, 'store'])->name('cards.store');
    Route::get('/cards/{card}', [App\Http\Controllers\CardController::class, 'show'])->name('cards.show');
    Route::post('/cards/{card}/freeze', [App\Http\Controllers\CardController::class, 'freeze'])->name('cards.freeze');
    Route::post('/cards/{card}/unfreeze', [App\Http\Controllers\CardController::class, 'unfreeze'])->name('cards.unfreeze');
    Route::put('/cards/{card}/limits', [App\Http\Controllers\CardController::class, 'updateLimits'])->name('cards.update-limits');
    Route::post('/cards/{card}/cancel', [App\Http\Controllers\CardController::class, 'cancel'])->name('cards.cancel');
    
    // Admin routes (requires is_admin — see IsAdmin middleware)
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users/create', [AdminController::class, 'createUserForm'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/tax-alert', [AdminController::class, 'manageTaxAlert'])->name('tax-alert');
        Route::post('/users/{user}/add-funds', [AdminController::class, 'addFunds'])->name('add-funds');
        Route::post('/users/{user}/freeze', [AdminController::class, 'freezeAccount'])->name('freeze-account');
        Route::post('/users/{user}/unfreeze', [AdminController::class, 'unfreezeAccount'])->name('unfreeze-account');
        Route::post('/users/{user}/withhold-funds', [AdminController::class, 'withholdFunds'])->name('withhold-funds');
        Route::post('/users/{user}/release-funds', [AdminController::class, 'releaseFunds'])->name('release-funds');
    });
});
