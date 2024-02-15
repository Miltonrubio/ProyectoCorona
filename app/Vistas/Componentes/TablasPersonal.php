<section>
    <div class="text-center">
        <p>
            <button id="btn_personal_mayoreo" type="button" class="btn btn-outline-primary" onclick="manejoContenidoPersonal('personal_mayoreo', 'btn_personal_mayoreo')">Personal mayoreo</button>
            <button id="btn_personal_maniobras" type="button" class="btn btn-outline-primary" onclick="manejoContenidoPersonal('personal_maniobras', 'btn_personal_maniobras')">maniobras</button>
            <button id="btn_personal_super" type="button" class="btn btn-outline-primary" onclick="manejoContenidoPersonal('personal_super', 'btn_personal_super')">super</button>
        </p>
    </div>
    <div class="row my-3">
        <div class="col-md-12">
            <div class="collapse multi-collapse" id="personal_mayoreo">
                <div class="card card-body">
                    <h1 class="title-table">Empleados Mayoreo</h1>
                    <input style="width: auto !important; margin:5px;" type="search" class="form-control "  id="inputBusquedaPersonalMayoreo" placeholder="Realiza una busqueda">
                    <div style="max-height: 300px" class="overflow-auto">
                        <table class="table ">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>Nlista</th>
                                    <th>Nombre</th>
                                    <th>Departamento</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTablePersonalMayoreo" class="text-center ">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="collapse multi-collapse" id="personal_maniobras">
                <div class="card card-body">
                    <h1 class="title-table">Empleados Maniobras</h1>
                    <input style="width: auto !important; margin:5px;" type="search" class="form-control "  id="inputBusquedaPersonalManiobras" placeholder="Realiza una busqueda">
                    <div style="max-height: 300px" class="overflow-auto">
                        <table class="table ">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>Nlista</th>
                                    <th>Nombre</th>
                                    <th>Departamento</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTablePersonalManiobras" class="text-center ">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="collapse multi-collapse" id="personal_super">
                <div class="card card-body">
                    <h1 class="title-table">Empleados Super</h1>
                    <input style="width: auto !important; margin:5px;" type="search" class="form-control "  id="inputBusquedaPersonalSuper" placeholder="Realiza una busqueda">
                    <div style="max-height: 300px" class="overflow-auto">
                        <table class="table ">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>Nlista</th>
                                    <th>Nombre</th>
                                    <th>Departamento</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTablePersonalSuper" class="text-center ">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>