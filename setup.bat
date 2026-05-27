@echo off
REM Script para construir y probar el admin panel

cd /d c:\xampp\htdocs\cup-ficct-uagrm

echo.
echo ==========================================
echo   FICCT CUP - ADMIN PANEL SETUP
echo ==========================================
echo.

echo [1/5] Compilando CSS y JS...
call npm run build

if %ERRORLEVEL% NEQ 0 (
    echo ERROR en la compilacion
    pause
    exit /b 1
)

echo [2/5] Limpiando cache...
call php artisan cache:clear
call php artisan config:clear
call php artisan view:clear

echo [3/5] Configurando base de datos...
call php artisan migrate:fresh --seed 2>nul

echo [4/5] Generando rutas...
call php artisan route:cache

echo.
echo ✅ SETUP COMPLETADO
echo.
echo ACCEDE A:
echo   - Dashboard: http://localhost/cup-ficct-uagrm/admin/dashboard
echo   - Materias:  http://localhost/cup-ficct-uagrm/admin/materias
echo   - Grupos:    http://localhost/cup-ficct-uagrm/admin/grupos
echo   - Docentes:  http://localhost/cup-ficct-uagrm/admin/docentes
echo.
echo Usuario admin: admin@ficct.edu.bo / password
echo.

pause
