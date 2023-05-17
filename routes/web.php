<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerpustakaanController;

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

Route::get('/perpustakaans', [PerpustakaanController::class, 'index'])->name('index');
Route::post('/perpustakaans/tambah-data', [PerpustakaanController::class, 'store'])->name('store');
Route::get('/generate-token', [PerpustakaanController::class, 'createToken'])->name('createToken');
Route::get('/perpustakaans/show/trash', [PerpustakaanController::class, 'trash'])->name('trash');
Route::get('/perpustakaans/{id}', [PerpustakaanController::class, 'show'])->name('show');
Route::patch('/perpustakaans/update/{id}', [PerpustakaanController::class, 'update'])->name('update');
Route::delete('/perpustakaans/delete/{id}', [PerpustakaanController::class, 'destroy'])->name('destroy');
Route::get('/perpustakaans/trash/restore/{id}', [PerpustakaanController::class, 'restore'])->name('restore');
Route::get('/perpustakaans/trash/delete/permanent/{id}', [PerpustakaanController::class, 'permanentDelete'])->name('permanentDelete');