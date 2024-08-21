<?php

use App\Http\Controllers\PrinterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para listar todas las impresoras
Route::get('/printers', [PrinterController::class, 'index'])->name('printers.index');

// Ruta para mostrar el formulario de creación de una nueva impresora
Route::get('/printers/create', [PrinterController::class, 'create'])->name('printers.create');

// Ruta para guardar una nueva impresora en la base de datos
Route::post('/printers', [PrinterController::class, 'store'])->name('printers.store');

// Ruta para eliminar una impresora específica
Route::delete('/printers/{id}', [PrinterController::class, 'destroy'])->name('printers.destroy');

// Ruta para actualizar los niveles de tóner de todas las impresoras
Route::post('/printers/updateTonerLevels', [PrinterController::class, 'updateTonerLevels'])->name('printers.updateTonerLevels');
