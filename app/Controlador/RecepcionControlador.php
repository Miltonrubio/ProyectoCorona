<?php
session_start();
$tipoUsuario = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : null;
require "../Modelo/Recepcion.php";

$bd = new Recepcion();;

switch ($_REQUEST["operador"]) {
    case "Consultar_Estado_nota": {
            $busqueda = $_POST['buscar'];
            $cuerpo = '
        <div class="card">
          <div class="card-body">
              <h4 class="card-title">NO SE ENCONTRÓ LA NOTA</h4>
              <p class="card-text">VERIFICAR EL FOLIO O PREGUNTAR EN EL MÓDULO DE NOTAS POR QUÉ NO LA REGISTRARON</p>
          </div>
        </div>
        ';
            $miniencabezado = '<div class="row g-3"> ';
            $minipie = '</div>';

            $datos = $bd->buscarnota($busqueda);
            if (!empty($datos)) {
                $cuerpo = '';
                if ($datos[0]['estado2'] == 'entregado') {
                    $cuerpo = $cuerpo.'
                    <div class="col-md-12 ">
                    <div class="card" style=" border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h4 class="card-title mb-4" style="color: #007bff;">Estado de la nota</h4>
                                    <p class="card-text lead" style="color: #495057;">Nota entregada</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h4 class="card-title mb-4" style="color: #28a745;">Hora de entrega de la nota</h4>
                                    <p class="card-text lead" style="color: #495057;">'.$datos[0]['horacliente'].'</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                ';
                }
                
                for ($i = 0; $i < count($datos); $i++) {
                    $cuerpo = $cuerpo . '
             <div class="col-12 col-xl-4 col-md-6">
             <div class="card h-100">
             <div class="card-body">
              
                <div class="bg-label-primary text-center mb-3 pt-2 rounded-3">
                  <img class="img-fluid w-px-150" src="../../assets/img/illustrations/illustration-2.png" alt="Card girl image">
                </div>
      
                <h5 class="mb-2 pb-1">' . $datos[$i]['surtidor'] . '</h5>
                <p>CLIENTE:' . $datos[$i]['cliente'] . '<br/> HORA INICIO:' . $datos[$i]['hora'] . ' </p>
                <labe>PAGINAS</label>
  ' . vistapaginas($datos[$i]['paginas']) . '
  <br/>
                
                <div class="row mb-3 g-3">
                  <div class="col-6">
                      <div class="d-flex">
                          <div class="avatar flex-shrink-0 me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i class="mdi mdi-calendar-blank mdi-24px"></i></span>
                          </div>
                          <div>
                            <h6 class="mb-0 text-nowrap">' . $datos[$i]['fecha'] . '</h6>
                            <small>Fecha</small>
                          </div>
                      </div>
                  </div>
                  
                  <div class="col-6">
                    <div class="d-flex">
                      <div class="avatar flex-shrink-0 me-2">
                        <span class="avatar-initial rounded bg-label-primary"><i class="mdi mdi-timer-outline mdi-24px"></i></span>
                      </div>
                      <div>
                        <h6 class="mb-0 text-nowrap">' . tiemposurtido($datos[$i]['hora'], $datos[$i]['horaentrega'])["cadenaFormateada"] . '</h6>
                        <small>Duracion</small>
                      </div>
                    </div>
                  </div>
                  ' . tipoEstado($datos[$i]['estado']) . '
                </div>
              </div>
           </div></div>';
                }
            }
            //id_serv_unidad,marca,modelo,anio,placas,motor,foto
            echo $miniencabezado . $cuerpo . $minipie;
        };
        break;

    case 'obtener_notas':
        $notas = $bd->obtenerNotas();
        if ($notas !== false) {
            if (count($notas) > 0) {
                $data = array(
                    'tipoUsuario' => $tipoUsuario,
                    'notas' => $notas,

                );
                $response = json_encode($data);
            } else {
                $response = 'no-data';
            }
        } else {
            $response = 'error';
        }
        echo $response;
        break;

    case 'busqueda_nota':
        $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
        $notas = $bd->busquedaNota($busqueda);
        if ($notas !== false) {
            if (count($notas) > 0) {
                $data = array(
                    'tipoUsuario' => $tipoUsuario,
                    'notas' => $notas,

                );
                $response = json_encode($data);
            } else {
                $response = 'no-data';
            }
        } else {
            $response = 'error';
        }
        echo $response;
        break;

    case 'entregar_nota':
        $iddoc = isset($_POST['iddoc']) ? $_POST['iddoc'] : '';
        if (!empty($iddoc)) {
            $response = $bd->entregarNota($iddoc) ? 'success' : 'error';
        } else {
            $response = 'required';
        }
        echo $response;
        break;
}


function vistapaginas($paginas)
{
    $encabezado = '<div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">';
    $pie = '</div>';
    $cuerpo = '';
    $porciones = array();
    $porciones = explode(",", $paginas);
    $tamano = count($porciones);
    for ($i = 0; $i < $tamano; $i++) {
        if (intval($porciones[$i]) != 0) {
            $cuerpo = $cuerpo . ' <div class="avatar me-sm-4"><span class="avatar-initial rounded bg-label-secondary">' . intval($porciones[$i]) . '</span></div>';
        }
    }
    return $encabezado . $cuerpo . $pie;
}

function tiemposurtido($horainicio, $horafinal)
{
    if ($horafinal == '00:00:00') {
        $fecha1 = new DateTime('2023-01-01 ' . $horainicio);  // fecha inicial
        $fecha2 = new DateTime('2023-01-01 ' . date('H:i:s'));  // fecha de cierre actual
    } else {
        $fecha1 = new DateTime('2023-01-01 ' . $horainicio);  // fecha inicial
        $fecha2 = new DateTime('2023-01-01 ' . $horafinal);  // fecha de cierre proporcionada
    }

    $intervalo = $fecha1->diff($fecha2);
    $minutosTotales = $intervalo->i + $intervalo->h * 60; // Obtén la diferencia de tiempo total en minutos

    $cadenaFormateada = '';

    if ($intervalo->h > 0) {
        $cadenaFormateada .= $intervalo->h == 1 ? $intervalo->h . ' ' . ' hora <br>' : $intervalo->h . ' ' . ' horas <br>';
    }

    if ($intervalo->i > 0) {
        $cadenaFormateada .= $intervalo->i == 1 ? $intervalo->i . ' ' . ' minuto' : $intervalo->i . ' ' . ' minutos';
    }

    return array('minutos' => $minutosTotales, 'cadenaFormateada' => $cadenaFormateada);
}

function tipoEstado($estado)
{
    $colorestado = '';
    switch ($estado) {
        case 'surtiendo': {
                $colorestado = '<a class="btn btn-success w-100 waves-effect waves-light">' . $estado . '</a>';
            };
            break;
        case 'ENTREGADO': {
                $colorestado = '<a class="btn btn-info w-100 waves-effect waves-light">' . $estado . '</a>';
            };
            break;
    }
    return $colorestado;
}
