<?php


Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin')->group(function () {

        // Sales Routes
        Route::prefix('sales')->group(function () {

            // Sales Vapulus Transactions Routes
            Route::get('/vapulus_transactions', 'Webkul\Vapulus\Http\Controllers\Admin\Sales\TransactionController@index')->defaults('_config', [
                'view' => 'vapulus::admin.sales.vapulus_transactions.index'
            ])->name('admin.sales.vapulus_transactions.index');

            Route::get('/vapulus_transactions/view/{id}', 'Webkul\Vapulus\Http\Controllers\Admin\Sales\TransactionController@view')->defaults('_config', [
                'view' => 'vapulus::admin.sales.vapulus_transactions.view'
            ])->name('admin.sales.vapulus_transactions.view');
            
        });
    });
});

Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {
    Route::prefix('checkout')->group(function () {

        Route::get('/redirect/vapulus', 'Webkul\Vapulus\Http\Controllers\VapulusController@redirect')->name('vapulus.payment.redirect');

        Route::get('/vapulus/charge', 'Webkul\Vapulus\Http\Controllers\VapulusController@createCharge')->name('vapulus.make.payment');

        Route::get('/cancel', 'Webkul\Vapulus\Http\Controllers\VapulusController@cancel')->name('vapulus.payment.cancel');
    });
});
