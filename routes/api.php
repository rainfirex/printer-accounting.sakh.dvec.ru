<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/device')->group(function () {

    Route::get('gets/{page}', 'C_DataPrinter@gets');

    Route::post('add', 'C_DataPrinter@add');

    Route::put('edit/{id}', 'C_DataPrinter@edit');

    Route::delete('remove/{id}', 'C_DataPrinter@remove');

    Route::get('find/{text}/column/{column}', 'C_DataPrinter@find');

    Route::get('export-xls', 'C_DataPrinter@exportXLS');
});

Route::prefix('/auth')->group(function () {

    Route::post('/login', 'ControllerAuth@login');

    Route::post('/logout', 'ControllerAuth@logout');

});

Route::prefix('/log')->group(function () {

    Route::get('count-page', 'C_DataLog@getCountPage');

    Route::get('limit-gets/{page}', 'C_DataLog@gets');

    Route::get('find/text/{text}/type/{type}', 'C_DataLog@find');

    Route::get('count-log', 'C_DataLog@count');
});

Route::prefix('/event')->group(function() {

    Route::get('gets', 'C_DataActionEvent@gets');

});
