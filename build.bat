@echo off
REM Script para compilar assets con Vite

echo.
echo ====================================
echo   FICCT-CUP - Compilando Assets
echo ====================================
echo.

cd /d c:\xampp\htdocs\cup-ficct-uagrm

echo [1/2] Instalando dependencias (si es necesario)...
call npm install

echo.
echo [2/2] Compilando CSS y JS con Vite...
call npm run build

echo.
echo ====================================
echo   Compilacion completada!
echo ====================================
echo.
echo Los assets compilados estan en:
echo   c:\xampp\htdocs\cup-ficct-uagrm\public\build\
echo.
echo Para ver los cambios en tu navegador:
echo   1. Abre http://localhost/cup-ficct-uagrm
echo   2. Recarga la pagina (Ctrl+F5)
echo   3. Los estilos FICCT deberian ser visibles
echo.
pause
