<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LetterOfAcceptanceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\VirtualAccountController;
use App\Http\Controllers\BankTransferController;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:super_admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('/users/{id}/change-password', [UserController::class, 'updateUserPassword']);
        Route::apiResource('virtualaccounts', VirtualAccountController::class);
        Route::apiResource('banktransfers', BankTransferController::class);
    });
    
    Route::middleware('role:super_admin,admin_icodsa')->group(function () {
        Route::post('/change-password', [UserController::class, 'changePassword']);
        Route::apiResource('letterofacceptances', LetterOfAcceptanceController::class);
        Route::get('/letter-of-acceptance/download/{paper_id}', [LetterofAcceptanceController::class, 'downloadPDF']);
        Route::apiResource('invoices', InvoiceController::class);
        Route::get('/invoice/download/{id}', [InvoiceController::class, 'downloadPDF']);
        Route::apiResource('receipts', ReceiptController::class);
        Route::get('/receipt/download/{id}', [ReceiptController::class, 'downloadPDF']);
    });
});
