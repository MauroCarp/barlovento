<div class="row">
  <div class="col-lg-5 col-md-6">
    <div class="box box-default">
      <div class="box-header with-border"><h3 class="box-title">MERCADO EXTERNO</h3></div>
      <div class="box-body no-padding">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" style="margin:0;">
            <thead>
              <tr class="bg-gray">
                <th style="width:25%">Mes</th>
                <th class="text-right" style="background:#ffd1dc;">Demanda</th>
                <th class="text-right" style="background:#ffe6ff;">Oferta NT</th>
                <th class="text-right" style="background:#ff66cc; color:#fff;">Balance</th>
              </tr>
            </thead>
            <tbody id="tb-ext"></tbody>
            <tfoot>
              <tr>
                <th class="text-right">TOTAL</th>
                <th></th>
                <th class="text-right" id="tot-oferta-ext"></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-5 col-md-6">
    <div class="box box-default">
      <div class="box-header with-border"><h3 class="box-title">MERCADO INTERNO</h3></div>
      <div class="box-body no-padding">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" style="margin:0;">
            <thead>
              <tr class="bg-gray">
                <th style="width:25%">Mes</th>
                <th class="text-right" style="background:#cfe2f3;">Demanda</th>
                <th class="text-right" style="background:#e8f0d6;">Oferta Total</th>
                <th class="text-right" style="background:#9fc5e8;">Balance</th>
              </tr>
            </thead>
            <tbody id="tb-int"></tbody>
            <tfoot>
              <tr>
                <th class="text-right">TOTAL</th>
                <th></th>
                <th class="text-right" id="tot-oferta-int"></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-2 col-md-12">
    <div class="box box-default">
      <div class="box-header with-border"><h3 class="box-title" id="titulo-balance-global">Balance Global</h3></div>
      <div class="box-body no-padding">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" style="margin:0;">
            <thead>
              <tr class="bg-gray">
                <th style="width:50%">Mes</th>
                <th class="text-right">Balance</th>
              </tr>
            </thead>
            <tbody id="tb-global"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function(){
  function fmt(n){
    try{ return Number(n||0).toLocaleString('es-AR'); }catch(e){ return n; }
  }
  function acumulado(dem, ofe){
    var out=[], acc=0;
    for(var i=0;i<dem.length;i++){
      acc += (Number(ofe[i]||0) - Number(dem[i]||0));
      out.push(acc);
    }
    return out;
  }
  function sum(arr){ return (arr||[]).reduce((a,b)=>a+Number(b||0),0); }

  fetch('ajax/gordosPrincipal.ajax.php?accion=data')
    .then(r=>r.ok?r.json():Promise.reject(r.status))
    .then(function(data){
      var meses = data.meses||[];
      var ext = data.externo||{demanda:[], oferta:[]};
      var inte = data.interno||{demanda:[], oferta:[]};
      var balExt = acumulado(ext.demanda, ext.oferta);
      var balInt = acumulado(inte.demanda, inte.oferta);
      var tbExt = document.getElementById('tb-ext');
      var tbInt = document.getElementById('tb-int');
      var tbGlob = document.getElementById('tb-global');
      tbExt.innerHTML = '';
      tbInt.innerHTML = '';
      tbGlob.innerHTML = '';

      for(var i=0;i<meses.length;i++){
        var tr1 = document.createElement('tr');
        tr1.innerHTML = '<td>'+meses[i]+'</td>'+
                        '<td class="text-right">'+fmt(ext.demanda[i])+'</td>'+
                        '<td class="text-right">'+fmt(ext.oferta[i])+'</td>'+
                        '<td class="text-right">'+fmt(balExt[i])+'</td>';
        tbExt.appendChild(tr1);

        var tr2 = document.createElement('tr');
        tr2.innerHTML = '<td>'+meses[i]+'</td>'+
                        '<td class="text-right">'+fmt(inte.demanda[i])+'</td>'+
                        '<td class="text-right">'+fmt(inte.oferta[i])+'</td>'+
                        '<td class="text-right">'+fmt(balInt[i])+'</td>';
        tbInt.appendChild(tr2);

        var tr3 = document.createElement('tr');
        var balGlob = Number(balExt[i]||0)+Number(balInt[i]||0);
        tr3.innerHTML = '<td>'+meses[i]+'</td>'+
                        '<td class="text-right">'+fmt(balGlob)+'</td>';
        tbGlob.appendChild(tr3);
      }

      document.getElementById('tot-oferta-ext').textContent = fmt(sum(ext.oferta));
      document.getElementById('tot-oferta-int').textContent = fmt(sum(inte.oferta));

      // Título con fecha
      if(data.fecha){
        var p = data.fecha.split('-');
        var fecha = (p.length===3)? [p[2],p[1],p[0]].join('/') : data.fecha;
        var t = document.getElementById('titulo-balance-global');
        if(t) t.textContent = fecha + ' - Balance Global';
      }
    })
    .catch(function(){ /* silencioso */ });
})();
</script>
