# Scripts de Consola para Producción

Esta carpeta contiene scripts para ejecutar la función `ctrGenerarObjetoProduccion()` desde la línea de comandos.

## Archivos Creados

### 1. `ejecutar_produccion_consola.php`
Script principal con salida detallada y manejo de errores.

**Uso básico:**
```bash
php ejecutar_produccion_consola.php
```

**Uso con campaña específica:**
```bash
php ejecutar_produccion_consola.php "2025/2026"
```

**Ver resultado completo:**
```bash
php ejecutar_produccion_consola.php "2026/2027" --mostrar-completo
```

### 2. `ejecutar_produccion.bat` (Windows)
Script batch para facilitar la ejecución en Windows.

**Uso:**
```batch
ejecutar_produccion.bat
ejecutar_produccion.bat "2025/2026"
ejecutar_produccion.bat "2026/2027" --mostrar-completo
```

### 3. `produccion_json.php`
Script simple que devuelve solo el resultado en formato JSON.

**Uso:**
```bash
php produccion_json.php
php produccion_json.php "2025/2026"
```

**Redireccionar a archivo:**
```bash
php produccion_json.php "2026/2027" > resultado.json
```

## Ejemplos de Uso

### Ejecución básica
```bash
# Usar campaña por defecto (2026/2027)
php ejecutar_produccion_consola.php

# Especificar campaña
php ejecutar_produccion_consola.php "2025/2026"
```

### Ver resultado completo
```bash
php ejecutar_produccion_consola.php "2026/2027" --mostrar-completo
```

### Obtener solo JSON (para integraciones)
```bash
php produccion_json.php "2026/2027" > produccion_2026.json
```

### En Windows (usando batch)
```batch
# Doble clic en ejecutar_produccion.bat
# O desde CMD:
ejecutar_produccion.bat "2026/2027"
```

## Requisitos

- PHP CLI instalado y accesible desde la línea de comandos
- Acceso a la base de datos configurado en `modelos/conexion.php`
- Los archivos del modelo y controlador deben estar disponibles

## Solución de Problemas

### Error: "Este script debe ejecutarse desde la línea de comandos"
- Ejecutar desde CMD/Terminal, no desde navegador web

### Error: "No se encontró el archivo..."
- Ejecutar desde la carpeta `barloventoOfi`
- Verificar que los archivos del modelo y controlador existan

### Error de base de datos
- Verificar la configuración en `modelos/conexion.php`
- Verificar que el servidor de base de datos esté activo
- Verificar que la campaña existe en la base de datos

### Error: "php no se reconoce como comando"
- Instalar PHP CLI o agregarlo al PATH del sistema
- En Windows: usar XAMPP/WAMP y agregar php.exe al PATH

## Notas

- El script usa la campaña "2026/2027" como valor por defecto
- Los errores se muestran con detalles para facilitar el debugging
- El resultado se puede exportar a JSON para integraciones
- Compatible con Windows (batch) y Linux/Mac (bash)