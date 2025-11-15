<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
// use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\StockMovementController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CategoryAccessMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Suppliers
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('admin.suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('admin.suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('admin.suppliers.store');
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('admin.suppliers.edit');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('admin.suppliers.update');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('admin.suppliers.destroy');

    // Products
    Route::resource('products', ProductController::class);

    // Sales
    // Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    // Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::resource('sales', SaleController::class)->except(['show']);
    // Route::get('/sales/report/download', [SaleController::class, 'downloadReport'])->name('sales.report.download');
    Route::get('/sales/download-report', [SaleController::class, 'downloadReport'])
     ->name('sales.downloadReport');


    // Notifications
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Password update route
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');



    //category
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/edit', [CategoryController::class, 'index'])->name('admin.categories.edit');
    Route::get('/categories/destroy', [CategoryController::class, 'index'])->name('admin.categories.destroy');

    // Admin-only route group
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        // Route::resource('suppliers', SupplierController::class)->except(['show']);

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // ✅ Purchases Routes
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/{id}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/{id}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
    Route::get('/purchases/report/download', [PurchaseController::class, 'downloadReport'])->name('purchase.report.download');
    Route::get('/purchase-info/{id}', [ProductController::class, 'getPurchaseInfo']);



    // ✅ Optional: Supplier-wise purchase history
    Route::get('/purchases/supplier/{supplier_id}', [PurchaseController::class, 'supplierHistory'])
        ->name('purchases.supplier.history');


    // ✅ Purchase Items Routes
     Route::resource('purchase_items', PurchaseItemController::class);
     // Sales
Route::get('/reports/sales', [SaleController::class, 'salesReport'])->name('sales.report');
Route::get('/reports/invoice/{id}', [SaleController::class, 'invoiceBill'])->name('sales.invoice');

// Customers
Route::get('/reports/customer/{id}', [SaleController::class, 'customerReport'])->name('sales.customer_report');
Route::get('/reports/customers/all', [SaleController::class, 'allCustomersReport'])->name('sales.all_customers');

// Products
Route::get('/reports/products', [SaleController::class, 'productReport'])->name('sales.product_report');

    // customer routes
    Route::resource('customers', CustomerController::class);

    // stock movement routes
    Route::resource('stock-movements', StockMovementController::class);
    Route::get('/stock-movements/download/pdf', 
    [StockMovementController::class, 'downloadReport'])
    ->name('stock_movement.report');



    // Test route for debugging roles
    Route::get('/test-role', function () {
        return response()->json([
            'user' => auth()->user()->name,
            'email' => auth()->user()->email,
            'roles' => auth()->user()->getRoleNames(),
            'is_admin' => auth()->user()->hasRole('admin'),
            'is_shopkeeper' => auth()->user()->hasRole('shopkeeper')
        ]);
    })->name('test.role');
});
