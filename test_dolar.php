<?php
require_once "controladores/contable.controlador.php";

$resultadoDolar = null;
$error = null;

// Procesar el formulario
if(isset($_POST['calcularDolar'])){
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];
    
    // Formatear el periodo (YYYY-MM-01)
    $periodo = sprintf("%s-%s-01", $anio, $mes);
    
    try {
        $resultadoDolar = ControladorContable::ctrCalcularDolar($periodo);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Calcular Dólar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }
        
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
            text-align: center;
        }
        
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            color: #555;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            color: #333;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        select:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
        }
        
        select:hover {
            border-color: #667eea;
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: 10px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .resultado {
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            text-align: center;
            animation: slideIn 0.5s ease;
        }
        
        .resultado-label {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .resultado-valor {
            color: white;
            font-size: 36px;
            font-weight: bold;
        }
        
        .resultado-detalle {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
            margin-top: 10px;
        }
        
        .error {
            margin-top: 30px;
            padding: 20px;
            background: #ff4757;
            border-radius: 10px;
            color: white;
            text-align: center;
            animation: slideIn 0.5s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            font-size: 13px;
            color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔄 Test Calcular Dólar</h1>
        <p class="subtitle">Función: ctrCalcularDolar()</p>
        
        <div class="info-box">
            <strong>ℹ️ Información:</strong><br>
            Esta función calcula el promedio del dólar CL (Rava) para el periodo seleccionado.
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="mes">Mes:</label>
                <select name="mes" id="mes" required>
                    <option value="">-- Seleccione un mes --</option>
                    <option value="01" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '01') ? 'selected' : ''; ?>>Enero</option>
                    <option value="02" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '02') ? 'selected' : ''; ?>>Febrero</option>
                    <option value="03" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '03') ? 'selected' : ''; ?>>Marzo</option>
                    <option value="04" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '04') ? 'selected' : ''; ?>>Abril</option>
                    <option value="05" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '05') ? 'selected' : ''; ?>>Mayo</option>
                    <option value="06" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '06') ? 'selected' : ''; ?>>Junio</option>
                    <option value="07" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '07') ? 'selected' : ''; ?>>Julio</option>
                    <option value="08" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '08') ? 'selected' : ''; ?>>Agosto</option>
                    <option value="09" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '09') ? 'selected' : ''; ?>>Septiembre</option>
                    <option value="10" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '10') ? 'selected' : ''; ?>>Octubre</option>
                    <option value="11" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '11') ? 'selected' : ''; ?>>Noviembre</option>
                    <option value="12" <?php echo (isset($_POST['mes']) && $_POST['mes'] == '12') ? 'selected' : ''; ?>>Diciembre</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="anio">Año:</label>
                <select name="anio" id="anio" required>
                    <option value="">-- Seleccione un año --</option>
                    <?php
                    $anioActual = date('Y');
                    for($i = $anioActual; $i >= 2020; $i--){
                        $selected = (isset($_POST['anio']) && $_POST['anio'] == $i) ? 'selected' : '';
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>
            
            <button type="submit" name="calcularDolar" class="btn">
                💱 Calcular Promedio Dólar
            </button>
        </form>
        
        <?php if($resultadoDolar !== null): ?>
            <div class="resultado">
                <div class="resultado-label">Promedio Dólar MEP</div>
                <div class="resultado-valor">
                    $<?php echo number_format($resultadoDolar, 2, ',', '.'); ?>
                </div>
                <div class="resultado-detalle">
                    Periodo: <?php 
                        $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                        echo $meses[intval($_POST['mes'])] . ' ' . $_POST['anio']; 
                    ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if($error !== null): ?>
            <div class="error">
                <strong>❌ Error:</strong><br>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
