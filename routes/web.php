<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Cars;
use App\Livewire\Incomes;
use App\Livewire\Expenses;
use App\Livewire\Documents\{
    Car\Index as CarDocumentsIndex,
    Car\Create as CarDocumentCreate,
    Car\Edit as CarDocumentEdit,
    Company\Index as CompanyDocumentsIndex,
    Company\Create as CompanyDocumentCreate,
    Company\Edit as CompanyDocumentEdit
};
use App\Livewire\Settings\Index as Settings;
use App\Http\Controllers\PushSubscriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Cars routes
    Route::get('/cars', Cars\Index::class)->name('cars.index');
    Route::get('/cars/create', Cars\Create::class)->name('cars.create');
    Route::get('/cars/{car}', Cars\Edit::class)->name('cars.edit');

    // Income routes
    Route::get('/incomes', Incomes\Index::class)->name('incomes.index');
    Route::get('/incomes/create', Incomes\Create::class)->name('incomes.create');
    Route::get('/incomes/{income}', Incomes\Edit::class)->name('incomes.edit');

    // Expense routes
    Route::get('/expenses', Expenses\Index::class)->name('expenses.index');
    Route::get('/expenses/create', Expenses\Create::class)->name('expenses.create');
    Route::get('/expenses/{expense}', Expenses\Edit::class)->name('expenses.edit');

    // Reports routes
    Route::get('/reports', App\Livewire\Reports\Index::class)->name('reports.index');

    // Document routes
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', function() {
            return redirect()->route('documents.car.index');
        })->name('index');

        // Car Documents
        Route::prefix('car')->name('car.')->group(function () {
            Route::get('/', CarDocumentsIndex::class)->name('index');
            Route::get('/create', CarDocumentCreate::class)->name('create');
            Route::get('/{document}', CarDocumentEdit::class)->name('edit');
        });

        // Company Documents
        Route::prefix('company')->name('company.')->group(function () {
            Route::get('/', CompanyDocumentsIndex::class)->name('index');
            Route::get('/create', CompanyDocumentCreate::class)->name('create');
            Route::get('/{document}', CompanyDocumentEdit::class)->name('edit');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Push Notification Routes
    Route::post('/push-subscription', [PushSubscriptionController::class, 'store'])->name('push-subscription.store');
    Route::delete('/push-subscription', [PushSubscriptionController::class, 'destroy'])->name('push-subscription.destroy');

    Route::get('/settings', Settings::class)->name('settings.index');
});

// Offline Route
Route::get('/offline', function () {
    return view('offline');
})->name('offline');

require __DIR__.'/auth.php';
