<?php

?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>CONTROL PASTORIL</h1>
  </section>

  <section class="content">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-panel-control" data-toggle="tab">Control Estrategico</a></li>
        <li><a href="#tab-produccion-sanidad" data-toggle="tab">Producción y Sanidad</a></li>
        <li><a href="#tab-analisis-economico" data-toggle="tab">Análisis Económico / Financiero</a></li>
      </ul>
      <div class="tab-content">

        <div class="tab-pane active" id="tab-panel-control">
          <?php include __DIR__ . '/partials/controlPastoril-panelControl.php'; ?>
        </div>

        <div class="tab-pane" id="tab-produccion-sanidad">
          <?php include __DIR__ . '/partials/controlPastoril-produccionSanidad.php'; ?>
        </div>

        <div class="tab-pane" id="tab-analisis-economico">
          <?php include __DIR__ . '/partials/controlPastoril-analisisEconomico.php'; ?>
        </div>

      </div>
    </div>
  </section>
</div>

<script>

</script>

<?php

?>