init();

function init() {
    obtenerSolicitudes();

}

function obtenerSolicitudes(busqueda = '') {

    tableSolicitudes = $('#bodyTableSolicitudes');
    if (busqueda == '') {
        $.ajax({
            type: 'POST',
            url: '../../app/Controlador/compradoresControlador.php?operador=obtener_solicitudes',
            success: function (response) {
                $('#inputBusquedaUsuarios').val('');
                procesarRespuestaSolicitudes(response, tableSolicitudes);
            }
        });
    } else {
        console.log(busqueda);
    }
}

function procesarRespuestaSolicitudes(response, table) {
    table.empty();
    if (response.trim() == 'no-data') {
        toastr.info('No hay datos para mostrar');
    } else if (response.trim() == 'error') {
        toastr.error('Error al cargar los datos', 'Solicitudes');
    } else {
        $.each(JSON.parse(response), function (ID_solicitud, solicitudes) {
            var observaciones = solicitudes.observaciones ? solicitudes.observaciones : "No hay observaciones";
            var botonRechazar = solicitudes.status_solicitud === 'Pendiente' ? '<button type="button" class="btn btn-danger btn-sm m-1" onclick="modalRechazarSolicitud(' + solicitudes.ID_solicitud + ');"> <i class="bi bi-x-octagon-fill">' + ' ' + 'Rechazar</i></button>' : '';
            var botonEntregar = solicitudes.status_solicitud === 'Pendiente' ? '<button type="button" class="btn btn-info btn-sm m-1" onclick="modalEntregarSolicitud(' + solicitudes.ID_solicitud + ');"><i class="bi bi-check-circle-fill">' + ' ' + 'Entregar</i></button>' : '';
            var botonEvidencias = solicitudes.status_solicitud === 'Entregado' ? '<button type="button" class="btn btn-info btn-sm m-1" onclick="obtenerPassword(' + solicitudes.ID_solicitud + ');"><i class="bi bi-image">' + ' ' + ' Evidencias </i></button>' : '';
            var botonRestaurar = solicitudes.status_solicitud === 'Rechazado' ? '<button type="button" class="btn btn-info btn-sm m-1" onclick="modalRestaurarSolicitud(' + solicitudes.ID_solicitud + ');"><i class="bi bi-shield-fill-check">' + ' ' + ' Restaurar </i></button>' : '';
        
            table.append(
                '<tr class="status' + solicitudes.status_solicitud + '">' +
                '<td>' + solicitudes.fecha_solicitud + '</td>' +
                '<td>' + solicitudes.tarjeta + '</td>' +
                '<td>' + solicitudes.fecha_requerido + ' ' + solicitudes.hora_requerido + '</td>' +
                '<td>' + solicitudes.nombre + '</td>' +
                '<td>' + observaciones + '</td>' +
                '<td>' + solicitudes.status_solicitud + '</td>' +
                '<td>' +
                botonEntregar +
                botonEvidencias +
                botonRechazar +
                botonRestaurar +
                '</td>' +
                '</tr>'
            );
        });
    }
}



function modalRechazarSolicitud(ID_solicitud) {
    $('#modal_rechazar_solicitud').modal('show');
    $('#ID').val(ID_solicitud);
}

$(document).on("submit", "#form_rechazar_solicitud", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: '../../app/Controlador/inventariosControlador.php?operador=rechazar_solicitud',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se rechazo la solicitud');
                $('#modal_rechazar_solicitud').modal('hide');
                //     obtenerUsuarios();

                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});




function modalRestaurarSolicitud(ID_solicitud) {
    $('#modal_restaurar_solicitud').modal('show');
    $('#ID_inventario').val(ID_solicitud);
}

$(document).on("submit", "#form_restaurar_solicitud", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
     for (var entrada of formData.entries()) {
        console.log(entrada[0] + ': ' + entrada[1]);
     }
    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: '../../app/Controlador/inventariosControlador.php?operador=restaurar_solicitud',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se restauró la solicitud');
                $('#modal_restaurar_solicitud').modal('hide');
                //     obtenerUsuarios();

                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});



function modalEntregarSolicitud(ID_solicitud) {
    $('#modal_entregar_solicitud').modal('show');
    $('#ID_inventarioEntregar').val(ID_solicitud);
}

$(document).on("submit", "#form_entregar_solicitud", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
     for (var entrada of formData.entries()) {
        console.log(entrada[0] + ': ' + entrada[1]);
     }
    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: '../../app/Controlador/inventariosControlador.php?operador=entregar_solicitud',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se entregó la solicitud');
                $('#modal_entregar_solicitud').modal('hide');
                //     obtenerUsuarios();

                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});








function modalAgendarPedido() {
    $('#modal_agendar_pedido').modal('show');
}

$(document).on("submit", "#form_agendar_pedido", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: '../../app/Controlador/inventariosControlador.php?operador=agendar_pedido',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se rechazo la solicitud');
                $('#modal_agendar_pedido').modal('hide');
                //     obtenerUsuarios();

                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});

