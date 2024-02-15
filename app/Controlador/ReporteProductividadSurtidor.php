<?php
require_once '../Modelo/Notas.php';
$html = ob_start();
$nlista = isset($_POST['nlista_notas_surtidor']) ? $_POST['nlista_notas_surtidor'] : '';
$nombre = isset($_POST['nombre_notas_surtidor']) ? $_POST['nombre_notas_surtidor'] : '';
$departamento = isset($_POST['departamento_notas_surtidor']) ? $_POST['departamento_notas_surtidor'] : '';
$fechaInicio = !empty($_POST['fecha_inicio_notas_surtidor']) ? $_POST['fecha_inicio_notas_surtidor'] : date("Y-m-d");
$fechaFin = !empty($_POST['fecha_fin_notas_surtidor']) ? $_POST['fecha_fin_notas_surtidor'] : date("Y-m-d");
$bd = new Notas();

$notas = $bd->consultarNotasSurtidor($nlista, $fechaInicio, $fechaFin);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>REPORTES</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        header {
            margin-bottom: 10px;
        }

        header img {
            max-height: 70px;
            width: auto;
        }

        .company-info {
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }

        section {
            margin-bottom: 10px;
        }

        section:after {
            content: "";
            display: table;
            clear: both;
        }

        .customer-info,
        .invoice-info {
            width: 50%;
            float: left;
            font-size: 12px;
        }

        .invoice-info {
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: red;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .no-data {
            margin: 0 auto;
        }

        .titulos-section2 {
            background-color: black;
            color: white;
            text-align: center;
            width: 98%;
            font-size: 15px;
        }

        .titulos-section3 {
            background-color: black;
            color: white;
            text-align: center;
            width: 100%;
            font-size: 13px;
        }

        .numeroletra {
            font-size: 12px;
            font-weight: bold;

        }
    </style>

<body>
    <header>
        <center><img src="http://hidalgo.no-ip.info:5610/bitacora/fotos/fotos_usuarios/fotoperfilusuario45.jpg"></center>
        <div class="company-info">
            <p>ABARROTERA HIDALGO<br>
                Calle 5 Ote #1500<br>
                COL. LA PURISIMA, CP:75784<br>
                TEHUACAN PUEBLA
            </p>
        </div>
    </header>
    <section>
        <div class="customer-info">
            <h2 class="titulos-section2">DATOS DEL EMPLEADO</h2>
            <?php
            echo  "NOMBRE: "    . $nombre . "<br>";
            echo  " DEPARTAMENTO: "  . $departamento . "<br>";
            ?>
        </div>
    </section>
    <section>
        <h2 class="titulos-section3">Notas surtidas</h2>
        <table>
            <thead>
                <tr>
                    <th width="10%">FOLIO</th>
                    <th width="10%">FECHA</th>
                    <th width="10%">CLIENTE</th>
                    <th width="10%">PAGINAS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($notas)) {
                    foreach ($notas as $key => $nota) {
                        echo "<tr>";
                        echo "<td>" . $nota['folio'] . "</td>";
                        echo "<td>" . $nota['fecha'] . "</td>";
                        echo "<td>" . $nota['cliente'] . "</td>";
                        echo "<td>" . $nota['paginas'] . "</td>";
                    }
                } else {
                    echo "<tr class='" . 'no-data' . "'>";
                    echo "<h1>No hay datos</h1>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>

</head>

</html>

<?php
// CREAR EL PDF
$html = ob_get_clean();
require_once '../../librerias/dompdf/autoload.inc.php';
include_once '../../librerias/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
//tamaño carta vertical
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();
$dompdf->stream('Reporte '.$fechaInicio.'- '.$fechaFin.'.pdf', array("Attachment" => false));

?>
?>