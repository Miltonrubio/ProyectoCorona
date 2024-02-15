init();

function init() {
    obtenerUsuarios();
    
}

function obtenerUsuarios(busqueda = '') {
    
    tableUsuarios = $('#bodyTableUsuarios');
    if (busqueda == '') {
        $.ajax({
            type : 'POST',
            url : '../../app/Controlador/AdminControlador.php?operador=obtener_usuarios',
            success : function(response) {
                $('#inputBusquedaUsuarios').val('');
                procesarRespuestaUsuarios(response, tableUsuarios);
            }
        });
    } else {
        console.log(busqueda);
    }
}

function procesarRespuestaUsuarios(response, table) {
    table.empty();
    if (response.trim() == 'no-data') {
        toastr.info('No hay datos para mostrar');
    } else if (response.trim() == 'error') {
        toastr.error('Error al cargar los datos', 'Usuarios');
    } else {
        $.each(JSON.parse(response), function(ID_usuario, usuario) {
            table.append(
                '<tr>'+
                '<td>'+usuario.nombre+'</td>'+
                '<td>'+usuario.telefono+'</td>'+
                '<td>'+usuario.empresa+'</td>'+
                '<td>'+usuario.permisos+'</td>'+
                '<td>'+
                '<button type="button" class="btn btn-info btn-sm m-1" onclick="modalEditarPassword('+usuario.ID_usuario+');">Editar</button>'+
                '<button type="button" class="btn btn-info btn-sm m-1" onclick="obtenerPassword('+usuario.ID_usuario+');">Contraseña</button>'+
                '<button type="button" class="btn btn-danger btn-sm m-1" onclick="modalEliminarUsuario('+usuario.ID_usuario+');">Eliminar</button>'+
                '</td>'+
                '</tr>'
            );
        });
    }
}

function modalAgregarUsuario() {
    $('#modal_agregar_usuario').modal('show');
    $('#form_nuevo_usuario').trigger('reset');
}

$(document).on("submit", "#form_nuevo_usuario", function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type : "POST",
        method : "POST",
        dataType : "html",
        data : formData,
        cache : false,
        contentType : false,
        processData : false,
        url : '../../app/Controlador/AdminControlador.php?operador=registrar_usuario',
        success : function(response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Registro exitoso');
                $('#modal_agregar_usuario').modal('hide');
                obtenerUsuarios();
            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else if(response === 'exist'){
                toastr.warning('Ya existen un usuario con el mismo telefono')
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
})

function modalEliminarUsuario(idUsuario){
    $('#modal_eliminar_usuario').modal('show');
    $('#id_usuario_eliminar').val(idUsuario);
}

$(document).on("submit", "#form_eliminar_usuario", function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type : "POST",
        method : "POST",
        dataType : "html",
        data : formData,
        cache : false,
        contentType : false,
        processData : false,
        url : '../../app/Controlador/AdminControlador.php?operador=eliminar_usuario',
        success : function(response){
            response = response.trim();
            if (response === 'success') {
                toastr.success('Usuario eliminado');
                $('#modal_eliminar_usuario').modal('hide');
                obtenerUsuarios();
            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});

function modalEditarPassword(idUsuario){
    $('#modal_editar_usuario').modal('show');
    $('#form_editar_usuario').trigger('reset');
    $('#id_editar_usuario').val(idUsuario);
    data = {
        'idUsuario' : idUsuario
    };
    $.ajax({
        data : data,
        type : 'POST',
        url : '../../app/Controlador/AdminControlador.php?operador=obtener_info_usuario',
        success : function (response){
            usuario = JSON.parse(response);
            $('#editar_nombre_usuario').val(usuario.nombre);
            $('#editar_telefono_usuario').val(usuario.telefono);
            $('#editar_tipo_usuario').val(usuario.tipo);
        }
    });
}

$(document).on("submit", "#form_editar_usuario", function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type : "POST",
        method : "POST",
        dataType : "html",
        data : formData,
        cache : false,
        contentType : false,
        processData : false,
        url : '../../app/Controlador/AdminControlador.php?operador=editar_usuario',
        success : function(response){
            response = response.trim();
            if (response === 'success') {
                toastr.success('Datos actualizados');
                $('#modal_editar_usuario').modal('hide');
                obtenerUsuarios();
            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});

function obtenerPassword(idUsuario){
    $('#modal_ver_password').modal('show');
    bodyModal = $('#body_modal_password'); 
    data = {
        'idUsuario' : idUsuario
    };
    $.ajax({
        data : data,
        type : 'POST',
        url : '../../app/Controlador/AdminControlador.php?operador=ver_password_usuario',
        success : function (response){
            bodyModal.empty();
            bodyModal.append(
                '<h4 class="text-center">'+response+'</h4>'
            );
        }
    });
}