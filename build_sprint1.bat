@echo off
cd /d C:\xampp\htdocs\cup-ficct-uagrm
echo ================================
echo   CUP FICCT - Build Assets
echo ================================
echo.
echo Limpiando cache...
php artisan view:clear
php artisan cache:clear
php artisan config:clear
echo.
echo Compilando assets...
call npm run build
echo.
echo ================================
echo   Build completado!
echo ================================
pause