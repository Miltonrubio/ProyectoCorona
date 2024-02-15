<?php
$fecha2 = new DateTime('2023-01-01 '.date('h:i:s'));//fecha de cierre 
echo "hora:".$fecha2->format('%H horas %i minutos');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos
//echo phpinfo();
?>