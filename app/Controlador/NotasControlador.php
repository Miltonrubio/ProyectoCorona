<?php
session_start();
require "../Modelo/Notas.php";

$notas = new Notas();

switch ($_REQUEST["operador"]) {

    case "Consultar_NotasDia": {
        $cuerpo='';
        $miniencabezado=' <div class="col-12">
        <div class="card">
          <div style="max-height: 60vh;" class="overflow-auto">
            <table class="table">
              <thead class="table-light">
                <tr class="text-center">
                  <th class="text-truncate">Surtidor</th>
                  <th class="text-truncate">Nota</th>
                  <th class="text-truncate">Pagina</th>
                  <th class="text-truncate">Tiempo</th>
                  <th class="text-truncate hidden-xl">Estado</th>
                </tr>
              </thead>
              <tbody class="text-center">';
        $minipie='   
        </tbody>
     </table>
   </div>
 </div>
</div>';
        
    $datos = $notas->ConsultarNotasdelDia();
    if (!empty($datos)) {
      $colorfila="table-default";
      $colorboton="btn-primary";

        for ($i = 0; $i < count($datos); $i++) {
          $tiempoArray = tiemposurtido($datos[$i]['hora'],$datos[$i]['horaentrega']);
          if($datos[$i]['estado']=="ENTREGADO"){
            $colorfila="table-success";
            $colorboton="btn-success";

          }else{
            if ($tiempoArray['minutos'] > 20) {
              $colorboton="btn-danger";
            }else {
              $colorboton="btn-primary";
            }
            $colorfila="table-default";
            
          }
             $cuerpo=$cuerpo.'
             <tr class="'.$colorfila.'">
             <td>
               <div class="d-flex align-items-center">
                 <div class="avatar avatar-sm me-3">
                   <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                 </div>
                 <div class="me-3">
                 <p style="font: size 15px; font-weight: bold;
                 ">'.$datos[$i]['nlista'].'</p>
                 </div>
                 <div>
                   <h6 class="mb-0 text-truncate">'.substr($datos[$i]['surtidor'], 0, 15).'...</h6>
                   <small class="text-truncate">'.$datos[$i]['fecha'].' '.$datos[$i]['hora'].'</small>
                   <p style="font-size: 10px; margin-bottom:0px;">'.substr($datos[$i]['cliente'], 0, 10).'...</p>
                 </div>
               </div>
             </td>
             <td class="text-truncate">'.$datos[$i]['folio'].'</td>
             <td class="text-truncate">'.$datos[$i]['paginas'].'</td>
             <td class="text-truncate">
             <div class="card-action-element">
          <button style="width:100%;" class="btn '.$colorboton.' waves-effect waves-light" type="button" data-bs-toggle="modal" data-bs-target="#addNewCCModal">
          <i class="mdi mdi-clock-outline me-1"></i>
        
             '.$tiempoArray["cadenaFormateada"].'</button></div></td>
             <td class="hidden-xl"><span class="badge bg-label-warning rounded-pill">'.$datos[$i]['estado'].'</span></td>
           </tr>';
        }
    }
    //id_serv_unidad,marca,modelo,anio,placas,motor,foto
    echo $miniencabezado.$cuerpo.$minipie;

    };break;
    case "Consultar_Top10": {
        $cuerpo='';
        $miniencabezado=' <div class="col-12">
        <div class="card">
          <div class="table-responsive">
            <table class="table">
              
              ';
        $minipie='   
        
     </table>
   </div>
 </div>
</div>';
        
    $datos = $notas-> ProductividadNotas();
    if (!empty($datos)) {
        for ($i = 0; $i < count($datos); $i++) {
             $cuerpo=$cuerpo.'
             <tr>
             <td>
               <div class="d-flex align-items-center">
                 <div class="avatar avatar-sm me-3">
                   <img src="../../assets/img/illustrations/trophy.png" alt="Avatar" class="rounded-circle" />
                 </div>
                 <div>
                   <h6 class="mb-0 text-truncate">'.$datos[$i]['surtidor'].'</h6>
                   <small class="text-truncate">'.$datos[$i]['notassurtidas'].' NOTAS SURTIDAS </small>
                 </div>
               </div>
             </td>
             <td class="text-truncate">'.$datos[$i]['notassurtidas'].'</td>
           </tr>';
        }
    }
    //id_serv_unidad,marca,modelo,anio,placas,motor,foto
    echo $miniencabezado.$cuerpo.$minipie;

    };break;

    case "Consultar_TotalNotasDia": {
      $totaldia=0;
      $totalasignado = 0;
      $totalentregado = 0;

      $totaldia = $notas-> TotalNotasDia();
      $totalasignado = $notas-> TotalNotasDiaAsignadas();
      $totalentregado = $notas-> TotalNotasDiaFinalizadas();

        $cuerpo='
        <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-1">Contador Notas 📋</h4>
          <p class="pb-0"></p>
          NOTAS DEL DIA:<h4 class="text-primary mb-1">'.$totaldia.'</h4>
          NOTAS ASIGNADAS:<h4 class="text-primary mb-1">'.$totalasignado.'</h4>
          NOTAS SURTIDAS:<h4 class="text-primary mb-1">'.$totalentregado.'</h4>
        </div>
      </div>';
       
        
   

    
    //id_serv_unidad,marca,modelo,anio,placas,motor,foto
    echo $cuerpo;

    };break;

    case "Consultar_Estado_nota":{
      $busqueda=$_POST['buscar'];
      $cuerpo='
      <div class="card">
        <div class="card-body">
            <h4 class="card-title">NO SE ENCONTRÓ LA NOTA</h4>
            <p class="card-text">VERIFICAR EL FOLIO O PREGUNTAR EN EL MÓDULO DE NOTAS POR QUÉ NO LA REGISTRARON</p>
        </div>
      </div>
      ';
      $miniencabezado='<div class="row mb-4 g-4"> ';
      $minipie='</div>';
      
  $datos = $notas->buscarnota($busqueda);
  if (!empty($datos)) {
    $cuerpo='';
      for ($i = 0; $i < count($datos); $i++) {
           $cuerpo=$cuerpo.'
           <div class="col-12 col-xl-4 col-md-6">
           <div class="card h-100">
           <div class="card-body">
            
              <div class="bg-label-primary text-center mb-3 pt-2 rounded-3">
                <img class="img-fluid w-px-150" src="../../assets/img/illustrations/illustration-2.png" alt="Card girl image">
              </div>
    
              <h5 class="mb-2 pb-1">'.$datos[$i]['surtidor'].'</h5>
              <p>CLIENTE:'.$datos[$i]['cliente'].'<br/> HORA INICIO:'.$datos[$i]['hora'].' </p>
              <labe>PAGINAS</label>
'.vistapaginas($datos[$i]['paginas']).'
<br/>
              
              <div class="row mb-3 g-3">
                <div class="col-6">
                    <div class="d-flex">
                        <div class="avatar flex-shrink-0 me-2">
                          <span class="avatar-initial rounded bg-label-primary"><i class="mdi mdi-calendar-blank mdi-24px"></i></span>
                        </div>
                        <div>
                          <h6 class="mb-0 text-nowrap">'.$datos[$i]['fecha'].'</h6>
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
                      <h6 class="mb-0 text-nowrap">'.tiemposurtido($datos[$i]['hora'],$datos[$i]['horaentrega'])["cadenaFormateada"].'</h6>
                      <small>Duracion</small>
                    </div>
                  </div>
                </div>
                '.tipoEstado($datos[$i]['estado']).'
              </div>
            </div>
         </div></div>';
      }
  }
  //id_serv_unidad,marca,modelo,anio,placas,motor,foto
  echo $miniencabezado.$cuerpo.$minipie;

    };break;
    
    case 'consultar_notas_sin_cargar':
      $notasSinCargar = $notas->notasSinCargar();
      if ($notasSinCargar !== false) {
        if (empty($notasSinCargar)) {
          $response = 'no-data';
        }else {
          $response = $notasSinCargar;
        }
      }else {
        $response = 'error';
      }
      echo $response;
      break;

    case 'cargar_nota':
      $folio = isset($_POST['numero']) ? $_POST['numero'] : '';
      $importe = isset($_POST['importe']) ? $_POST['importe'] : '';
      $cliente = isset($_POST['cliente']) ? $_POST['cliente'] : '';
      $pagina = isset($_POST['pag']) ? $_POST['pag'] : '';
      $vendedor = isset($_POST['vendedorID']) ? $_POST['vendedorID'] : '';
      $serie = isset($_POST['serie']) ? $_POST['serie'] : '';
      $idDocumento = isset($_POST['idDoc']) ? $_POST['idDoc'] : '';

      if (!empty($folio) && !empty($importe) && !empty($pagina) && !empty($vendedor) && !empty($serie) && !empty($idDocumento)) {
        try {
          $notas->beginTransaction();
          //obtenedmos las partidas de la nota
          $infoPartida = $notas->infoCargarNota($idDocumento);
          $jsonNotas = json_decode($infoPartida);
          if (!empty($jsonNotas)) {
            
            //insertamos cada una de las partidas en notasinicio
            foreach($jsonNotas as $nota){
              $clave = $nota->DESARTID;
              $cantidad = $nota->DESCANTIDAD;
              $unidad = $nota->UNIDAD;
              $articulo = $nota->DESCRIPCIO;
              $ubicacion = $nota->UBICACION;
              $notas->cargarNota($folio, $clave, $cantidad, $unidad, $articulo, $importe, $ubicacion, $cliente, $pagina, $vendedor, $serie, $idDocumento);
            }

            for ($i=1; $i <= $pagina; $i++) { 
              $notas->insertarHoja($i, $idDocumento);
            }
            $notas->cambiarEstadoNotaApi($idDocumento);
            $notas->commit();
            
            $response = 'success';
          }else {
            $response = 'vacio';
          }
        } catch (\Throwable $th) {
          $notas->rollBack();
          $response = 'error';
        }
      }else {
        $response = 'error';
      }
      echo $response;
      break;

    case 'consultar_notas_sin_asignar':
      $notasSinAsignar = $notas->notasSinAsignar();
      if ($notasSinAsignar !== false) {
        if (count($notasSinAsignar) > 0) {
          echo json_encode($notasSinAsignar);
        }else {
          echo 'no-data';
        }
      }else {
        echo 'error';
      }

      break;

    case 'consultar_paginas_notas':
      $idDoc = isset($_POST['idDoc']) ? $_POST['idDoc'] : '';
      if (!empty($idDoc)) {
        $response = $notas->consultasPaginas($idDoc);
        echo json_encode($response);
      }else {
        echo 'error';
      }
      
      break;

      case 'asignar_paginas_empleado':
        $idDoc = isset($_POST['idDoc']) ? $_POST['idDoc'] : '';
        $nlista = isset($_POST['nlista']) ? $_POST['nlista'] : '';
        $numPages = isset($_POST['numPages']) ? $_POST['numPages'] : '';
        $estadoNota = isset($_POST['estadoNota']) ? $_POST['estadoNota'] : '';
        $paginas = isset($_POST['paginas']) ? $_POST['paginas'] : [];

        if (!empty($idDoc) && !empty($nlista) && (!empty($paginas) || $numPages <= 2)) {
          try {
            // Inicia la transacción
            $notas->beginTransaction();
    
            // Consultar los datos de la nota
            $datosNota = $notas->consultarInfoNotaInicio($idDoc);
            $infoSurtidor = json_decode($notas->consultarInfoEmpleado($nlista), true);
    
            if (!empty($datosNota)) {
                // Asignar páginas a la nota
                if ($numPages > 2) {
                  // Se asignaron hojas mediante la selección
                  foreach ($paginas as $pagina) {
                      $notas->asignarPagina($pagina, $nlista);
                  }
                  $numerosPaginas = array_map([$notas, 'obtenerNumeroPaginaPorID'], $paginas);
                  $stringPages = implode(',', $numerosPaginas);
                  
                
                } else {
                    if ($estadoNota == 'SURTIENDO') {
                      
                      echo 'asignada';
                      return;
                    }else {
                      // No hay selección, se asignan todas las disponibles
                      $notas->asignasTodasPaginas($nlista, $idDoc);
                      $numerosTotal = range(1, $numPages);
                      $stringPages = implode(',', $numerosTotal);
                    }
                }
                
                // Agregar información de la nota a la tabla de notas_asignadas
                $notas->agregarNotaAsignada($datosNota['FOLIO'], $nlista, $infoSurtidor[0]['nombre'], $datosNota['CLIENTE'], $stringPages, $datosNota['IDDOCUMENTO']);
                // Cambiar estado de la nota en su tabla original a "cargada"
                $notas->cambiarEstadoNotaAsignada($nlista, $idDoc);
                // Confirma la transacción
                $notas->commit();
                $response = 'success';
            } else {
                $response = 'error';
            }
          } catch (Exception $e) {
              // Revierte la transacción en caso de error
              $notas->rollBack();
              $response = 'error';
          }
        }else {
          $response = 'required';
        }
        echo $response;
        break;
      case 'cambiar_estatus_pendiente':
        $idDoc = isset($_POST['input_idDoc_Pendiente']) ? $_POST['input_idDoc_Pendiente'] : '';
        if (!empty($idDoc)) {
          $result = $notas->cambiarEstadoXNoSurtir($idDoc);
          if ($result !== false) {
            $response = 'success';
          }else {
            $response = 'error';
          }
        }else {
          $response = 'required';
        }
        echo $response;
        break;

      case 'consultar_notas_pagos_pendientes':
        $notasPagosPendientes = $notas->notasPagosPendientes();
        if ($notasPagosPendientes !== false) {
          if (empty($notasPagosPendientes)) {
            $response = 'no-data';
          } else {
            $response = $notasPagosPendientes;
          }
        }else {
          $response = 'error';
        }
        echo $response;
        break;

      case 'consultar_notas_no_surtir':
        $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
        $notasNoSurtir = $notas->notasNoSurtir($fecha);
        if ($notasNoSurtir !== false) {
          if (empty($notasNoSurtir)) {
            $response = 'no-data';
          } else {
            $response = $notasNoSurtir;
          }
        }else {
          $response = 'error';
        }
        echo $response;
        break;
      
      case 'consultar_notas_gallo_corona':
        $notasGalloCorona = $notas->consultasNotasGalloCorona();
        if ($notasGalloCorona !== false) {
          if (empty($notasGalloCorona)) {
            $response = 'no-data';
          }else {
            $response = $notasGalloCorona;
          }
        }else {
          $response = 'error';
        }
        echo $response;
        break;

      case 'consultar_personal':
        $PostDepartarmento = isset($_POST['PostDepartamento']) ? $_POST['PostDepartamento'] : '';
        $Departarmento = '';

        switch ($PostDepartarmento) {
          case 'Mayoreo':
            $Departarmento = 'Mayoreo';
            break;
          case 'Maniobras':
            $Departarmento = 'Maniobras';
            break;
          case 'Super':
            $Departarmento = 'SUPER';
            break;
        }
        $empleados = $notas->consultasPersonal();
        if ($empleados !== false) {
          if (empty($empleados)) {
            $response = 'no-data';
          }else {
            $mayoreo = array();

            foreach (json_decode($empleados) as $empleado) {
              $disponibilidad = $notas->obtenerDisponibilidadPersonal($empleado->Nlista); // Ajusta según tu lógica de base de datos

              // Agregar información de disponibilidad al array
              $empleado->disponibilidad = $disponibilidad;
              if ($empleado->departamentoname === $Departarmento) {
                $mayoreo[] = $empleado;
              }
            }

            $response = json_encode($mayoreo);
          }
        } else {
          $response = 'error';
        }
        echo $response;
        break;

      case 'busqueda_notas_sin_asignar':
        $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
        $notasSinAsignar = $notas->notasSinAsignarBusqueda($busqueda);
        if ($notasSinAsignar !== false) {
          if (count($notasSinAsignar) > 0) {
            echo json_encode($notasSinAsignar);
          }else {
            echo 'no-data';
          }
        }else {
          echo 'error';
        }
        break;

      case 'busqueda_personal':
        $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
        $PostDepartarmento = isset($_POST['PostDepartamento']) ? $_POST['PostDepartamento'] : '';
        $Departarmento = '';

        switch ($PostDepartarmento) {
          case 'Mayoreo':
            $Departarmento = 'Mayoreo';
            break;
          case 'Maniobras':
            $Departarmento = 'Maniobras';
            break;
          case 'Super':
            $Departarmento = 'SUPER';
            break;
        }

        $empleados = $notas->consultasPersonal();
        if ($empleados !== false) {
          if (empty($empleados)) {
            $response = 'no-data';
          }else {
            $empleadosBusqueda = array();
            foreach (json_decode($empleados) as $empleado) {
              $disponibilidad = $notas->obtenerDisponibilidadPersonal($empleado->Nlista); // Ajusta según tu lógica de base de datos

              // Agregar información de disponibilidad al array
              $empleado->disponibilidad = $disponibilidad;
              if ($empleado->Nlista == $busqueda & $empleado->departamentoname === $Departarmento) {
                $empleadosBusqueda[] = $empleado;
              } 
            }
            $response = json_encode($empleadosBusqueda);
          }
        } else {
          $response = 'error';
        }
        echo $response;
        break;

      case 'consultar_notas_surtidor':
        $nlista = isset($_POST['nlista']) ? $_POST['nlista'] : '';
        $fechaInicio = !empty($_POST['fechaInicio']) ? $_POST['fechaInicio'] : date("Y-m-d");
        $fechaFin = !empty($_POST['fechaFin']) ? $_POST['fechaFin'] : date("Y-m-d");
        if (!empty($nlista)) {
          $notasSurtidor = $notas->consultarNotasSurtidor($nlista, $fechaInicio, $fechaFin);
          $response = json_encode($notasSurtidor);
        } else {
          $response = 'required';
        }
        echo $response;
        break;

      case 'consultar_notas_general':
        $fechaInicio = !empty($_POST['fechaInicio']) ? $_POST['fechaInicio'] : date("Y-m-d");
        $fechaFin = !empty($_POST['fechaFin']) ? $_POST['fechaFin'] : date("Y-m-d");
        $notasGenerales = $notas->reporteNotasGeneral($fechaInicio, $fechaFin);
        $response = json_encode($notasGenerales);
        echo $response;
        break;

      case 'inicio_sesion':
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        if (!empty($phone) && !empty($password)) {
          
          // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

          // echo "Contraseña hasheada: " . $hashedPassword;
          $passHash = $notas->encryption($password);
          $user = $notas->login($phone, $passHash);
          if ($user === 'not-found') {
            $response = 'not-found';
          }else if ($user !== false) {
            
            $_SESSION['ID_usuario'] = $user['ID_usuario']; 
            $_SESSION['nombre'] =  $user['nombre']; 
            $_SESSION['telefono'] =  $user['telefono']; 
            $_SESSION['tipo'] =  $user['permisos']; 
            $_SESSION['empresa'] =  $user['empresa']; 
            $_SESSION['email'] =  $user['email']; 
            
            $response = $user['tipo'];
          }else {
            $response = 'error';
          }
        }else {
          $response = 'required';
        }
        echo $response;
        break;

      case 'cerrar_sesion':
         // Desconfigurar todas las variables de sesión
        $_SESSION = array();

        // Borrar la cookie de sesión si está configurada
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión
        session_destroy();
        header("location:../../");
        break;
}

