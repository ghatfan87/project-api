<?php

use App\Http\Controllers\HospitalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hospital',[HospitalController::class,'index'])->name('index');
Route::get('/generate-token',[HospitalController::class,'createToken'])->name('token');
Route::post('/hospitals/tambah/data',[HospitalController::class,'store'])->name('tambah_data');
Route::get('/hospitals/{id}',[HospitalController::class,'show'])->name('hospital');
Route::patch('hospitals/{id}/update', [HospitalController::class, 'update'])->name('update');
Route::delete('hospitals/{id}/delete', [HospitalController::class,'destroy'])->name('delete');
Route::get('hospitals/delete/permanent/{id}',[HospitalController::class,'deletePermanent'])->name('permanent');
Route::get('hospitals/show/trash',[HospitalController::class,'onlyTrash'])->name('onlyTrash');
Route::get('hospitals/restore/{id}',[HospitalController::class,'restore'])->name('restore');































































































