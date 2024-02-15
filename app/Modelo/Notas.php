<?php
define('METHOD','AES-256-CBC');
define('SECRET_KEY','$CARLOS@2016');
define('SECRET_IV','101712');
require_once "../../config/Conexion.php";

class Notas
{

    public $cnx;
    private $modelo2;

    function __construct()
    {
        $this->cnx = Conexion::ConectarDB();
    }

     // Método para comenzar una transacción
    public function beginTransaction()
    {
        $this->cnx->beginTransaction();
    }

     // Método para confirmar la transacción
    public function commit()
    {
        $this->cnx->commit();
    }

     // Método para revertir la transacción
    public function rollBack()
    {
        $this->cnx->rollBack();
    }

    function ConsultarNotasdelDia(){
        $query = "SELECT folio,fecha,hora,ADDTIME(hora,-Curtime()) AS tiempo,nlista,surtidor,cliente,paginas,estado,horaentrega,iddocumento FROM notas_asignadas where fecha=curdate() order by hora desc;";
        $consulta = $this->cnx->prepare($query);
        $consulta->execute();
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $this->modelo2[] = $filas;
        }
        return $this->modelo2;
    }

    function ProductividadNotas(){
        $query = "SELECT surtidor,nlista,count(idnotas) as notassurtidas FROM notas.notas_asignadas where fecha=curdate() group by nlista order by count(folio) desc limit 10;";
        $consulta = $this->cnx->prepare($query);
        $consulta->execute();
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $this->modelo2[] = $filas;
        }
        return $this->modelo2;
    }

    function TotalNotasDia(){
        $resultado=0;
        $query = "SELECT COUNT(DISTINCT folio)  as notasdia FROM surtidosinicio where fecha=curdate() group by fecha;";
        $consulta = $this->cnx->prepare($query);
        $consulta->execute();
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
             $resultado= $filas['notasdia'];
        }
        return $resultado;
    }

    function TotalNotasDiaAsignadas(){
        $resultado=0;
        $query = "SELECT COUNT(DISTINCT folio) as notasasignadas FROM notas_asignadas where fecha=curdate() group by fecha;";
        $consulta = $this->cnx->prepare($query);
        $consulta->execute();
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $resultado= $filas['notasasignadas'];
        }
        return $resultado;
    }

    function TotalNotasDiaFinalizadas(){
        $resultado=0;
        $query = "SELECT COUNT(DISTINCT folio) as notasasignadas FROM notas_asignadas where fecha=curdate() and estado='entregado' group by fecha;";
        $consulta = $this->cnx->prepare($query);
        $consulta->execute();
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $resultado= $filas['notasasignadas'];
        }
        return $resultado;
    }

    function buscarnota($idnota){
        $query = "SELECT idnotas,folio,fecha,hora,nlista,surtidor,cliente,paginas,horaentrega,estado, estado2, horacliente  FROM notas_asignadas WHERE folio=:idNota or iddocumento=:idNota;";
        $consulta = $this->cnx->prepare($query);
        $consulta->bindParam(':idNota', $idnota);
        $consulta->execute();
        while ($filas = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $this->modelo2[] = $filas;
        }
        return $this->modelo2;
    }

    function notasSinCargar(){
        $data = array(
            'opcion' => 1,
        );
        
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, URLAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Verificar si hay errores
        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }
        
        // Cerrar la sesión cURL
        curl_close($ch);
    
        // Manejar la respuesta de la API (puede variar según el formato de respuesta de la API)
        if ($response === '204 NO CONTENT') {
            return [];
            
        } else {
            return $response;
        }
    }

    function infoCargarNota($idDoc){
        $data = array(
            'opcion' => 6,
            'iddocferrum' => $idDoc
        );
        
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, URLAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Verificar si hay errores
        if (curl_errno($ch)) {
            return false;
        }
        
        // Cerrar la sesión cURL
        curl_close($ch);
        
        // Manejar la respuesta de la API (puede variar según el formato de respuesta de la API)
        return $response;
    }

    function cambiarEstadoNotaApi($idDoc) {
        $data = array(
            'opcion' => 7,
            'iddocferrum' => $idDoc
        );
        
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, URLAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Verificar si hay errores
        if (curl_errno($ch)) {
            // Cerrar la sesión cURL
            curl_close($ch);
            // Lanzar una excepción con el error de cURL
            throw new Exception('cURL Error: ' . curl_errno($ch) . ' - ' . curl_error($ch));
        }
        
        // Cerrar la sesión cURL
        curl_close($ch);
    
        // Manejar la respuesta de la API (puede variar según el formato de respuesta de la API)
        if ($response === '200 OK' || $response === 'Operacion Exitosa') {
            return $response;
        } else {
            // Lanzar una excepción con el mensaje de error de la API
            throw new Exception('Error en la API: ' . $response);
            //return false;
        }
    }

    function cambiarEstadoXNoSurtir($idDoc) {
        $data = array(
            'opcion' => 9,
            'iddocferrum' => $idDoc
        );
        
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, URLAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Verificar si hay errores
        if (curl_errno($ch)) {
            // Cerrar la sesión cURL
            curl_close($ch);
            // Lanzar una excepción con el error de cURL
            return false;
        }
        
        // Cerrar la sesión cURL
        curl_close($ch);
    
        // Manejar la respuesta de la API (puede variar según el formato de respuesta de la API)
        if ($response === '200 OK') {
            return $response;
        } else {
            return false;
        }
    }
    
    

    function cargarNota($FOLIO, $CLAVE, $CANTIDAD, $UNIDAD, $ARTICULO, $IMPORTE, $UBICACION, $CLIENTE, $PAGINA, $VENDEDOR, $SERIE, $IDDOCUMENTO){
        $query = "INSERT INTO surtidosinicio(FOLIO, CLAVE, CANTIDAD, UNIDAD, ARTICULO, IMPORTE, UBICACION, CLIENTE, PAGINA, VENDEDOR, FECHA, HORA, ESTADO, ESTADO2, SERIE, IDDOCUMENTO) 
        VALUES (:FOLIO, :CLAVE, :CANTIDAD, :UNIDAD, :ARTICULO, :IMPORTE, :UBICACION, :CLIENTE, :PAGINA, :VENDEDOR,  CURDATE(), CURTIME(), 'CARGADO', 'CARGADO',:SERIE, :IDDOCUMENTO)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':FOLIO', $FOLIO);
        $result->bindParam(':CLAVE', $CLAVE);
        $result->bindParam(':CANTIDAD', $CANTIDAD);
        $result->bindParam(':UNIDAD', $UNIDAD);
        $result->bindParam(':ARTICULO', $ARTICULO);
        $result->bindParam(':IMPORTE', $IMPORTE);
        $result->bindParam(':UBICACION', $UBICACION);
        $result->bindParam(':CLIENTE', $CLIENTE);
        $result->bindParam(':PAGINA', $PAGINA);
        $result->bindParam(':VENDEDOR', $VENDEDOR);
        $result->bindParam(':SERIE', $SERIE);
        $result->bindParam(':IDDOCUMENTO', $IDDOCUMENTO);
        return $result->execute();
    }

    function notasSinAsignar(){
        $query = "SELECT FOLIO, CLIENTE, HORA, ESTADO, IDDOCUMENTO, MAX(IDPARTIDA) AS IDPARTIDA
        FROM surtidosinicio WHERE fecha = CURDATE()
        GROUP BY FOLIO, CLIENTE, HORA, ESTADO, IDDOCUMENTO
        ORDER BY IDPARTIDA DESC";
        $result = $this->cnx->prepare($query);
    
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                    $datos[] = $fila;
                }
                return $datos;
            } else {
                return []; 
            }
        } else {
            return false; 
        }
    }

    function insertarHoja($numPagina, $idDocumento){
        $query = "INSERT INTO paginas_notas(num_pagina, iddocumento) VALUES (:num_pagina, :idDocumento)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':num_pagina',$numPagina);
        $result->bindParam(':idDocumento',$idDocumento);
        return  $result->execute();
    }

    function consultasPaginas($idDoc){
        $query = "SELECT * FROM paginas_notas WHERE iddocumento = :iddocumento";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':iddocumento',$idDoc);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                    $datos[] = $fila;
                }
                return $datos;
            }else {
                return $datos = [];
            }
        }
        return false;
    }

    function asignarPagina($idPag, $surtidor){
        $query = "UPDATE paginas_notas SET surtidor = :surtidor, estatus = 'ASIGNADA' WHERE id = :idPag";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':surtidor', $surtidor);
        $result->bindParam(':idPag', $idPag);
        return $result->execute();
    }

    function cambiarEstadoNotaAsignada($surtidor, $idDoc){
        $query = "UPDATE surtidosinicio SET ESTADO = 'SURTIENDO', ULTIMOSURTIDOR = :surtidor WHERE IDDOCUMENTO = :idDoc";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':surtidor', $surtidor);
        $result->bindParam('idDoc', $idDoc);
        return $result->execute();
    }

    function agregarNotaAsignada($folio, $nlista, $surtidor, $cliente, $paginas, $idDoc){
        $query = "INSERT INTO notas_asignadas(folio, fecha, hora, nlista, surtidor, cliente, paginas, iddocumento)
        VALUES (:folio, CURDATE(), CURTIME(), :nlista, :surtidor, :cliente, :paginas, :idDoc)";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':folio', $folio);
        $result->bindParam(':nlista', $nlista);
        $result->bindParam(':surtidor', $surtidor);
        $result->bindParam(':cliente', $cliente);
        $result->bindParam(':paginas', $paginas);
        $result->bindParam(':idDoc', $idDoc);
        return $result->execute();
    }

    function consultarInfoNotaInicio($idDoc){
        $query = "SELECT * FROM surtidosinicio
        WHERE IDDOCUMENTO = :idDoc
        ORDER BY IDPARTIDA DESC
        LIMIT 1";

        $result = $this->cnx->prepare($query);
        $result->bindParam(':idDoc', $idDoc);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                $datos = $result->fetch(PDO::FETCH_ASSOC);
                return $datos;
            } else {
                return [];
            }
        }
        return false;
    }

    function consultarNombreSurtidor($nlista){
        $query = "SELECT nombre FROM empleados WHERE nlista = :nlista";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':nlista', $nlista);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                $datos = $result->fetch(PDO::FETCH_ASSOC);
                return $datos;
            } else {
                return [];
            }
        }
        return false;
    }

    function asignasTodasPaginas($nlista, $idDocumento){
        $query = "UPDATE paginas_notas SET surtidor = :surtidor, estatus = 'ASIGNADA' WHERE iddocumento = :idDocumento ";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':surtidor', $nlista);
        $result->bindParam(':idDocumento', $idDocumento);
        return $result->execute();
    }

    function obtenerNumeroPaginaPorID($idPagina){
        $query = "SELECT num_pagina FROM paginas_notas WHERE id = :idPagina";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':idPagina',$idPagina);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                $datos = $result->fetch(PDO::FETCH_ASSOC);
                return $datos['num_pagina'];
            } else {
                return [];
            }
        }
        return false;
    }

    function notasPagosPendientes(){
        $data = array(
            'opcion' => 2,
        );
        
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, URLAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Verificar si hay errores
        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }
        
        // Cerrar la sesión cURL
        curl_close($ch);
    
        // Manejar la respuesta de la API (puede variar según el formato de respuesta de la API)
        if ($response === '204 NO CONTENT') {
            return [];
        } else {
            return $response;
        }
    }

    function notasNoSurtir($fecha){
        $data = array(
            'opcion' => 4,
            'fecha' => $fecha
        );
        
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, URLAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Verificar si hay errores
        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }
        
        // Cerrar la sesión cURL
        curl_close($ch);
    
        // Manejar la respuesta de la API (puede variar según el formato de respuesta de la API)
        if ($response === '204 NO CONTENT') {
            return [];
            
        } else {
            return $response;
        }
    }

    function consultasNotasGalloCorona(){
        $data = array(
            'opcion' => 3,
        );
        
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, URLAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Verificar si hay errores
        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }
        
        // Cerrar la sesión cURL
        curl_close($ch);
    
        // Manejar la respuesta de la API (puede variar según el formato de respuesta de la API)
        if ($response === '204 NO CONTENT') {
            return [];
            
        } else {
            return $response;
        }
    }

    function consultasPersonal(){
        $data = array(
            'opcion' => 10,
        );
        
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, URLAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Verificar si hay errores
        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }
        
        // Cerrar la sesión cURL
        curl_close($ch);
    
        // Manejar la respuesta de la API (puede variar según el formato de respuesta de la API)
        if ($response === '204 NO CONTENT') {
            return [];
            
        } else {
            return $response;
        }
    }

    function obtenerDisponibilidadPersonal($nl){
        $query = "SELECT * FROM notas_asignadas WHERE nlista = :nlista AND estado = 'surtiendo' AND fecha = CURDATE()";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':nlista', $nl);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                return 'Surtiendo';
            } else {
                return 'Libre';
            }
        }
    }

    function notasSinAsignarBusqueda($busqueda){
        $query = "SELECT FOLIO, CLIENTE, HORA, ESTADO, IDDOCUMENTO, MAX(IDPARTIDA) AS IDPARTIDA
        FROM surtidosinicio
        WHERE fecha = CURDATE() AND (FOLIO LIKE CONCAT('%', :busqueda, '%') OR CLIENTE LIKE CONCAT('%', :busqueda, '%'))
        GROUP BY FOLIO, CLIENTE, HORA, ESTADO, IDDOCUMENTO
        ORDER BY IDPARTIDA DESC";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':busqueda', $busqueda);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                    $datos[] = $fila;
                }
                return $datos;
            } else {
                return []; 
            }
        } else {
            return false; 
        }
    }

    function consultarNotasSurtidor($nl, $fechaInicio, $fechaFin) {
        $query = "SELECT folio, fecha, cliente, paginas FROM notas_asignadas WHERE nlista = :nlista AND estado = 'ENTREGADO'
        AND (fecha BETWEEN :fechaInicio AND :fechaFin)
        ORDER BY idnotas DESC";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':nlista', $nl);
        $result->bindParam(':fechaInicio', $fechaInicio);
        $result->bindParam(':fechaFin', $fechaFin);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                    $datos[] = $fila;
                }
                return $datos;
            } else {
                return []; 
            }
        } else {
            return false; 
        }
    }

    function reporteNotasGeneral($fechaInicio, $fechaFin) {
        $query = "SELECT nlista, surtidor, folio, fecha, cliente, paginas
        FROM notas_asignadas WHERE estado = 'ENTREGADO' AND (fecha BETWEEN :fechaInicio AND :fechaFin)
        ORDER BY idnotas DESC";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':fechaInicio', $fechaInicio);
        $result->bindParam(':fechaFin', $fechaFin);
        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                while ($fila = $result->fetch(PDO::FETCH_ASSOC)) {
                    $datos[] = $fila;
                }
                return $datos;
            } else {
                return []; 
            }
        } else {
            return false; 
        }
    }

    function login($phone, $password) {
        $query = "SELECT * FROM usuarios WHERE telefono = :telefono AND status_usuario = 1";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':telefono', $phone);
        if ($result->execute()) {
            $user = $result->fetch(PDO::FETCH_ASSOC);
            if ($user['clave'] === $password) {
                return $user;
            }else {
                return 'not-found';
            }
        }else {
            return false;
        }
    }

    function consultarInfoEmpleado($nlista){
        $data = array(
            'opcion' => 12,
            'nlista' => $nlista,
        );
        
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, URLAPI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        
        // Verificar si hay errores
        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }
        
        // Cerrar la sesión cURL
        curl_close($ch);
    
        // Manejar la respuesta de la API (puede variar según el formato de respuesta de la API)
        if ($response === '204 NO CONTENT') {
            return [];
            
        } else {
            return $response;
        }
    }

    function encryption($string){
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }

    public static function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    function obtenerPassword($idUsuario){
        $query = "SELECT password FROM usuarios WHERE id = :idUsuario";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':idUsuario', $idUsuario);
        $result->execute();
        $fila = $result->fetch();
        return $fila['password'];
    }
}