// function tiemposurtido($horainicio,$horafinal){
//   if($horafinal=='00:00:00'){
//     $fecha1 = new DateTime('2023-01-01 '.$horainicio);//fecha inicial
//     $fecha2 = new DateTime('2023-01-01 '.date('h:i:s'));//fecha de cierre  
//   }else{
//     $fecha1 = new DateTime('2023-01-01 '.$horainicio);//fecha inicial
//     $fecha2 = new DateTime('2023-01-01 '.$horafinal);//fecha de cierre  
//   }
  
//   $intervalo = $fecha1->diff($fecha2);
//   $horas=intval($intervalo->format('%H'));
//   if($horas>0){
//     if($horas==1){
//       return $horas.' '.$intervalo->format(' hora <br/> %i minutos');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos
//     }else{
//       return $horas.' '.$intervalo->format('horas <br/> %i minutos');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos
//     }
    
//   }else{
//     return $intervalo->format('%i minutos');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos
//   }
  
// }

function tiemposurtido($horainicio, $horafinal){
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
    $cadenaFormateada .= $intervalo->h == 1 ? $intervalo->h.' '.' hora <br>' : $intervalo->h.' '.' horas <br>';
  }

  if ($intervalo->i >0) {
    $cadenaFormateada .= $intervalo->i ==1 ? $intervalo->i.' '.' minuto' : $intervalo->i.' '.' minutos';
  }

  return array('minutos' => $minutosTotales, 'cadenaFormateada' => $cadenaFormateada);
}

function vistapaginas($paginas){
  $encabezado='<div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">';
  $pie='</div>';
  $cuerpo='';
  $porciones=array();
  $porciones = explode(",", $paginas);
  $tamano= count($porciones);
    for($i=0;$i<$tamano;$i++){
      if(intval($porciones[$i])!=0){
        $cuerpo=$cuerpo.' <div class="avatar me-sm-4"><span class="avatar-initial rounded bg-label-secondary">'.intval($porciones[$i]) .'</span></div>';
       }
    }
  return $encabezado.$cuerpo.$pie;
}

function tipoEstado($estado){
  $colorestado='';
switch($estado){
  case 'surtiendo':{$colorestado='<a class="btn btn-success w-100 waves-effect waves-light">'.$estado.'</a>';};break;
  case 'ENTREGADO':{$colorestado='<a class="btn btn-info w-100 waves-effect waves-light">'.$estado.'</a>';};break;
}
return $colorestado;
}


    