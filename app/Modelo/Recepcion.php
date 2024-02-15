<?php
require_once "../../config/Conexion.php";

class Recepcion
{

    public $cnx;

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

    function obtenerNotas() {
        $query = "SELECT
        iddocumento,
        MIN(folio) AS folio,
        MIN(cliente) AS cliente,
        MIN(hora) AS hora,
        MIN(idnotas) AS idnotas,
        MAX(CASE
            WHEN total_registros = total_entregados THEN 'entregada'
            ELSE 'surtiendo'
        END) AS estatus
        FROM (
            SELECT
                iddocumento, folio, cliente, hora, idnotas,
                COUNT(*) AS total_registros,
                SUM(CASE WHEN estado = 'ENTREGADO' THEN 1 ELSE 0 END) AS total_entregados
            FROM notas_asignadas WHERE estado2 != 'entregado' AND fecha = CURDATE()
            GROUP BY iddocumento
        ) AS subquery
        GROUP BY iddocumento
        ORDER BY idnotas DESC;
        ";
    
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
    

    function busquedaNota($busqueda){
        $query = "SELECT
        iddocumento,
        MIN(folio) AS folio,
        MIN(cliente) AS cliente,
        MIN(hora) AS hora,
        MIN(idnotas) AS idnotas,
        MAX(CASE
            WHEN total_registros = total_entregados THEN 'entregada'
            ELSE 'surtiendo'
        END) AS estatus
        FROM (
            SELECT
                iddocumento, folio, cliente, hora, idnotas,
                COUNT(*) AS total_registros,
                SUM(CASE WHEN estado = 'ENTREGADO' THEN 1 ELSE 0 END) AS total_entregados
            FROM notas_asignadas WHERE estado2 != 'entregado' AND fecha = CURDATE()  AND folio LIKE CONCAT('%', :busqueda, '%')
            GROUP BY iddocumento
        ) AS subquery
        GROUP BY iddocumento
        ORDER BY idnotas DESC;
        ";
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

    function entregarNota($iddoc){
        $query = "UPDATE notas_asignadas SET estado2 = 'entregado', horacliente = CURTIME() WHERE iddocumento = :iddoc";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':iddoc', $iddoc);
        return $result->execute();
    }

    function buscarnota($idnota){
        $query = "SELECT idnotas,folio,fecha,hora,nlista,surtidor,cliente,paginas,horaentrega,estado, estado2, horacliente  FROM notas_asignadas WHERE folio=:idNota or iddocumento=:idNota;";
        $result = $this->cnx->prepare($query);
        $result->bindParam(':idNota', $idnota);
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
}