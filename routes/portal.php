<?php

use Illuminate\Support\Facades\Route;

/**
 * 'portal' middleware and prefix applied to all routes
 *
 * @see \App\Providers\Route::mapPortalRoutes
 * @see \modules\OfflinePayments\Routes\portal.php for module example
 */
Route::group(['as' => 'portal.'], function () {
    Route::get('invoices/{invoice}/print', 'Portal\Invoices@printInvoice')->name('invoices.print');
    Route::get('invoices/{invoice}/pdf', 'Portal\Invoices@pdfInvoice')->name('invoices.pdf');
    Route::get('invoices/{invoice}/finish', 'Portal\Invoices@finish')->name('invoices.finish');
    Route::resource('invoices', 'Portal\Invoices');

    Route::get('payments/currencies', 'Portal\Payments@currencies')->name('payment.currencies');
    Route::get('payments/{payment}/print', 'Portal\Payments@printPayment')->name('payments.print');
    Route::get('payments/{payment}/pdf', 'Portal\Payments@pdfPayment')->name('payments.pdf');
    Route::resource('payments', 'Portal\Payments');

    Route::get('profile/read-invoices', 'Portal\Profile@readOverdueInvoices')->name('invoices.read');
    Route::resource('profile', 'Portal\Profile', ['middleware' => ['dropzone']]);

    Route::get('logout', 'Auth\Login@destroy')->name('logout');
});
