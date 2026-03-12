@echo off
REM Script batch para ejecutar el generador de objeto produccion
REM Uso: ejecutar_produccion.bat [campania]
REM Ejemplo: ejecutar_produccion.bat "2026/2027"

setlocal enabledelayedexpansion

REM Verificar que estamos en el directorio correcto
if not exist "ejecutar_produccion_consola.php" (
    echo Error: No se encontro el archivo ejecutar_produccion_consola.php
    echo Asegurese de estar en el directorio barloventoOfi
    pause
    exit /b 1
)

REM Establecer la campaña (usar argumento o valor por defecto)
set "CAMPANIA=%~1"
if "!CAMPANIA!"=="" set "CAMPANIA=2026/2027"

echo Ejecutando generacion de objeto produccion...
echo Campania: !CAMPANIA!
echo.

REM Ejecutar el script PHP
php ejecutar_produccion_consola.php "!CAMPANIA!" %2

REM Verificar el resultado
if %ERRORLEVEL%==0 (
    echo.
    echo *** EJECUCION COMPLETADA EXITOSAMENTE ***
) else (
    echo.
    echo *** ERROR EN LA EJECUCION ***
    echo Codigo de error: %ERRORLEVEL%
)

echo.
pause