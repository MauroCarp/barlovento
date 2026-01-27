<div class="row">
  <div class="col-lg-5 col-md-6">
    <div class="box box-default">
      <div class="box-header with-border"><h3 class="box-title">MERCADO EXTERNO</h3></div>
      <div class="box-body no-padding">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="gordosMercadoExterno" style="margin:0;">
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
          <table class="table table-bordered table-striped" id="gordosMercadoInterno" style="margin:0;">
            <thead>
              <tr class="bg-gray">
                <th style="width:25%">Mes</th>
                <th class="text-right" style="background:#cfe2f3;">Demanda</th>
                <th class="text-right" style="background:#e8f0d6;">Oferta Total</th>
                <th class="text-right balanceInterno" style="background:#9fc5e8;">Balance</th>
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
          <table class="table table-bordered table-striped" id="gordosBalanceGlobal" style="margin:0;">
            <thead>
              <tr class="bg-gray">
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

  $.ajax({
    url: 'ajax/gordosPrincipal.ajax.php',
    method: 'POST',
    data: { accion: 'data' },
    success:function(respuesta){

      let parsed;
      try { parsed = JSON.parse(respuesta); } catch(e) { parsed = []; }

      const rows = Array.isArray(parsed) ? parsed : (Array.isArray(parsed.data) ? parsed.data : []);

      const toNumber = (v) => {
        const n = Number((v ?? '').toString().replace(/\./g,'').replace(/,/g,'.'));
        return isNaN(n) ? 0 : n;
      };
      
      const fmt = (n) => Number(n).toLocaleString('es-AR', { minimumFractionDigits: 0, maximumFractionDigits: 2 });

      const externos = rows.filter(r => (r.tipo || '').toLowerCase() === 'mercado externo');
      const internos = rows.filter(r => (r.tipo || '').toLowerCase() === 'mercado interno');

      // Render helper
      
      const renderTable = (items, tbodySelector, totalSelector) => {
        let html = '';
        let totalOferta = 0;
        let balanceAnterior = 0;
        let tipo = (totalSelector === '#tot-oferta-int') ? 'Interno' : 'Externo';
        let idx = 0;
        items.forEach(r => {
          const mes = r.mes ?? '';
          const demanda = toNumber(r.demanda);
          const oferta = toNumber(r.oferta);

          const balance = (oferta + balanceAnterior) - demanda;
          
          balanceAnterior = balance

          totalOferta += oferta;

          html += `\n<tr>\n  <td>${mes}</td>\n  <td class="text-right">${fmt(demanda)}</td>\n  <td class="text-right">${fmt(oferta)}</td>\n  <td class="text-right balance${tipo}" data-idx="${idx}">${fmt(balance)}</td>\n</tr>`;
          idx++;
        });
        $(tbodySelector).html(html);
        if(totalSelector) $(totalSelector).text(fmt(totalOferta));
      };

      renderTable(externos, '#tb-ext', '#tot-oferta-ext');
      renderTable(internos, '#tb-int', '#tot-oferta-int');
      
      let globales = []
      
      $('.balanceExterno').each(function(i) {

        let ext = toNumber($(this).text());
        let int = toNumber($('.balanceInterno[data-idx="' + i + '"]').text());
        globales.push(ext+int);
        
      });

    
      globales.forEach((balance) => {
        
        $('#tb-global').append(`
          <tr>
            <td class="text-right">${fmt(balance)}</td>
          </tr>`)
      })

    }

  })

</script>
