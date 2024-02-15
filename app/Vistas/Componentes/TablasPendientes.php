<section>
    <div class="text-center">
        <p>
            <button id="btn_notas_pagos_pendientes" type="button" class="btn btn-outline-primary" onclick="manejoContenidoNotas('notas_pagos_pendientes', 'btn_notas_pagos_pendientes')">Pagos Pendientes</button>
            <button id="btn_notas_no_surtir" type="button" class="btn btn-outline-primary" onclick="manejoContenidoNotas('notas_no_surtir', 'btn_notas_no_surtir')">
                No surtir
            </button>
            <button id="btn_gallo_corona" type="button" class="btn btn-outline-primary" onclick="manejoContenidoNotas('notas_gallo_corona', 'btn_gallo_corona')">
                Gallo Corona
            </button>
        </p>
    </div>
    <div class="row my-3">
        <div class="col-md-12">
            <div  class="collapse multi-collapse" id="notas_pagos_pendientes">
                <div  class="card card-body">
                    <h1 class="title-table">Notas pagos pendientes</h1>
                    <div style="max-height: 300px" class="overflow-auto">
                        <table class="table">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>FOLIO</th>
                                    <th>CLIENTE</th>
                                    <th>FECHA</th>
                                    <th>TOTAL</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTableNotasPagosPendientes" class="text-center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="collapse multi-collapse" id="notas_no_surtir">
                <div class="card card-body">
                    <h1 class="title-table">Notas no surtir</h1>
                    <input style="width: auto !important; margin:5px;" type="date" class="form-control" id="input_fecha_no_surtir">
                    <div  style="max-height: 300px" class="overflow-auto">
                        <table class="table">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>FOLIO</th>
                                    <th>CLIENTE</th>
                                    <th>FECHA</th>
                                    <th>TOTAL</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTableNotasNoSurtir" class="text-center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="collapse multi-collapse" id="notas_gallo_corona">
                <div class="card card-body">
                    <h1 class="title-table">Notas gallo corona</h1>
                    <div  style="max-height: 300px" class="overflow-auto">
                        <table class="table">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>FOLIO</th>
                                    <th>CLIENTE</th>
                                    <th>FECHA</th>
                                    <th>TOTAL</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTableNotasGalloCorona" class="text-center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
