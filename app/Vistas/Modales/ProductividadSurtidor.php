<div class="modal modal-lg fade" id="modal_productividad_surtidor" tabindex="-1" aria-labelledby="modal_productividad_surtidor" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registro de notas surtidas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario_consultar_notas_empleados" class="row g-3" action="../Controlador/ReporteProductividadSurtidor.php" method="post" target="_blank">
                    <div class="col-3">
                        <input type="number" name="nlista_notas_surtidor" id="nlista_notas_surtidor" hidden>
                        <input type="text" name="nombre_notas_surtidor" id="nombre_notas_surtidor" hidden>
                        <input type="text" name="departamento_notas_surtidor" id="departamento_notas_surtidor" hidden>
                        <input type="date" class="form-control" placeholder="" aria-label="" name="fecha_inicio_notas_surtidor" id="fecha_inicio_notas_surtidor">
                    </div>
                    <div class="col-3">
                        <input type="date" class="form-control" placeholder="" aria-label="" name="fecha_fin_notas_surtidor" id="fecha_fin_notas_surtidor">
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-primary" onclick="consultarNotasSurtidor();">Consultar</button>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">PDF</button>
                    </div>
                </form>
                <table class="table mt-3" id="miTabla">
                    <thead>
                        <tr>
                            <th scope="col">Folio</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Paginas</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTableNotasSurtidor">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>