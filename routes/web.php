<?php

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
    return view('welcome');
});

Route::get('/pengaduan', function () {
    return view('pengaduan');
});

Auth::routes();
// Route::get('/', 'PortalController@KebocoranPipa')->name('kebocoran_pipa');
Route::get('/kebocoran_pipa', 'PortalController@KebocoranPipa')->name('kebocoran_pipa');
Route::get('/pasang_baru', 'PortalController@PasangBaru')->name('pasang_baru');
Route::get('/point', 'PortalController@Point')->name('point');
Route::get('/line', 'PortalController@Line')->name('line');
Route::get('/polygon', 'PortalController@Polygon')->name('polygon');

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/pengaduan', 'GuestController@Pengaduan')->name('pengaduan');
Route::resource('pengaduan', 'PengaduanController', ['names' => ['index' => 'pengaduan', 'create' => 'pengaduan', 'show' => 'pengaduan', 'edit' => 'pengaduan']]);
// Route::post('pengaduan/save', 'PengaduanController@store')->name('pengaduan');
