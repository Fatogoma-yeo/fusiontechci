<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProviderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProcurementController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ExpensesCategoriesController;
use App\Http\Controllers\Dashboard\ExpensesController;
use App\Http\Controllers\InventoryController;
use App\Mail\OwnerNotificate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => '/', 'middleware' => ['auth', 'verified']], function ()
{
    // Route::get('mail', function () {
    //     return new OwnerNotificate();
    // });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('orders', OrdersController::class);
    Route::get('order', [OrdersController::class, 'wishlist'])->name('order.wishlist');
    Route::delete('delete', [OrdersController::class, 'pos_product'])->name('delete.pos_product');
    Route::get('gross', [OrdersController::class, 'price'])->name('gross.price');
    Route::get('pos', [OrdersController::class, 'search'])->name('pos.search');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('providers', ProviderController::class);
    Route::resource('clients', ClientController::class);
    Route::get('customers', [ClientController::class, 'posCustomer'])->name('customers.pos');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('search', [ProductController::class, 'search'])->name('product.search');
    Route::match(['get', 'post'], 'product/stock-ajustment', [ProductController::class, 'showStockAdjustment'])->name('product.stock-ajustment');
    Route::resource('procurements', ProcurementController::class);
    Route::get('product', [ProcurementController::class, 'get'])->name('product.get');
    Route::get('paid', [ProcurementController::class, 'procured'])->name('paid.procured');
    Route::resource('expenses', ExpensesController::class);
    Route::get('cash-flow/history', [ExpensesController::class, 'cashFlowHistory'])->name('expenses.history');
    Route::resource('expense_categories', ExpensesCategoriesController::class);
    Route::resource('notifications', NotificationController::class);
});
Route::middleware('auth')->group(function ()
{
  Route::resource('inventories', InventoryController::class);
  Route::match(['get', 'post'], 'inventory/validate', [InventoryController::class, 'inventoryValidate'])->name('inventory.validate');
  Route::match(['get', 'post'], 'inventory/physic-stock-hs', [InventoryController::class, 'inventoryPhysicStockHs'])->name('inventory.physic-stock-hs');
  Route::match(['get', 'post'], 'inventory/stock-validate', [InventoryController::class, 'inventoryStockValidate'])->name('inventory.stock-validate');
  Route::get('inventory/stock-hs', [InventoryController::class, 'inventoryStockHs'])->name('inventory.stock-hs');

});

Route::middleware('auth')->group(function ()
{
    Route::get('/reports/sales', [ReportsController::class, 'salesReport'])->name('report.sales');
    Route::get('/reports/sales-progress', [ReportsController::class, 'salesProgress'])->name('report.sales-progress');
    Route::get('/reports/low-stock', [ReportsController::class, 'lowStockReport'])->name('report.low-stock');
    Route::get('/reports/sold-stock', [ReportsController::class, 'soldStockReport'])->name('report.sold-stock');
    Route::get('/reports/profit', [ReportsController::class, 'profitReport'])->name('report.profit');
    Route::get('/reports/cash-flow', [ReportsController::class, 'cashFlowReport'])->name('report.cash-flow');
    Route::get('/reports/flux-history', [ReportsController::class, 'fluxHistoryReport'])->name('report.flux-history');
});

Route::middleware('auth')->group(function ()
{
    Route::get( 'notification', [ NotificationController::class, 'deleteSingleNotification' ])->name('notifications.deleteSingle');
    Route::get( 'notifications', [ NotificationController::class, 'deletAllNotifications' ])->name('notifications.deletAll');
});

require __DIR__.'/auth.php';
