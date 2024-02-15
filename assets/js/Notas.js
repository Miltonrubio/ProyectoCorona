init()
let navegador = "";

function init() {
    document.getElementById("ajaxBusy").style.display = "none";
    //this.navegador=getBrowserInfo();
    //console.log(this.navegador);
    //fechaactual();
   
    //consultarNotasTop10();
    //consultarProductividad()
    fechahora();
    consultarNotasAsignadas();
    //limpiarformularios();
    barratiempo()
    obtenerNotasSinCargar();
    obtenerNotasSinAsignar();
    $('#personal_mayoreo').hasClass('show') ? obtenerPersonal('Mayoreo') : '';
    $('#personal_maniobras').hasClass('show') ? obtenerPersonal('Maniobras') : '';
    $('#personal_super').hasClass('show') ? obtenerPersonal('Super') : '';
    setTimeout(init, 80000); 
}

var fechaInput = document.getElementById('input_fecha_no_surtir');

function fechahora(){
    let date = new Date();
    document.getElementById("fechax").innerHTML=""+date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate(); 
    document.getElementById("horax").innerHTML=""+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
}

function barratiempo(){
   
const progresoRespuesta= document.querySelector('#respuesta');

//método que devuelve una promesa, como axios.post
function simulaPost(valor) {
  return new Promise(function(success,error) {
    setTimeout(()=>success(valor), 1000 * valor);
  });
}

for (let i=0; i<80;i++) {
 // console.log('hago la llamada con',i);
 
  simulaPost(i)
    .then(respuesta => {
     // console.log('Tengo la respuesta', respuesta);
      progresoRespuesta.value= i*1;
    });
}
}


function metaKeyUp (event) {
    var exampleKey = 13;
    var key = event.keyCode || event.which;
  console.log(key);
    if (key == exampleKey) {
      //metaChar = false;
      buscarnota();

    }
  }

