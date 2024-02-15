<div class="modal fade" id="modal_editar_usuario">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_editar_usuario" enctype="multipart/form-data">
                    <input type="text" id="ID_usuario" name="ID_usuario" value="" hidden>
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre</label>
                        <input placeholder="Ingresa el nombre" type="text" class="form-control" name="nombre_usuario" id="editar_nombre_usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electronico</label>
                        <input placeholder="Ingresa el nombre" type="text" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono_usuario" class="form-label">Teléfono</label>
                        <input type="tel" onkeypress="return [45, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57].includes(event.charCode);" maxlength="10" required class="form-control" placeholder="Ingresa el numero de telefono" name="telefono_usuario" id="editar_telefono_usuario">
                    </div>
                    <div class="mb-3">
                        <label for="empresa" class="form-label">Empresa</label>
                        <select class="form-select" name="empresa" id="empresa" required>
                            <option value="" disabled selected>Selecciona una opción...</option>
                            <option value="BITALA">BITALA</option>
                            <option value="CORONA">CORONA</option>
                            <option value="HIDALGO">HIDALGO</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="permisos" class="form-label">Rol</label>
                        <select class="form-select" name="permisos" id="permisos" required>
                            <option value="" disabled selected>Selecciona una opción...</option>
                            <option value="SUPERADMIN">SUPERADMIN</option>
                            <option value="INVENTARIO">INVENTARIO</option>
                            <option value="SOLICITANTE">SOLICITANTE</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>