<?php

use App\Http\Controllers\Backend\TravelAllowance\TravelAllowanceBillController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TravelAllowanceBillController::class, 'index'])->name('travelAllowanceBill');
Route::get('/add-new', [TravelAllowanceBillController::class, 'create'])->name('travelAllowanceBill.add');
Route::get('/view/{id}', [TravelAllowanceBillController::class, 'view'])->name('travelAllowanceBill.view');
Route::get('/edit/{id}', [TravelAllowanceBillController::class, 'edit'])->name('travelAllowanceBill.edit');
Route::patch('/update/{id}', [TravelAllowanceBillController::class, 'update'])->name('travelAllowanceBill.update');
Route::post('/add-new', [TravelAllowanceBillController::class, 'store'])->name('travelAllowanceBill.store');
Route::post('/add-new-bill', [TravelAllowanceBillController::class, 'sendBillByMP'])->name('travelAllowanceBill.send-bill-by-mp');
Route::get('/add-new-in-list', [TravelAllowanceBillController::class, 'addNewInList'])->name('travelAllowanceBill.addnewinlist');
Route::get('/add-new-daily-bill-in-list', [TravelAllowanceBillController::class, 'addNewDailybillInList'])->name('travelAllowanceBill.add-new-daily-bill-in-list');
Route::get('/bill-edit-modal', [TravelAllowanceBillController::class, 'billItemEditModal'])->name('travelAllowanceBill.billitemeditmodal');
Route::post('/add-new-daily-allowance', [TravelAllowanceBillController::class, 'addNewDailyAllowance'])->name('travelAllowanceBill.add-new-daily-allowance');
Route::get('/bill-update', [TravelAllowanceBillController::class, 'billItemUpdate'])->name('travelAllowanceBill.billitemupdate');
Route::get('/daily-bill-edit-modal', [TravelAllowanceBillController::class, 'dailyBillItemEditModal'])->name('travelAllowanceBill.dailyBillitemeditmodal');
Route::get('/daily-bill-update', [TravelAllowanceBillController::class, 'dailyBillItemUpdate'])->name('travelAllowanceBill.dailybillitemupdate');
Route::delete('/{id}', [TravelAllowanceBillController::class, 'destroy'])->name('travelAllowanceBill.delete');
Route::delete('remove-bill-item/{id}', [TravelAllowanceBillController::class, 'deleteBillItem'])->name('travelAllowanceBill.deletebillitem');
Route::delete('remove-daily-bill-item/{id}', [TravelAllowanceBillController::class, 'deleteDailyBillItem'])->name('travelAllowanceBill.deletedailybillitem');

Route::get('/bill-send', [TravelAllowanceBillController::class, 'billSend'])->name('travelAllowanceBill.billsend');
Route::get('/waiting-accounts-section-list', [TravelAllowanceBillController::class, 'waitingCccountsSectionList'])->name('travelAllowanceBill.waiting-accounts-section-list');

Route::get('/bill-send-account-section-modal', [TravelAllowanceBillController::class, 'billSendAccountSectionModal'])->name('travelAllowanceBill.bill-send-account-section-modal');
Route::get('/bill-send-account-section', [TravelAllowanceBillController::class, 'billSendAccountSection'])->name('travelAllowanceBill.bill-send-account-section');
Route::get('/unick-bill-number-check', [TravelAllowanceBillController::class, 'unickBillNumberCheck'])->name('travelAllowanceBill.unick-bill-number-check');

Route::get('/bill-check-list', [TravelAllowanceBillController::class, 'billCheckList'])->name('travelAllowanceBill.bill-check-list');
Route::get('/bill-check-modal', [TravelAllowanceBillController::class, 'billCheckModal'])->name('travelAllowanceBill.bill-check-modal');
Route::get('/bill-check-action', [TravelAllowanceBillController::class, 'billCheckAction'])->name('travelAllowanceBill.bill-check-action');

Route::get('/check-payment-list', [TravelAllowanceBillController::class, 'checkPaymentList'])->name('travelAllowanceBill.check-payment-list');
Route::get('/check-payment-modal', [TravelAllowanceBillController::class, 'checkPaymentModal'])->name('travelAllowanceBill.check-payment-modal');
Route::get('/check-payment-action', [TravelAllowanceBillController::class, 'checkPaymentAction'])->name('travelAllowanceBill.check-payment-action');

Route::get('/all-bill-list', [TravelAllowanceBillController::class, 'allBillList'])->name('travelAllowanceBill.all-bill-list');
Route::get('/travel-allow-pdf-one/{id}', [TravelAllowanceBillController::class, 'travelAllowPdfOne'])->name('travelAllowanceBill.travel-allow-pdf-one');

// Route For Search
Route::get('/search-by-status', [TravelAllowanceBillController::class, 'searchByStatus'])->name('travelAllowanceBill.search-by-status');
Route::get('/search-all', [TravelAllowanceBillController::class, 'searchAll'])->name('travelAllowanceBill.search-all');
Route::get('/search-by-name', [TravelAllowanceBillController::class, 'searchByName'])->name('travelAllowanceBill.search-by-name');
Route::get('/search-by-selection-area', [TravelAllowanceBillController::class, 'searchBySelectionArea'])->name('travelAllowanceBill.search-by-selection-area');

Route::get('/search-option', [TravelAllowanceBillController::class, 'searchOption'])->name('travelAllowanceBill.search-option');
