init();
function init() {
    obtenerNotas();
}

function obtenerNotas(busqueda = '') {
    tableNotas = $('#bodyTableNotas');
    if (busqueda == '') {
        $.ajax({
            type : 'POST',
            url : '../../app/Controlador/RecepcionControlador.php?operador=obtener_notas',
            success : function(response) {
                $('#inputBusquedaNotas').val('');
                procesarRespuestaNotas(response, tableNotas)
            }
        });
    } else {
        data = {
            'busqueda' : busqueda
        };

        $.ajax({
            data : data,
            type : 'POST',
            url : '../../app/Controlador/RecepcionControlador.php?operador=busqueda_nota',
            success : function(response){
                procesarRespuestaNotas(response, tableNotas);
            }
        });
    }
    
}

function procesarRespuestaNotas(response, table){
    table.empty();
    if (response.trim() == 'no-data') {
        table.append(
            '<tr>'+
                '<td colspan="5"><p>NO SE ENCONTRÓ LA NOTA</p><p>VERIFICAR EL FOLIO O PREGUNTAR EN EL MÓDULO DE NOTAS POR QUÉ NO LA REGISTRARON</p></td>'+
            '</tr>'
        );
    } else if (response.trim() == 'error') {
        toastr.error('Error al cargar los datos');
    } else {
        var notas = JSON.parse(response).notas;
        var tipoUsuario = JSON.parse(response).tipoUsuario
        $.each(notas, function(id, nota) {
            btnEntregar = ''
            if (tipoUsuario == 'atencion') {
                btnEntregar = '';
            }else{
                btnEntregar = '<button type="button" class="btn btn-primary" onclick="entregarNota('+nota.iddocumento+');">Entregar</button>';
            }
            estatus = nota.estatus == 'entregada' ? 'Se acabó de surtir' : 'Se sigue surtiendo';
            table.append(
                '<tr>'+
                '<td>'+nota.folio+'</td>'+
                '<td>'+nota.cliente+'</td>'+
                '<td>'+nota.hora+'</td>'+
                '<td>'+estatus+'</td>'+
                '<td>'+btnEntregar+'</td>'+
                '</tr>'
            );
        });
    }
}

function evitarDobleClic(btn) {
    // Desactivar el botón
    btn.disabled = true;

    // Habilitar el botón después de un tiempo
    setTimeout(function() {
        btn.disabled = false;
    }, 850);
}

$(document).ready(function() {
    $('#inputBusquedaNotas').on('input', function(){
        busqueda = $('#inputBusquedaNotas').val();
        obtenerNotas(busqueda);
    });
});

function entregarNota(iddoc){
    data = {
        'iddoc' : iddoc
    }

    $.ajax({
        data : data,
        type : 'POST',
        url : '../../app/Controlador/RecepcionControlador.php?operador=entregar_nota',
        success : function(response){
            response = response.trim();
            switch (response) {
                case 'required':
                    toastr.warning('Ocurrio un error')
                    break;

                case 'error':
                    toastr.error('Algo salio mal', 'Error')
                    break;

                case 'success':
                    toastr.success('Nota entregada');
                    obtenerNotas();
                    break;
            }
        }
    });
}

function buscarnota(){
    var valorinput = $("#busfolio").val();
    var folioNumerico = valorinput.replace(/[B\s]/g, '');
console.log("busca:"+valorinput);
    $.ajax({
        type: "POST",
        url: '../../app/Controlador/RecepcionControlador.php?operador=Consultar_Estado_nota',
        data: { buscar: folioNumerico },
        dataType: "text",
        success: function (response) {
            $('#contenido_notas').hide();
            $('#resultado_busqueda').show();
            document.getElementById("resultado_busqueda").innerHTML = '';
            document.getElementById("resultado_busqueda").innerHTML = response;
        }
    });
    setTimeout(clearSearch, 8000);
}  

function clearSearch(){
    $('#busfolio').val('');
    $('#resultado_busqueda').hide();
    $('#contenido_notas').show();
}

function recargarContenido(){
    obtenerNotas();
}