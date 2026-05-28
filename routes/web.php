<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MateriaController;
use App\Http\Controllers\Admin\GrupoController;
use App\Http\Controllers\Admin\DocenteController;
use App\Http\Controllers\Admin\CarreraController;
use App\Http\Controllers\Admin\RequisitoController;
use App\Http\Controllers\Admin\EstudianteController as AdminEstudianteController;
use App\Http\Controllers\Admin\InscripcionController;
use App\Http\Controllers\Admin\CalificacionController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;

// ============================================
// PÁGINA PRINCIPAL
// ============================================
Route::get('/', function () {
    return view('welcome');
});

// ============================================
// REDIRECCIÓN DASHBOARD SEGÚN ROL
// ============================================
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect()->route('login');
    }
    
    return match($user->role) {
        'admin'     => redirect()->route('admin.dashboard'),
        'docente'   => redirect()->route('docente.dashboard'),
        'estudiante'=> redirect()->route('estudiante.dashboard'),
        default     => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================
// PERFIL DE USUARIO
// ============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// PANEL ADMINISTRADOR
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // ──────────────────────────────────────
    // DASHBOARD
    // ──────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ──────────────────────────────────────
    // MATERIAS
    // ──────────────────────────────────────
    Route::resource('materias', MateriaController::class);
    
    // ──────────────────────────────────────
    // GRUPOS (ruta fija ANTES del resource)
    // ──────────────────────────────────────
    Route::get('/grupos/calculo', [GrupoController::class, 'calculo'])->name('grupos.calculo');
    Route::resource('grupos', GrupoController::class);
    
    // ──────────────────────────────────────
    // CARRERAS
    // ──────────────────────────────────────
    Route::resource('carreras', CarreraController::class);
    
    // ──────────────────────────────────────
    // REQUISITOS
    // ──────────────────────────────────────
    Route::resource('requisitos', RequisitoController::class);
    
    // ──────────────────────────────────────
    // DOCENTES (rutas fijas primero)
    // ──────────────────────────────────────
    Route::get('/docentes/postulantes', [DocenteController::class, 'postulantes'])->name('docentes.postulantes');
    Route::get('/docentes/create', [DocenteController::class, 'create'])->name('docentes.create');
    Route::post('/docentes', [DocenteController::class, 'store'])->name('docentes.store');
    Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
    // Rutas con parámetro
    Route::get('/docentes/{docente}', [DocenteController::class, 'show'])->name('docentes.show');
    Route::get('/docentes/{docente}/edit', [DocenteController::class, 'edit'])->name('docentes.edit');
    Route::put('/docentes/{docente}', [DocenteController::class, 'update'])->name('docentes.update');
    Route::delete('/docentes/{docente}', [DocenteController::class, 'destroy'])->name('docentes.destroy');
    Route::post('/docentes/{docente}/requisitos', [DocenteController::class, 'storeRequisito'])->name('docentes.storeRequisito');
    Route::patch('/docentes/{docente}/requisitos/{docenteRequisito}', [DocenteController::class, 'toggleRequisito'])->name('docentes.toggleRequisito');
    Route::patch('/docentes/{docente}/estado-postulacion', [DocenteController::class, 'updateEstadoPostulacion'])->name('docentes.updateEstadoPostulacion');
    
    // ──────────────────────────────────────
    // ESTUDIANTES (rutas fijas primero)
    // ──────────────────────────────────────
        // Dentro del grupo admin, sección ESTUDIANTES:
    Route::get('/estudiantes/postulantes', [AdminEstudianteController::class, 'postulantes'])->name('estudiantes.postulantes');
  
    Route::get('/estudiantes', [AdminEstudianteController::class, 'index'])->name('estudiantes.index');
    Route::get('/estudiantes/create', [AdminEstudianteController::class, 'create'])->name('estudiantes.create');
    Route::post('/estudiantes', [AdminEstudianteController::class, 'store'])->name('estudiantes.store');
    // Rutas con parámetro
    Route::get('/estudiantes/{estudiante}', [AdminEstudianteController::class, 'show'])->name('estudiantes.show');
    Route::get('/estudiantes/{estudiante}/edit', [AdminEstudianteController::class, 'edit'])->name('estudiantes.edit');
    Route::put('/estudiantes/{estudiante}', [AdminEstudianteController::class, 'update'])->name('estudiantes.update');
    Route::patch('/estudiantes/{estudiante}/requisitos', [AdminEstudianteController::class, 'updateRequisitos'])->name('estudiantes.updateRequisitos');
    Route::patch('/estudiantes/{estudiante}/aprobar-requisitos', [AdminEstudianteController::class, 'aprobarRequisitos'])->name('estudiantes.aprobarRequisitos');
    Route::patch('/estudiantes/{estudiante}/confirmar-pago', [AdminEstudianteController::class, 'confirmarPago'])->name('estudiantes.confirmarPago');
  // ──────────────────────────────────────
    // INSCRIPCIONES
    // ──────────────────────────────────────
    Route::get('/inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.index');
    Route::post('/inscripciones', [InscripcionController::class, 'store'])->name('inscripciones.store');
    Route::patch('/inscripciones/{inscripcion}/estado', [InscripcionController::class, 'updateEstado'])->name('inscripciones.updateEstado');
    
    // ──────────────────────────────────────
    // CALIFICACIONES
    // ──────────────────────────────────────
    Route::resource('calificaciones', CalificacionController::class);
    
    // ──────────────────────────────────────
    // REPORTES
    // ──────────────────────────────────────
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/postulantes', [ReporteController::class, 'postulantes'])->name('postulantes');
        Route::get('/aprobados', [ReporteController::class, 'aprobados'])->name('aprobados');
        Route::get('/reprobados', [ReporteController::class, 'reprobados'])->name('reprobados');
        Route::get('/promedios', [ReporteController::class, 'promedios'])->name('promedios');
        Route::get('/grupos', [ReporteController::class, 'grupos'])->name('grupos');
        Route::get('/estadisticas-materias', [ReporteController::class, 'estadisticasMaterias'])->name('estadisticas_materias');
        Route::get('/docentes-grupos', [ReporteController::class, 'docentesGrupos'])->name('docentes_grupos');
        Route::get('/grupos-top', [ReporteController::class, 'gruposTop'])->name('grupos_top');
        // Exportaciones PDF
    Route::get('/postulantes/pdf', [ReporteController::class, 'exportarPostulantesPDF'])->name('postulantes.pdf');
    Route::get('/aprobados/pdf', [ReporteController::class, 'exportarAprobadosPDF'])->name('aprobados.pdf');
    Route::get('/estadisticas-materias/pdf', [ReporteController::class, 'exportarEstadisticasPDF'])->name('estadisticas_materias.pdf');
    Route::get('/grupos/pdf', [ReporteController::class, 'exportarGruposPDF'])->name('grupos.pdf');


        });
});

// ============================================
// PANEL DOCENTE
// ============================================
Route::middleware(['auth', 'role:docente'])->prefix('docente')->name('docente.')->group(function () {
    Route::get('/dashboard', function () {
        return view('docente.dashboard');
    })->name('dashboard');
});

// ============================================
// PANEL ESTUDIANTE
// ============================================
Route::middleware(['auth', 'role:estudiante'])->prefix('estudiante')->name('estudiante.')->group(function () {
    Route::get('/dashboard', [EstudianteController::class, 'dashboard'])->name('dashboard');
    Route::get('/horario', [EstudianteController::class, 'horario'])->name('horario');
    Route::get('/calificaciones', [EstudianteController::class, 'calificaciones'])->name('calificaciones');
    Route::get('/docentes', [EstudianteController::class, 'docentes'])->name('docentes');
    Route::get('/cup', [EstudianteController::class, 'cup'])->name('cup');
});

// ============================================
// AUTENTICACIÓN (Breeze)
// ============================================
require __DIR__.'/auth.php';