function buscarnota(){
    var valorinput = $("#busfolio").val();
console.log("busca:"+valorinput);
    $.ajax({
        type: "POST",
        url: '../../app/Controlador/NotasControlador.php?operador=Consultar_Estado_nota',
        data: { buscar: valorinput },
        dataType: "text",
        beforeSend: function() {
            $("#ajaxBusy").show();
            $("#ajaxfecha").hide();
        },
        success: function (response) {
            $("#ajaxBusy").hide();
            $("#ajaxfecha").show();
            $('#tablas_notas').hide();
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
    $('#tablas_notas').show();
}

function consultarNotasAsignadas(){
    $.ajax({
        type: "POST",
        url: '../../app/Controlador/NotasControlador.php?operador=Consultar_NotasDia',
        data: { estatus: "1" },
        dataType: "text",
        beforeSend: function() {
            $("#ajaxBusy").show();
            $("#ajaxfecha").hide();
        },
        success: function (response) {
            $("#ajaxBusy").hide();
            $("#ajaxfecha").show();
            document.getElementById("tabla_notas_asignadas").innerHTML = response;
           // barratiempo();
        }
    });
}

function consultarNotasTop10(){
    $.ajax({
        type: "POST",
        url: '../../app/Controlador/NotasControlador.php?operador=Consultar_Top10',
        data: { estatus: "1" },
        dataType: "text",
        beforeSend: function() {
            $("#ajaxBusy").show();
            $("#ajaxfecha").hide();
        },
        success: function (response) {
            $("#ajaxBusy").hide();
            $("#ajaxfecha").show();
            document.getElementById("tabla_top_10").innerHTML = response;
        }
    });
}

function fechaactual() {
    let objectDate = new Date();
    let day = objectDate.getDate();
    let month = objectDate.getMonth()+1;
    let year = objectDate.getFullYear();
    if (day < 10) {
        day = '0' + day;
    }
    if (month < 10) {
        month = `0${month}`;
    }
    let format1 = year+"-"+month+"-"+day;
//    document.getElementById('fechaservicio').value = format1;

}

function consultarProductividad(){
    $.ajax({
        type: "POST",
        url: '../../app/Controlador/NotasControlador.php?operador=Consultar_TotalNotasDia',
        data: { estatus: "1" },
        dataType: "text",
        beforeSend: function() {
            $("#ajaxBusy").show();
            $("#ajaxfecha").hide();
        },
        success: function (response) {
            $("#ajaxBusy").hide();
            $("#ajaxfecha").show();
            document.getElementById("productividad").innerHTML = response;
        }
    });
}

function obtenerNotasSinCargar(){
    tableNotas = $('#bodyTableNotasSinCargar');
    $.ajax({
        type: "POST",
        url: '../../app/Controlador/NotasControlador.php?operador=consultar_notas_sin_cargar',
        success: function (response) {
            tableNotas.empty();
            if (response.trim() == 'error') {
                toastr.error("Error al cargar los datos", "Notas sin cargar");
            } else if (response.trim() == 'no-data') {
                //toastr.info("No hay datos para mostrar", "Notas sin cargar");
            } else{
                $.each(JSON.parse(response), function(id, nota) {
                    tableNotas.append(
                        '<tr>'+
                        '<td style="cursor:pointer;" onclick="noSurtir('+nota.DOCID+')">'+nota.NUMERO+'</td>'+
                        '<td class="hidden-xl">'+nota.PAG+'</td>'+
                        '<td class="nombreCliente">'+nota.NOTA+'</td>'+
                        '<td class="hidden-xl">'+nota.FECHA+'</td>'+
                        '<td><button type="button" class="btn btn-primary" onclick="cargarNota('+nota.NUMERO+','+nota.TOTAL+',\''+nota.NOTA+'\','+nota.PAG+','+nota.VENDEDORID+',\''+nota.SERIE+'\','+nota.DOCID+'); evitarDobleClic(this);">Cargar</button></td>'+
                        '</tr>'
                    );
                });
            }
        }
    });
}

function cargarNota (numero, importe, cliente, pag, vendedorID, serie, idDoc ){
    data = {
        'numero': numero,
        'importe': importe,
        'cliente': cliente,
        'pag': pag,
        'vendedorID': vendedorID,
        'serie': serie,
        'idDoc': idDoc
    };
    $.ajax({
        type:'POST',
        data:data,
        url:'../../app/Controlador/NotasControlador.php?operador=cargar_nota',
        success: function (response) {
            response = response.trim();

            if (response == 'success') {
                toastr.success('Nota cargada');
                obtenerNotasSinCargar();
                obtenerNotasSinAsignar();
                var contenidoPagosPendientes = document.getElementById('notas_pagos_pendientes');
                var contenidoNoSurtir = document.getElementById('notas_no_surtir');
                var contenidoGalloCorona = document.getElementById('notas_gallo_corona');
                if (contenidoPagosPendientes.classList.contains('show')) {
                    obtenerNotasPagosPendientes();
                    //toastr.info('Se recargo pagos pendientes')
                } else if (contenidoNoSurtir.classList.contains('show')) {
                    obtenerNotasNoSurtir();
                    //toastr.info('Se recargo no surtir');
                } else if (contenidoGalloCorona.classList.contains('show')) {
                    obtenerNotasGalloCorona();
                }
            }else if(response == 'vacio'){
                toastr.warning("No se pudo cargar la nota");
            }else if (response == 'error'){
                toastr.error("Algo salio mal");
            }
        }
    });
}

function obtenerNotasSinAsignar(busqueda = ''){
    tableNotasSinAsignar = $('#bodyTableNotasSinAsignar');
    if (busqueda == '') {
        //console.log('entra a consultar todo');
        $.ajax({
            type: "POST",
            url: '../../app/Controlador/NotasControlador.php?operador=consultar_notas_sin_asignar',
            success: function (response) {
                $('#inputBusquedaNotas').val('');
                tableNotasSinAsignar.empty();
                if (response.trim() == 'no-data') {
                    //toastr.info("No hay datos para mostrar", "Notas sin asignar");
                }else if(response.trim() == 'error') {
                    toastr.error("Error al cargar los datos", "Notas sin asignar");
                } else{
                    $.each(JSON.parse(response), function(id, nota) {
                        var trClass = nota.ESTADO == 'SURTIENDO' ? 'fila-asignada' : '';
                        tableNotasSinAsignar.append(
                            '<tr class="'+trClass+'">'+
                            '<td>'+nota.FOLIO+'</td>'+
                            '<td class="nombreCliente">'+nota.CLIENTE+'</td>'+
                            '<td class="hidden-xl">'+nota.HORA+'</td>'+
                            '<td><button type="button" class="btn btn-primary" onclick="asignarNota('+nota.IDDOCUMENTO+', '+nota.IDPARTIDA+',\''+nota.ESTADO+'\')">Asignar</button></td>'+
                            '</tr'
                        );
                    });
                }
            }
        });
    }else{
        //console.log('entra a buscar');
        data = {
            'busqueda' : busqueda
        };
        $.ajax({
            data:data,
            type: "POST",
            url: '../../app/Controlador/NotasControlador.php?operador=busqueda_notas_sin_asignar',
            success: function (response) {
                tableNotasSinAsignar.empty();
                if (response.trim() == 'no-data') {
                    //toastr.info("No hay datos para mostrar", "Notas sin asignar");
                }else if(response.trim() == 'error') {
                    toastr.error("Error al cargar los datos", "Notas sin asignar");
                } else{
                    $.each(JSON.parse(response), function(id, nota) {
                        var trClass = nota.ESTADO == 'SURTIENDO' ? 'fila-asignada' : '';
                        tableNotasSinAsignar.append(
                            '<tr class="'+trClass+'">'+
                            '<td>'+nota.FOLIO+'</td>'+
                            '<td class="nombreCliente">'+nota.CLIENTE+'</td>'+
                            '<td class="hidden-xl">'+nota.HORA+'</td>'+
                            '<td><button type="button" class="btn btn-primary" onclick="asignarNota('+nota.IDDOCUMENTO+', '+nota.IDPARTIDA+',\''+nota.ESTADO+'\')">Asignar</button></td>'+
                            '</tr>'
                        );
                    });
                }
            }
        });
    }
}

function asignarNota(idDoc, idNota, estadoNota){
    //console.log('Este es el estado de la nota:' + estadoNota)
    $('#modal_asignar_nota').modal('show');
    $('#idNota').val('');
    $('#idDoc').val('');
    $('#nlEmpleado').val('');
    $('#idNota').val(idNota);
    $('#idDoc').val(idDoc);
    pintarHojas(idDoc, estadoNota);
}

$('#modal_asignar_nota').on('shown.bs.modal', function () {
    $('#nlEmpleado').focus();
});

var hojasSeleccionadas = [];
function pintarHojas(idDoc, estadoNota) {
    data = {
        'idDoc' : idDoc
    }
    $.ajax({
        data: data,
        type: 'POST',
        url: '../../app/Controlador/NotasControlador.php?operador=consultar_paginas_notas',
        success:function(response){
            // console.log('Este es el response:');
            // console.log(response);
            hojasSeleccionadas = [];
            jsonPaginas = JSON.parse(response);
            var miBoton = document.getElementById("btnAsignarNota");

            miBoton.onclick = function () {
                asignarNotabd(jsonPaginas.length, estadoNota);
            };
            $('#nlEmpleado').off('keypress').on('keypress', function (event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == '13') {
                    asignarNotabd(jsonPaginas.length, estadoNota);
                }
            });

            const hojasContainer = document.getElementById('hojasContainer');

            if (jsonPaginas.length > 2) {
                
                hojasContainer.innerHTML = '<h4>Selecciona las hojas para asignar</h4>';
                $.each(jsonPaginas, function(id, pagina) {
                    const div = document.createElement('div');
                    const hojaId = pagina.id;
                    div.className = 'card hoja d-inline-block text-center';  
                    div.dataset.hojaId = pagina.id;  
                    div.innerHTML = `
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <h5 class="card-title">Hoja ${pagina.num_pagina}</h5>
                        </div>
                    `;
    
                    // Verifica si la hoja está asignada
                    if (pagina.estatus == 'ASIGNADA') {
                        div.classList.add('selected-disabled');
                        // Deshabilita el evento click para hojas asignadas
                        div.style.pointerEvents = 'none';
                    }
    
                    div.addEventListener('click', () => {
                        if (div.classList.contains('selected')) {
                            // Si ya está seleccionado, deselecciónalo
                            div.classList.remove('selected');
                            // Elimina el ID de la hoja de la lista de seleccionadas
                            const index = hojasSeleccionadas.indexOf(hojaId);
                            if (index !== -1) {
                                hojasSeleccionadas.splice(index, 1);
                            }
                        } else {
                            // Si no está seleccionado, selecciónalo
                            div.classList.add('selected');
                            // Agrega el ID de la hoja a la lista de seleccionadas
                            hojasSeleccionadas.push(hojaId);
                        }
                        //console.log(hojasSeleccionadas);
                    });
    
                    hojasContainer.appendChild(div);
                });
            } else{
                hojasContainer.innerHTML = '';
            }
            
        }
    })
}

function asignarNotabd(pagesLength, estadoNota){
    surtidor = $('#nlEmpleado').val();
    idDoc = $('#idDoc').val();
    if (estadoNota === 'SURTIENDO' &&  pagesLength <= 2) {
        toastr.warning('Esta nota ya ha sido asignada');
        return;
    }else{
        data = {
            'idDoc' : idDoc,
            'nlista': surtidor,
            'numPages' : pagesLength,
            'estadoNota' : estadoNota
        };
    
        if (pagesLength > 2) {
            data.paginas = hojasSeleccionadas;
        } 
        $.ajax({
            data: data,
            type: 'POST',
            url: '../../app/Controlador/NotasControlador.php?operador=asignar_paginas_empleado',
            success: function(response){
                response = response.trim();
                if (response == 'success') {
                    toastr.success('Nota asignada');
                    $('#modal_asignar_nota').modal('hide');
                    obtenerNotasSinAsignar();
                    consultarNotasAsignadas();
                    //recargar contenido de personal si es que se esta visualizando
                    $('#personal_mayoreo').hasClass('show') ? obtenerPersonal('Mayoreo') : '';
                    $('#personal_maniobras').hasClass('show') ? obtenerPersonal('Maniobras') : '';
                    $('#personal_super').hasClass('show') ? obtenerPersonal('Super') : '';
                } else if(response == 'asignada') {
                    toastr.warning('Esta nota ya ha sido asignada');
                } else if(response == 'required') {
                    toastr.warning("Rellene todos los campos");
                } else if (response == 'error') {
                    toastr.error('Ocurrio un error en la peticion');
                }
            }
        });
    }
    
}

function noSurtir(idDoc) {
    $('#modal_confirmacion').modal('show');
    $('#input_idDoc_Pendiente').val('');
    $('#input_idDoc_Pendiente').val(idDoc);
    //console.log(idDoc);
}

$(document).on("submit", "#form_asignar_nota_pendiente", function(e) {
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
        url: '../../app/Controlador/NotasControlador.php?operador=cambiar_estatus_pendiente',
        success: function (response) {
            response = response.trim();
            if (response == 'success') {
                toastr.success('Operación exitosa');
                $('#modal_confirmacion').modal('hide');
            } else if (response == 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});

function obtenerNotasPagosPendientes() {
    tableNotasPagosPendientes = $('#bodyTableNotasPagosPendientes');
    $.ajax({
        type: 'POST',
        url: '../../app/Controlador/NotasControlador.php?operador=consultar_notas_pagos_pendientes',
        success: function (response) {
            tableNotasPagosPendientes.empty();
            if (response.trim() == 'error') {
                toastr.error("No se pueden cargar los datos");
            } else if(response.trim() == 'no-data') {
                toastr.info('No hay datos para mostrar', 'Notas pagos pendientes', {
                    timeOut: 1500,
                    extendedTimeOut: 0,
                    preventDuplicates: true,
                });
            } else {
                $.each(JSON.parse(response), function(id, nota){
                    tableNotasPagosPendientes.append(
                        '<tr>'+
                            '<td class="nombreCliente">'+nota.NUMERO+'</td>'+
                            '<td class="nombreCliente">'+nota.NOTA+'</td>'+
                            '<td>'+nota.FECHA+'</td>'+
                            '<td>'+nota.TOTAL+'</td>'+
                            '<td><button type="button" class="btn btn-primary" onclick="cargarNota('+nota.NUMERO+','+nota.TOTAL+',\''+nota.NOTA+'\','+nota.PAG+','+nota.VENDEDORID+',\''+nota.SERIE+'\','+nota.DOCID+'); evitarDobleClic(this);">Cargar</button></td>'+
                        '</tr>'
                    );
                });
            }
        }
    });
}

function obtenerNotasNoSurtir() {
    tableNotasNoSurtir = $('#bodyTableNotasNoSurtir');
    fechaSeleccionada = $('#input_fecha_no_surtir').val();
    data = {
        'fecha' : fechaSeleccionada
    };
    $.ajax({
        data : data,
        type: 'POST',
        url: '../../app/Controlador/NotasControlador.php?operador=consultar_notas_no_surtir',
        success: function (response) {
            tableNotasNoSurtir.empty();
            if (response.trim() == 'error') {
                toastr.error("No se pueden cargar los datos");
            } else if(response.trim() == 'no-data') {
                toastr.info('No hay datos para mostrar ', 'Notas no surtir', {
                    timeOut: 1500,
                    extendedTimeOut: 0,
                    preventDuplicates: true,
                });
            } else {
                $.each(JSON.parse(response), function(id, nota){
                    tableNotasNoSurtir.append(
                        '<tr>'+
                            '<td class="nombreCliente">'+nota.NUMERO+'</td>'+
                            '<td class="nombreCliente">'+nota.NOTA+'</td>'+
                            '<td>'+nota.FECHA+'</td>'+
                            '<td>'+nota.TOTAL+'</td>'+
                            '<td><button type="button" class="btn btn-primary" onclick="cargarNota('+nota.NUMERO+','+nota.TOTAL+',\''+nota.NOTA+'\','+nota.PAG+','+nota.VENDEDORID+',\''+nota.SERIE+'\','+nota.DOCID+'); evitarDobleClic(this);">Cargar</button></td>'+
                        '</tr>'
                    );
                });
            }
        }
    });
}

function manejoContenidoNotas(id, btn) {
    var contenidoColapsado = $('#' + id);
    var colapsado = contenidoColapsado.hasClass('show');
    var btnColapsado = $('#' + btn);

    var mapeoContenidos = {
        'notas_pagos_pendientes': ['notas_no_surtir', 'notas_gallo_corona'],
        'notas_no_surtir': ['notas_pagos_pendientes', 'notas_gallo_corona'],
        'notas_gallo_corona': ['notas_pagos_pendientes', 'notas_no_surtir']
    };

    var mapeoBotones = {
        'btn_notas_pagos_pendientes': ['btn_notas_no_surtir', 'btn_gallo_corona'],
        'btn_notas_no_surtir': ['btn_notas_pagos_pendientes', 'btn_gallo_corona'],
        'btn_gallo_corona': ['btn_notas_pagos_pendientes', 'btn_notas_no_surtir']
    };

    var [idOtroContenido1, idOtroContenido2] = mapeoContenidos[id];
    var [idbtnOtroContenido1, idbtnOtroContenido2] = mapeoBotones[btn];

    var [otroContenido1, otroContenido2] = [$('#' + idOtroContenido1), $('#' + idOtroContenido2)];
    var [btnOtroContenido1, btnOtroContenido2] = [$('#' + idbtnOtroContenido1), $('#' + idbtnOtroContenido2)];

    contenidoColapsado.collapse('toggle');
    btnColapsado.toggleClass("btn-primary btn-outline-primary");

    [otroContenido1, otroContenido2].forEach((otroContenido, index) => {
        var otroBtn = [btnOtroContenido1, btnOtroContenido2][index];
        if (otroContenido.hasClass('show') && otroContenido[0] !== contenidoColapsado[0]) {
            otroContenido.collapse('toggle');
            otroBtn.toggleClass("btn-primary btn-outline-primary");
        }
    });

    // Lógica para ejecutar la función correspondiente para mostrar la información, solo si el contenido no esta colapsado
    if (!colapsado) {
        switch (id) {
            case 'notas_no_surtir':
                // Obtén la fecha actual en formato yyyy-mm-dd
                var fechaActual = new Date().toISOString().split('T')[0];
                // Asigna la fecha actual al campo de entrada
                fechaInput.value = fechaActual;
                obtenerNotasNoSurtir();
                break;
            case 'notas_pagos_pendientes':
                obtenerNotasPagosPendientes();
                break;
            case 'notas_gallo_corona':
                obtenerNotasGalloCorona();
                break;
        }
    }
}



function manejoContenidoPersonal(id, btn) {
    var contenidoColapsado = $('#' + id);
    var colapsado = contenidoColapsado.hasClass('show');
    var btnColapsado = $('#' + btn);

    var mapeoContenidos = {
        'personal_mayoreo': ['personal_maniobras', 'personal_super'],
        'personal_maniobras': ['personal_mayoreo', 'personal_super'],
        'personal_super': ['personal_mayoreo', 'personal_maniobras']
    };

    var mapeoBotones = {
        'btn_personal_mayoreo': ['btn_personal_maniobras', 'btn_personal_super'],
        'btn_personal_maniobras': ['btn_personal_mayoreo', 'btn_personal_super'],
        'btn_personal_super': ['btn_personal_mayoreo', 'btn_personal_maniobras']
    };

    var [idOtroContenido1, idOtroContenido2] = mapeoContenidos[id];
    var [idbtnOtroContenido1, idbtnOtroContenido2] = mapeoBotones[btn];

    var [otroContenido1, otroContenido2] = [$('#' + idOtroContenido1), $('#' + idOtroContenido2)];
    var [btnOtroContenido1, btnOtroContenido2] = [$('#' + idbtnOtroContenido1), $('#' + idbtnOtroContenido2)];

    contenidoColapsado.collapse('toggle');
    btnColapsado.toggleClass("btn-primary btn-outline-primary");

    [otroContenido1, otroContenido2].forEach((otroContenido, index) => {
        var otroBtn = [btnOtroContenido1, btnOtroContenido2][index];
        if (otroContenido.hasClass('show') && otroContenido[0] !== contenidoColapsado[0]) {
            otroContenido.collapse('toggle');
            otroBtn.toggleClass("btn-primary btn-outline-primary");
        }
    });

    // Lógica para ejecutar la función correspondiente para mostrar la información, solo si el contenido no esta colapsado
    if (!colapsado) {
        switch (id) {
            case 'personal_mayoreo':
                obtenerPersonal('Mayoreo');
                break;
            case 'personal_maniobras':
                obtenerPersonal('Maniobras');
                break;
            case 'personal_super':
                obtenerPersonal('Super');
                break;
        }
    }
}

function recargarContenido(){
    obtenerNotasSinCargar();
    obtenerNotasSinAsignar();
    consultarNotasAsignadas();
    $('#personal_mayoreo').hasClass('show') ? obtenerPersonal('Mayoreo') : '';
    $('#personal_maniobras').hasClass('show') ? obtenerPersonal('Maniobras') : '';
    $('#personal_super').hasClass('show') ? obtenerPersonal('Super') : '';
}

function evitarDobleClic(btn) {
    // Desactivar el botón
    btn.disabled = true;

    // Habilitar el botón después de un tiempo
    setTimeout(function() {
        btn.disabled = false;
    }, 850);
}

function obtenerNotasGalloCorona() {
    tableNotasGalloCorona = $('#bodyTableNotasGalloCorona');
    $.ajax({
        type: 'POST',
        url: '../../app/Controlador/NotasControlador.php?operador=consultar_notas_gallo_corona',
        success: function(response) {
            tableNotasGalloCorona.empty();
            if (response.trim() === 'error') {
                toastr.error("No se pueden cargar los datos");
            } else if(response.trim() === 'no-data') {
                toastr.info('No hay datos para mostrar  ', 'Notas Gallo Corona', {
                    timeOut: 1500, 
                    extendedTimeOut: 0,
                    preventDuplicates: true,
                });
            } else {
                $.each(JSON.parse(response), function(id, nota){
                    tableNotasGalloCorona.append(
                        '<tr>'+
                            '<td class="nombreCliente">'+nota.NUMERO+'</td>'+
                            '<td class="nombreCliente">'+nota.NOTA+'</td>'+
                            '<td>'+nota.FECHA+'</td>'+
                            '<td>'+nota.TOTAL+'</td>'+
                            '<td><button type="button" class="btn btn-primary" onclick="cargarNota('+nota.NUMERO+','+nota.TOTAL+',\''+nota.NOTA+'\','+nota.PAG+','+nota.VENDEDORID+',\''+nota.SERIE+'\','+nota.DOCID+'); evitarDobleClic(this);">Cargar</button></td>'+
                        '</tr>'
                    );
                });
            } 
        }
    });
}

function obtenerPersonal(departamento, busqueda = '') {
    var tablePersonal = $('#bodyTablePersonal' + departamento);
    if (busqueda == '') {
        data = {
            'PostDepartamento' : departamento
        };
        $.ajax({
            data : data,
            type: 'POST',
            url: '../../app/Controlador/NotasControlador.php?operador=consultar_personal',
            success: function (response) {
                $('#inputBusquedaPersonal' + departamento).val('');
                
                tablePersonal.empty();
                procesarRespuesta(response, tablePersonal);
            }
        });
    } else {
        var data = {
            'busqueda' : busqueda,
            'PostDepartamento' : departamento
        };
        $.ajax({
            data : data,
            type : 'POST',
            url: '../../app/Controlador/NotasControlador.php?operador=busqueda_personal',
            success : function (response) {
                tablePersonal.empty();
                procesarRespuesta(response, tablePersonal);
            }
        });
    }
}

function procesarRespuesta(response, tablePersonal) {
    
    if (response.trim() == 'error') {
        toastr.error("Error al cargar los datos", "Personal");
    } else if (response.trim() == 'no-data') {
        //toastr.info("No hay datos para mostrar", "Notas sin cargar");
    } else {
        
        var classTr = '';
        $.each(JSON.parse(response), function(id, personal) {
            classTr = personal.disponibilidad == 'Libre' ? 'personal-libre' : 'personal-surtiendo';
            tablePersonal.append(
                '<tr class="'+classTr+'">'+
                '<td>'+personal.Nlista+'</td>'+
                '<td style="cursor:pointer;" onclick="modalProductividadSurtidor('+personal.Nlista+', \''+personal.nombre+'\', \''+personal.departamentoname+'\')">'+personal.nombre+'</td>'+
                '<td>'+personal.departamentoname+'</td>'+
                '<td>'+personal.disponibilidad+'</td>'+
                '</tr>'
            );
        });
    }
}

$(document).ready(function() {
    $('#inputBusquedaNotas').on('input', function(){
        busqueda = $('#inputBusquedaNotas').val();
        obtenerNotasSinAsignar(busqueda);
    });
});

$(document).ready(function() {
    $('#inputBusquedaPersonalMayoreo').on('input', function(){
        handleInputSearch(this, 'Mayoreo');
    });

    $('#inputBusquedaPersonalManiobras').on('input', function(){
        handleInputSearch(this, 'Maniobras');
    });

    $('#inputBusquedaPersonalSuper').on('input', function(){
        handleInputSearch(this, 'Super');
    });
});

function handleInputSearch(busquedaInput, tipoPersonal) {
    busqueda = $(busquedaInput).val();
    obtenerPersonal(tipoPersonal, busqueda);
}

// Agrega un evento de cambio
fechaInput.addEventListener('change', function() {
    obtenerNotasNoSurtir();
});

function modalProductividadSurtidor(nlista, nombreEmpleado, departamentoEmpleado) {
    $('#formulario_consultar_notas_empleados').trigger('reset');
    $('#modal_productividad_surtidor').modal('show');
    $('#nlista_notas_surtidor').val(nlista);
    $('#nombre_notas_surtidor').val(nombreEmpleado);
    $('#departamento_notas_surtidor').val(departamentoEmpleado);
    consultarNotasSurtidor();
}

function consultarNotasSurtidor() {
    tableNotasSurtidores = $('#bodyTableNotasSurtidor');
    nlista = $('#nlista_notas_surtidor').val();
    fechaInicio = $('#fecha_inicio_notas_surtidor').val();
    fechaFin = $('#fecha_fin_notas_surtidor').val();
    data = {
        'nlista' : nlista ,
        'fechaInicio' : fechaInicio,
        'fechaFin' : fechaFin
    };
    $.ajax({
        data : data,
        type : 'POST',
        url : '../../app/Controlador/NotasControlador.php?operador=consultar_notas_surtidor',
        success : function(response) {
            tableNotasSurtidores.empty();
            $.each(JSON.parse(response), function(id, nota) {
                tableNotasSurtidores.append(
                    '<tr>'+
                    '<td>'+nota.folio+'</td>'+
                    '<td>'+nota.fecha+'</td>'+
                    '<td>'+nota.cliente+'</td>'+
                    '<td>'+nota.paginas+'</td>'+
                    '</tr>'
                );
            });
        }
    });
}

function modalReporteNotasGeneral () {
    $('#formulario_consultar_notas_general').trigger('reset');
    $('#modal_productividad_notas_general').modal('show');
    consultarNotasGenerales();
}

function consultarNotasGenerales() {
    tableNotasGeneral = $('#bodyTableNotasGeneral');
    fechaInicio = $('#fecha_inicio_notas_general').val();
    fechaFin = $('#fecha_fin_notas_general').val();
    data = {
        'fechaInicio' : fechaInicio,
        'fechaFin' : fechaFin
    };
    $.ajax({
        data : data,
        type : 'POST',
        url : '../../app/Controlador/NotasControlador.php?operador=consultar_notas_general',
        success : function(response) {

            tableNotasGeneral.empty();
            $.each(JSON.parse(response), function(id, nota) {
                tableNotasGeneral.append(
                    '<tr>'+
                    '<td>'+nota.folio+'</td>'+
                    '<td>'+nota.nlista+'</td>'+
                    '<td>'+nota.surtidor+'</td>'+
                    '<td>'+nota.fecha+'</td>'+
                    '<td>'+nota.cliente+'</td>'+
                    '<td>'+nota.paginas+'</td>'+
                    '</tr>'
                );
            });
        }
    });
}