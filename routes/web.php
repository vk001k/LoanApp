<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\AdminController;
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

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();


//user routes
Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/home', [HomeController::class, 'loanRequestLists'])->name('home');
    Route::get('loan-request',[HomeController::class, 'loanRequest'])->name('loan-request');
    Route::post('loan-request/process',[HomeController::class, 'loanRequestProcess'])->name('loan-request.process');
    Route::get('loan-details/{loan_id}',[HomeController::class, 'loanDetails'])->name('loan-details');
    Route::post('repayment/process/{repay_id}',[HomeController::class, 'repaymentProcess'])->name('repayment.process');
});


//admin routes

Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('admin/loan-details/{loan_id}',[AdminController::class, 'loanDetails'])->name('admin.loan-details');
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::post('admin/loan-status/{loan_id}', [AdminController::class, 'updateLoanStatus'])->name('admin.update-loan-status');
});