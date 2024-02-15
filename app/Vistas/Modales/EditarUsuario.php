<div class="modal fade" id="modal_editar_usuario">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_editar_usuario" enctype="multipart/form-data">
                    <input type="text" id="id_editar_usuario" name="id_editar_usuario" value="" hidden>
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre</label>
                        <input placeholder="Ingresa el nombre" type="text" class="form-control" name="nombre_usuario" id="editar_nombre_usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono_usuario" class="form-label">Teléfono</label>
                        <input type="tel" onkeypress="return [45, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57].includes(event.charCode);" maxlength="10" required class="form-control" placeholder="Ingresa el numero de telefono" name="telefono_usuario" id="editar_telefono_usuario">
                    </div>
                    <div class="mb-3">
                        <label for="tipo_usuario" class="form-label">Tipo</label>
                        <select class="form-select" name="tipo_usuario" id="editar_tipo_usuario" required>
                            <option value="" disabled selected>Selecciona una opción...</option>
                            <option value="admin">Administrador</option>
                            <option value="notas">Notas</option>
                            <option value="recepcion">Recepcion</option>
                            <option value="atencion">Atencion</option>
                            <option value="bodegas">Bodegas</option>
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