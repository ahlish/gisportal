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

Route::get('/login', 'LoginController@login')->name('login');
Route::post('/check_login', 'LoginController@checkLogin')->name('login');
Route::post('/logout', 'LoginController@logout')->name('logout');

// Auth::routes();
// Route::get('/', 'PortalController@KebocoranPipa')->name('kebocoran_pipa');
Route::get('/kebocoran_pipa', 'PortalController@KebocoranPipa')->name('kebocoran_pipa');
Route::get('/pasang_baru', 'PortalController@PasangBaru')->name('pasang_baru');
Route::get('/point', 'PortalController@Point')->name('point');
Route::get('/line', 'PortalController@Line')->name('line');
Route::get('/polygon', 'PortalController@Polygon')->name('polygon');

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/pengaduan', 'GuestController@Pengaduan')->name('pengaduan');
Route::resource('pengaduan', 'PengaduanController', ['names' => ['index' => 'pengaduan', 'create' => 'pengaduan', 'show' => 'pengaduan', 'edit' => 'pengaduan']]);
Route::post('pengaduan/save', 'PengaduanController@store')->name('pengaduan');
Route::resource('pengaduan_v2', 'PengaduanV2Controller', ['names' => ['index' => 'pengaduan_v2', 'create' => 'pengaduan_v2', 'show' => 'pengaduan_v2', 'edit' => 'pengaduan_v2']]);
Route::post('pengaduan_v2/save', 'PengaduanV2Controller@store')->name('pengaduan');
Route::get('monitoring_pengaduan', 'PengaduanV2Controller@MonitoringPengaduan')->name('monitoring_pengaduan');

// MONITORING CATER
Route::resource('monitoring_cater', 'MonitoringCaterController', ['names' => ['index' => 'monitoring_cater', 'create' => 'monitoring_cater', 'show' => 'monitoring_cater', 'edit' => 'monitoring_cater']]);

// WEB SERVICE
Route::get('ajax_pelanggan', 'WebServices\CustomerServiceController@AjaxPelanggan');
Route::get('/service/pelanggan_detail/{id}', 'WebServices\CustomerServiceController@PelangganDetail');
Route::post('/service/get_cater', 'WebServices\MonitoringCaterServiceController@GetCater');