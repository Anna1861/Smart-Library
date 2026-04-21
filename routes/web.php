<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BorrowController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SensorReadingController ;

Route::get('/test-db', function () {
    return DB::connection()->getPdo();
});

Route::get('/', [DashboardController::class, 'index']);

Route::post('/books/{book}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
Route::post('/books/{book}/return', [BookController::class, 'return'])->name('books.return');

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/genre', [AdminController::class, 'storeGenre'])->name('admin.genre.store');
Route::post('/admin/book', [AdminController::class, 'storeBook'])->name('admin.book.store');

Route::get('/borrow', [BorrowController::class, 'index'])->name('borrow.index');
Route::post('/borrow', [BorrowController::class, 'borrowBook'])->name('borrow.book');


Route::post('/api/sensors/store', [SensorReadingController::class, 'store']);
