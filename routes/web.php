<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\RepuestoController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/repuestos', [RepuestoController::class, 'index'])->name('repuestos.index');
Route::get('/repuestos/create', [RepuestoController::class, 'create'])->name('repuestos.create');
Route::post('/repuestos/create', [RepuestoController::class, 'store'])->name('repuestos.store');
Route::get('/repuestos/{repuesto}/edit', [RepuestoController::class, 'edit'])->name('repuestos.edit');
Route::patch('/repuestos/{repuesto}/edit', [RepuestoController::class, 'update'])->name('repuestos.update');
Route::delete('/repuestos/{repuesto}', [RepuestoController::class, 'destroy'])->name('repuestos.destroy');
Route::get('/repuestos/{repuesto}', [RepuestoController::class,'show'])->name('repuestos.show');
Route::get('/repuestos/buscar', [RepuestoController::class, 'buscar'])->name('repuestos.buscar');
Route::get('repuestos/fetchCategoria2', 'RepuestoController@fetchCategoria2')->name('repuestos.fetchCategoria2');




