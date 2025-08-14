<?php

session_start();

?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Reportes Feedlot</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="vistas/img/plantilla/icono-negro.png">

   <!--=====================================
  PLUGINS DE CSS
  ======================================-->

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
 
  <!-- ESTILOS PERSONALES -->
  <link rel="stylesheet" href="vistas/dist/css/style.css">

  <!-- Icomoon -->
  <link rel="stylesheet" href="vistas/bower_components/icomoon/css/icomoon.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">

   <!-- Daterange picker -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- Morris chart -->
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">

  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->

  <!-- jQuery 3 -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
  
  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- FastClick -->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  
  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>

  <!-- SweetAlert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
   <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

  <!-- iCheck 1.0.1 -->
  <script src="vistas/plugins/iCheck/icheck.min.js"></script>

  <!-- InputMask -->
  <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>

  <!-- jQuery Number -->
  <script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>

  <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>

  <!-- ChartJS http://www.chartjs.org/-->
  <script src="vistas/bower_components/chart.js/Chart.js"></script>

  
  <!-- ChartJS LABELS https://github.com/emn178/chartjs-plugin-labels/-->
  <script src="vistas/bower_components/chart/Chart.bundle.js"></script>

  <script src="vistas/bower_components/chart/utils.js"></script>

  <script src="vistas/bower_components/chart/chartjs-plugin-labels.min.js"></script>

  <!-- SELECT2 SELECTOR https://select2.org/getting-started/installation -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- PWA -->

  <link rel="manifest" href="manifest.json">

  <!-- Android -->
  <meta name="theme-color" content="#3498db">

  <!-- IOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">

  <link rel="apple-touch-icon" href="vistas/img/plantilla/icons/icon-192x192.png">
  <link rel="apple-touch-icon" sizes="152x152" href="vistas/img/plantilla/icons/icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="vistas/img/plantilla/icons/icon-192x192.png">
  <link rel="apple-touch-icon" sizes="167x167" href="vistas/img/plantilla/icons/icon-152x152.png">

  <!-- iPhone X (1125px x 2436px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" href="vistas/img/plantilla/icons-ios/apple-launch-1125x2436.png">
  <!-- iPhone 8, 7, 6s, 6 (750px x 1334px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" href="vistas/img/plantilla/icons-ios/apple-launch-750x1334.png">
  <!-- iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus (1242px x 2208px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" href="vistas/img/plantilla/icons-ios/apple-launch-1242x2208.png">
  <!-- iPhone 5 (640px x 1136px) -->
  <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="vistas/img/plantilla/icons-ios/apple-launch-640x1136.png">

  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <meta name="apple-mobile-web-app-title" content="Barlovento">

  <style>
  
    @media all {
      div.saltopagina{
        display: none;
        }
    }
    
    @media print{
      div.saltopagina{
          display:block;
          page-break-before:always;
      }
    }

  </style>
</head>

<!--=====================================
CUERPO DOCUMENTO
======================================-->

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
 
  <?php
  if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){

    echo '<div class="wrapper">';

    /*=============================================
    CABEZOTE
    =============================================*/

    include "modulos/cabezote.php";

    /*=============================================
    MENU
    =============================================*/

    include "modulos/menu.php";

    /*=============================================
    CONTENIDO
    =============================================*/
    
    if($_SESSION["perfil"] == 'Ganadero'){

      if(isset($_GET["ruta"])){

        if($_GET["ruta"] == "inicio" ||
          $_GET["ruta"] == "datos" ||
          $_GET["ruta"] == "datos-compras" ||
          $_GET["ruta"] == "datos-muertes" ||
          $_GET["ruta"] == "panelControl" ||
          $_GET["ruta"] == "resumenConversion" ||
          $_GET["ruta"] == "piri" ||
          $_GET["ruta"] == "diasPastoreo" ||
          $_GET["ruta"] == "usuarios" ||
          $_GET["ruta"] == "archivosCarga" ||
          $_GET["ruta"] == "generar-reportes" ||
          $_GET["ruta"] == "cargar-datos-compras" ||
          $_GET["ruta"] == "reportes-compras" ||
          $_GET["ruta"] == "reportes-compras.imprimir" ||
          $_GET["ruta"] == "reportes-muertes" ||
          $_GET["ruta"] == "reportes-muertes.imprimir" ||
          $_GET["ruta"] == "reportes-muertesRango.imprimir" ||
          $_GET["ruta"] == "cargar-datos" ||
          $_GET["ruta"] == "cargar-datos-ventas" ||
          $_GET["ruta"] == "cargar-datos-muertes" ||
          $_GET["ruta"] == "reportes" ||
          $_GET["ruta"] == "reportes.imprimir" ||
          $_GET["ruta"] == "reportes/reportesFiltrados" ||
          $_GET["ruta"] == "reportes/reportesFiltrados.imprimir" ||
          $_GET["ruta"] == "reportes/reportesFiltradosMuertes" ||
          $_GET["ruta"] == "reportesRango" ||
          $_GET["ruta"] == "reportesRango.imprimir" ||
          $_GET["ruta"] == "reportes/reportes-muertesRango" ||
          $_GET["ruta"] == "reportes/reportesFiltradosMuertes.imprimir" ||
          $_GET["ruta"] == "reportes/grafico-general" ||
          $_GET["ruta"] == "salir"){

          include "modulos/".$_GET["ruta"].".php";

        }else{

          include "modulos/404.php";

        }

      }else{

        if($_SESSION['mobile']){
          include "modulos/diasPastoreo.php";
          
        } else { 
          
          include "modulos/inicio.php";

        }


      }

    }

    if($_SESSION["perfil"] == 'Agro'){

      if(isset($_GET["ruta"])){
        if($_GET["ruta"] == "agro/agro" ||
        $_GET["ruta"] == "agro" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "salir"){
          
          include "modulos/".$_GET["ruta"].".php";
          
        }else{
          
          include "modulos/404.php";
          
        }
        
      }else{
        
        include "modulos/agro/agro.php";

      }

    }

    if($_SESSION["perfil"] == 'Contable'){

      if(isset($_GET["ruta"])){
        if($_GET["ruta"] == "contable/contable" ||
        $_GET["ruta"] == "contable/archivos" ||
        $_GET["ruta"] == "archivosContable" ||
        $_GET["ruta"] == "contable" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "salir"){
          
          include "modulos/".$_GET["ruta"].".php";
          
        }else{
          
          include "modulos/404.php";
          
        }
        
      }else{
        
        include "modulos/contable/contable.php";

      }

    }

    if($_SESSION["perfil"] == 'Trazabilidad'){

      if(isset($_GET["ruta"])){
        if($_GET["ruta"] == "trazabilidad" ||
        $_GET["ruta"] == "trazabilidad/index" ||
        $_GET["ruta"] == "trazabilidad/tablaAnimales" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "salir"){
          
          include "modulos/".$_GET["ruta"].".php";
          
        }else{
          
          include "modulos/404.php";
          
        }
        
      }else{
        
        include "modulos/trazabilidad/index.php";

      }

    }

    if($_SESSION["perfil"] == 'Pastoreo'){

      if(isset($_GET["ruta"])){
        if($_GET["ruta"] == "pastoreo" ||
        $_GET["ruta"] == "pastoreo/index" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "salir"){
          
          include "modulos/".$_GET["ruta"].".php";
          
        }else{
          
          include "modulos/404.php";
          
        }
        
      }else{
        
        include "modulos/pastoreo/index.php";

      }

    }

    /*=============================================
    FOOTER
    =============================================*/

    include "modulos/footer.php";

    echo '</div>';
    
  }else{

    include "modulos/login.php";

  }
  ?>

  
<!-- EN AMBOS -->
<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/reportes.js"></script>
<script src="vistas/js/archivos.js"></script>

<?php
if($_SESSION["perfil"] == 'Administrador Contable' OR $_SESSION["perfil"] == 'Contable'){
?>

  <script src="vistas/js/contable/contable.js"></script>

<?php

}

// AGRO Y CONTABLE
$arValid = array('Agro','Administrador Agro','Administrador Contable','Contable','Pastoreo','Administrador Contable');
if(in_array($_SESSION["perfil"],$arValid)){
?>

<script src="vistas/js/agro/agro.js"></script>

<?php
}

// SOLO EN AGRO

if($_SESSION["perfil"] == 'Agro' OR $_SESSION["perfil"] == 'Administrador Agro'){
?>

<script src="vistas/js/agro/planificacion.js"></script>
<script src="vistas/js/agro/ejecucion.js"></script>

<?php
}

// SOLO EN GANADERO
if($_SESSION["perfil"] == 'Ganadero' OR $_SESSION["perfil"] == 'Administrador Ganadero'){
  ?>
<script src="vistas/js/compras.js"></script>
<script src="vistas/js/muertes.js"></script>
<script src="vistas/js/ventas.js"></script>
<script src="vistas/js/panelControl.js"></script>
<script src="vistas/js/reportesCompras.js"></script>
<script src="vistas/js/reportesMuertes.js"></script>
<script src="vistas/js/conversion.js"></script>
<script src="vistas/js/piri.js"></script>

<?php
}

if($_SESSION['perfil'] == 'Trazabilidad'){ ?>

  <script src="vistas/js/trazabilidad/trazabilidad.js"></script>
  
<?php

}

if($_SESSION['perfil'] == 'Pastoreo'){ ?>

  <script src="vistas/js/pastoreo/pastoreo.js"></script>

<?php

}

?>



</body>
</html>
