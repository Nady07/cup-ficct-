<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminViewsExist
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Crear directorios si no existen
        $dirs = [
            resource_path('views/admin/grupos'),
            resource_path('views/admin/docentes'),
            resource_path('views/admin/carreras'),
            resource_path('views/admin/requisitos'),
        ];

        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
        }

        // Crear vistas si no existen
        $this->createViewIfNotExists('admin/grupos/index');
        $this->createViewIfNotExists('admin/grupos/create');
        $this->createViewIfNotExists('admin/grupos/edit');
        $this->createViewIfNotExists('admin/grupos/show');

        return $next($request);
    }

    private function createViewIfNotExists(string $view)
    {
        $path = resource_path("views/{$view}.blade.php");
        if (!file_exists($path)) {
            @touch($path);
        }
    }
}
