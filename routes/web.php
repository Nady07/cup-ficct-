<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MateriaController;
use App\Http\Controllers\Admin\GrupoController;
use App\Http\Controllers\Admin\DocenteController;
use App\Http\Controllers\Admin\CarreraController;
use App\Http\Controllers\Admin\RequisitoController;
use App\Http\Controllers\Admin\EstudianteController as AdminEstudianteController;
use App\Http\Controllers\Admin\InscripcionController;
use App\Http\Controllers\Admin\CalificacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Panel Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('materias', MateriaController::class);
    Route::resource('grupos', GrupoController::class);
    Route::resource('docentes', DocenteController::class);
    Route::resource('carreras', CarreraController::class);
    Route::resource('requisitos', RequisitoController::class);
    
    Route::get('/estudiantes', [AdminEstudianteController::class, 'index'])->name('estudiantes.index');
    Route::get('/estudiantes/{estudiante}', [AdminEstudianteController::class, 'show'])->name('estudiantes.show');
    
    Route::get('/inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.index');
    Route::patch('/inscripciones/{inscripcion}/estado', [InscripcionController::class, 'updateEstado'])->name('inscripciones.updateEstado');
    
    Route::get('/calificaciones', [CalificacionController::class, 'index'])->name('calificaciones.index');
    Route::post('/calificaciones', [CalificacionController::class, 'store'])->name('calificaciones.store');
    Route::put('/calificaciones/{calificacion}', [CalificacionController::class, 'update'])->name('calificaciones.update');
});

// Panel Estudiante
Route::middleware(['auth', 'role:student'])->prefix('estudiante')->name('estudiante.')->group(function () {
    Route::get('/dashboard', [EstudianteController::class, 'dashboard'])->name('dashboard');
    Route::get('/horario', [EstudianteController::class, 'horario'])->name('horario');
    Route::get('/materias', [EstudianteController::class, 'materias'])->name('materias');
    Route::get('/docentes', [EstudianteController::class, 'docentes'])->name('docentes');
    Route::get('/cup', [EstudianteController::class, 'cup'])->name('cup');
});

require __DIR__.'/auth.php';