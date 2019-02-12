<?php


Route::group(['middleware' => ['auth'], 'namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::any('historic-search', 'BalanceController@serachHistoric')->name('historic.search');

    Route::get('historic', 'BalanceController@historic')->name('admin.historic');

    Route::post('confir-transfer', 'BalanceController@confirmTransfer')->name('transferencia.confirmacao');
    Route::post('tranferencia', 'BalanceController@tranferenciaStore')->name('transferencia.store');
    Route::get('transferencia', 'BalanceController@tranferencia')->name('balance.transferencia');

    Route::post('deposit', 'BalanceController@depositStore')->name('deposit.store');
    Route::get('sacar', 'BalanceController@sacar')->name('balance.sacar');

    Route::post('sacar', 'BalanceController@saqueStore')->name('saque.store');
    Route::get('deposit', 'BalanceController@deposit')->name('balance.deposit');

    Route::get('balance', 'BalanceController@index')->name('admin.balance');
    Route::get('/', 'AdminController@index')->name('admin.home');
});

//Route::get('/', 'Site\SiteController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'Site\SiteController@index')->name('home');

Route::get('/meu-perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');

Route::post('/update', 'Admin\UserController@profileUpdate')->name('profile.update')->middleware('auth');




Auth::routes();
