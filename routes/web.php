<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\DashboardController; // Vamos criar este controller a seguir
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


// --- ROTAS DA LOJA PRINCIPAL ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categoria/{slug}', [CategoryController::class, 'show'])->name('category.show');



// --- ROTAS DO PAINEL ADMINISTRATIVO ---
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rotas de Autenticação
    Route::get('login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

    // Rotas Protegidas
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
        Route::resource('admins', App\Http\Controllers\Admin\AdminController::class);
        Route::resource('coupons', App\Http\Controllers\Admin\CouponController::class);
        Route::resource('carousels', App\Http\Controllers\Admin\CarouselController::class);

        Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // --- COLOQUE AS ROTAS DE E-MAIL AQUI ---
        Route::get('email-templates', [App\Http\Controllers\Admin\EmailTemplateController::class, 'index'])->name('email-templates.index');
        Route::get('email-templates/create', [App\Http\Controllers\Admin\EmailTemplateController::class, 'create'])->name('email-templates.create'); // ADICIONAR
        Route::post('email-templates', [App\Http\Controllers\Admin\EmailTemplateController::class, 'store'])->name('email-templates.store'); // ADICIONAR
        Route::get('email-templates/{template}/edit', [App\Http\Controllers\Admin\EmailTemplateController::class, 'edit'])->name('email-templates.edit');
        Route::put('email-templates/{template}', [App\Http\Controllers\Admin\EmailTemplateController::class, 'update'])->name('email-templates.update');
        Route::delete('email-templates/{template}', [App\Http\Controllers\Admin\EmailTemplateController::class, 'destroy'])->name('email-templates.destroy'); // ADICIONAR
        Route::get('inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
        Route::post('inventory/update', [\App\Http\Controllers\Admin\InventoryController::class, 'update'])->name('inventory.update');
        Route::post('products/{product}/keys', [\App\Http\Controllers\Admin\ProductKeyController::class, 'store'])->name('products.keys.store');
        Route::get('products/{product}/keys', [\App\Http\Controllers\Admin\ProductKeyController::class, 'index'])->name('products.keys.index');
        Route::post('products/{product}/keys', [\App\Http\Controllers\Admin\ProductKeyController::class, 'store'])->name('products.keys.store');
        Route::delete('products/keys/{key}', [\App\Http\Controllers\Admin\ProductKeyController::class, 'destroy'])->name('products.keys.destroy');
        Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/update-status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::get('logs', [\App\Http\Controllers\Admin\LogController::class, 'access'])->name('logs.access');
        Route::get('analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('notifications/{notification}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('categories/reorder', [\App\Http\Controllers\Admin\CategoryController::class, 'reorder'])->name('categories.reorder');
        Route::post('categories/{category}/products/reorder', [\App\Http\Controllers\Admin\CategoryController::class, 'reorderProducts'])->name('categories.products.reorder');
    });

});

// Rota temporária para o login de clientes
Route::get('/login', function () {
    return 'Esta será a página de login para clientes.';
})->name('login');