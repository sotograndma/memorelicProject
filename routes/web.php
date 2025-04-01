<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\ItemController;
use App\Http\Controllers\Customer\AuctionController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\BidController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\Customer\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

// Middleware untuk menangani redirect setelah login
Route::get('/redirect', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'customer') {
        return redirect()->route('customer.dashboard');
    } else {
        return redirect()->route('dashboard');
    }
})->name('redirect');

// Halaman khusus admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/sidebar', [AdminController::class, 'index'])->name('admin.sidebar');

    // Manajemen akun secara umum
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');

    // CRUD untuk akun Admin
    Route::get('/users/create/admin', [AdminUserController::class, 'createAdmin'])->name('admin.users.create.admin');
    Route::post('/users/admin', [AdminUserController::class, 'storeAdmin'])->name('admin.users.store.admin');

    // CRUD untuk akun Customer
    Route::get('/users/create/customer', [AdminUserController::class, 'createCustomer'])->name('admin.users.create.customer');
    Route::post('/users/customer', [AdminUserController::class, 'storeCustomer'])->name('admin.users.store.customer');

    // Edit & Delete Admin atau Customer
    Route::get('/users/{id}/{type}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}/{type}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}/{type}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // CRUD untuk akun Courier (Kurir)
    Route::get('/couriers', [CourierController::class, 'index'])->name('admin.couriers.index');
    Route::get('/couriers/create', [CourierController::class, 'create'])->name('admin.couriers.create');
    Route::post('/couriers', [CourierController::class, 'store'])->name('admin.couriers.store');
    Route::get('/couriers/{id}/edit', [CourierController::class, 'edit'])->name('admin.couriers.edit');
    Route::put('/couriers/{id}', [CourierController::class, 'update'])->name('admin.couriers.update');
    Route::delete('/couriers/{id}', [CourierController::class, 'destroy'])->name('admin.couriers.destroy');
});

// Halaman khusus customer
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');

    // Item (Jual Barang Langsung)
    Route::resource('customer/items', ItemController::class)->names([
        'index'  => 'customer.items.index',
        'create' => 'customer.items.create',
        'store'  => 'customer.items.store',
        'edit'   => 'customer.items.edit',
        'update' => 'customer.items.update',
        'destroy' => 'customer.items.destroy',
        'show'   => 'customer.items.show',
    ]);

    // Auction (Lelang Barang)
    Route::resource('customer/auctions', AuctionController::class)->names([
        'index'  => 'customer.auctions.index',
        'create' => 'customer.auctions.create',
        'store'  => 'customer.auctions.store',
        'edit'   => 'customer.auctions.edit',
        'update' => 'customer.auctions.update',
        'destroy' => 'customer.auctions.destroy',
        'show'   => 'customer.auctions.show',
    ]);

    // Order (Pesanan User)
    Route::get('/customer/orders', [OrderController::class, 'index'])->name('customer.orders.index'); // Semua barang tersedia
    Route::get('/customer/orders/{id}', [OrderController::class, 'show'])->name('customer.orders.show'); // Detail barang
    Route::post('/customer/orders/{id}/buy', [OrderController::class, 'buy'])->name('customer.orders.buy'); // Proses pembelian

    // Bid (Bid yang Diajukan User)
    Route::get('/customer/bids', [BidController::class, 'index'])->name('customer.bids.index'); // Semua barang lelang
    Route::get('/customer/bids/list', [BidController::class, 'list'])->name('customer.bids.list');
    Route::get('/customer/bids/{id}', [BidController::class, 'show'])->name('customer.bids.show'); // Detail barang lelang
    Route::get('/customer/bids/create/{auction}', [BidController::class, 'create'])->name('customer.bids.create');
    Route::post('/customer/bids/store', [BidController::class, 'store'])->name('customer.bids.store');

    // Halaman Transaksi
    Route::get('/transactions', [TransactionController::class, 'transactionHistory'])->name('customer.transactions.history');
    Route::get('/checkout/{item_id}', [TransactionController::class, 'checkout'])->name('customer.checkout');
    Route::post('/checkout/{item_id}', [TransactionController::class, 'processCheckout'])->name('customer.checkout.process');

    // Halaman Kode Pembayaran
    Route::get('/payment/code/{transaction_id}', [TransactionController::class, 'paymentCode'])->name('customer.payment.code');

    // Halaman Proses Pembayaran
    Route::get('/payment/process/{transaction_id}', [TransactionController::class, 'paymentProcess'])->name('customer.payment.process');

    // Halaman Payment Completed
    Route::get('/payment/completed/{transaction_id}', [TransactionController::class, 'paymentCompleted'])->name('customer.payment.completed');

    // Halaman Barang Terjual untuk Penjual
    Route::get('/customer/sold-items', [TransactionController::class, 'soldItems'])->name('customer.sold.items');
});

// Halaman khusus courier (Kurir)
Route::middleware(['auth', 'role:courier'])->prefix('courier')->group(function () {
    Route::get('/dashboard', function () {
        return view('courier.dashboard');
    })->name('courier.dashboard');
});

// Dashboard umum
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
