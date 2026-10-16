@echo off
chcp 65001 >nul
cd /d "%~dp0"
set LOG=%~dp0setup-log.txt
echo ===== Working folder: %CD%
echo ===== Log file: %LOG%
echo setup started %DATE% %TIME% > "%LOG%"

if not exist ".env" copy ".env.example" ".env" >nul
if not exist "bootstrap\cache" mkdir "bootstrap\cache"
if not exist "database\database.sqlite" type nul > "database\database.sqlite"

echo [1/4] composer install
call composer install --no-interaction >> "%LOG%" 2>&1
if errorlevel 1 goto :fail

echo [2/4] key:generate
findstr /b /c:"APP_KEY=base64" .env >nul || php artisan key:generate --force >> "%LOG%" 2>&1

echo [3/4] migrate --seed
php artisan migrate:fresh --seed --force >> "%LOG%" 2>&1
if errorlevel 1 goto :fail

echo [4/4] test
php artisan test >> "%LOG%" 2>&1
type "%LOG%"

echo.
echo ===== Server starting: open http://127.0.0.1:8000
echo ===== Login: warehouse@example.com / password
echo ===== Keep this window open. Ctrl+C to stop.
php artisan serve
pause
exit /b 0

:fail
type "%LOG%"
echo.
echo ***** Step failed. Details saved in setup-log.txt - tell Claude. *****
pause
exit /b 1
