<?php
/* session_start();
$user="";
if(isset($_SESSION['nombre'])){
$user=$_SESSION['nombre'] . "";

}
else {
	header('Location: index.html');
} */
?>
<?php
include 'conecciones.php';



?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-180283536-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-180283536-1');
</script>

	<title>Rastreo - Abarrotera Hidalgo</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="Startup Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //Meta tag Keywords -->

	<!-- Custom-Files -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Bootstrap-Core-CSS -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!-- Style-CSS -->
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<!-- Font-Awesome-Icons-CSS -->
	<!-- //Custom-Files -->

	<!-- Web-Fonts -->
	<link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext"
	 rel="stylesheet">
	<!-- //Web-Fonts -->
</head>
	<body onLoad="redireccionar()">

		<!-- Wrapper -->
			<div id="wrapper">
				<!-- Main -->
					<div id="main">
						<div class="inner">
							<!-- Header -->
								<header id="header">
								</header>
							<!-- Banner -->
								<section id="banner">
									
								</section>

						<!-- Section --><!-- Section --></div>
                    </div>
<?PHP
$idnota=$_POST["idrastreo"];

if(validanumero("".$idnota)=="1"){
echo "Rastreo valido";
guardaconsulta($idnota,"".getRealIP());
}
else{
	/////////////////////////////////////////////////////////////header('Location: '."index.php");
}
  ?>
                    
                    
                   

<!-- inicio estatus nota -->
<div class="container py-xl-5 py-lg-3">
			
            <?php 
									
									
									
									$conexion= Conectar();
									$query="";
									$query = "SELECT idnotas,FOLIO,FECHA,HORA,NLISTA,SURTIDOR,CLIENTE,PAGINAS,HORAENTREGA,IDCHECADOR,CHECADOR,horachecador FROM notas.notas_asignadas WHERE folio='$idnota' or iddocumento=$idnota;" or die("Error in the consult.." . mysqli_error($conexion)); 
									$resultado = $conexion->query($query);
									$FINALIZADAS=0;
									$PAGINAS=0;
									$notifica="";
									$avance=0;
									$pendientes=0;
									$FOLIO="";
                                    $CLIENTE="";
									$FECHA="";
									
									while($row = mysqli_fetch_array($resultado)) 
									{ 
										$PAGINAS++;
										$FOLIO=$row["FOLIO"];
                                        $CLIENTE=$row["CLIENTE"];
                                        $FECHA=$row["FECHA"];

                                           if($row["HORAENTREGA"]=='00:00:00'){
												$pendientes++;
                                           }else{
											   $FINALIZADAS++;
                                           }
                                    } 
									echo "<h3 class='tittle text-center font-weight-bold'> NOTA ".$FOLIO." <BR/> Cliente:".$CLIENTE."</h3>
									<div class='row ab-info second pt-lg-4'>";
	 
	 if($FINALIZADAS>0){
				$avance=((($FINALIZADAS-$PAGINAS)/$PAGINAS)*100)*(-1);
				//echo "fn:".$FINALIZADAS." pg:".$PAGINAS."";
				//echo "<h1>".$avance."<h2>";
					if($avance==0){
						echo "<div class='d-md-flex'>
								<div class='tittle text-center font-weight-bold'>
									<h3 class='w3ls_pvt-title'>TU PEDIDO YA ESTA <br><span>LISTO!!!</span></h3>
									<p class='text-sty-banner'>YA PUEDES PASAR POR TU PEDIDO EN ATENCION A CLIENTES</a>
								</div>
							</div>";
						}
					else{
						if($avance>0 && $avance<30){
							echo "<div class='d-md-flex'>
							<div class='tittle text-center font-weight-bold'>
										<h3 class='w3ls_pvt-title'>YA FALTA POCO PARA QUE TU PEDIDO ESTE <br><span>LISTO!!!</span></h3>
										<p class='text-sty-banner'>YA PUEDES PASAR POR TU PEDIDO EN ATENCION A CLIENTES</a>
									</div>
								</div>";

				}
				elseif($avance>0 && $avance<50){
					echo "<div class='d-md-flex'>
					<div class='tittle text-center font-weight-bold'>
						<h3 class='w3ls_pvt-title'>TU PEDIDO LO ESTAN SURTIENDO!!! <br></h3>
						<p class='text-sty-banner'>EN BREVE ESTARA LISTO</a>
					</div>
					
				</div>";
					
				}else {
					echo "<div class='d-md-flex'>
					<div class='tittle text-center font-weight-bold'>
								<h3 class='w3ls_pvt-title'>YA COMENZARON A SURTIR TU PEDIDO</h3>
								<p class='text-sty-banner'>PUEDES CONSULTAR MAS TARDE PARA VER COMO VAN CON TU PEDIDO</a>
							</div>
						  </div>";
				}
			}

			
		}
		else {

if($pendientes>0){
	echo "<div class='d-md-flex'>
	<div class='tittle text-center font-weight-bold'>
		<h3 class='w3ls_pvt-title'>YA COMENZARON A SURTIR TU PEDIDO</h3>
		<p class='text-sty-banner'>PUEDES CONSULTAR MAS TARDE PARA VER COMO VAN CON TU PEDIDO</a>
	</div>
	
</div>";

}else {
	echo "<div class='d-md-flex'>
	<div class='tittle text-center font-weight-bold'>
		<h3 class='w3ls_pvt-title'><span>AL PARECER A UN NO ASIGNAN TU PEDIDO A UN SURTIDOR</span></h3>
		<p class='text-sty-banner'>NO TE PREOCUPES EN BREVE SERA ASIGNADA Y PODRAS CONSULTAR COMO VA TU PEDIDO</a>
	</div>
	
</div>";
}
		
		}

			?>
			
			</div>
		</div>

			<!-- fin de estatus nota -->		
			<section class="team bg-li py-1" id="team">
		<div class="container py-xl-2 py-lg-3">
			<div>El siguiente Personal esta surtiendo tu Nota</div>
			<div class="row ab-info second pt-lg-4">
            <?php 
									$conexion= Conectar();
									$query="";
  $query = "SELECT idnotas,FOLIO,FECHA,HORA,NLISTA,SURTIDOR,CLIENTE,PAGINAS,HORAENTREGA FROM notas.notas_asignadas WHERE folio='$idnota' or iddocumento=$idnota;" or die("Error in the consult.." . mysqli_error($conexion)); 
																
																
  $resultado = $conexion->query($query);
									
									$notifica="";
									
									while($row = mysqli_fetch_array($resultado)) 
									{ 
										$PAGINAS++;
                                        echo "<div class='col-lg-4 col-sm-6 ab-content text-center mt-lg-0 mt-4'>
                                       			 <div class='ab-content-inner'>
                                            		<img src='images/t1.jpg' alt='news image' class='img-fluid'>
                                            		<div class='ab-info-con'>
                                               			 <h4 class='text-team-w3'>".$row["SURTIDOR"]."</h4>
                                               			 <ul class='list-unstyled team-socil-w3pvts'>
                                                 			 <li class='d-inline'>PAGINAS:".$row["PAGINAS"]."</li>
                                                		</ul>
                                                		<ul class='list-unstyled team-socil-w3pvts'>
                                                			<li class='d-inline'>HORA DE SURTIDO:".$row["HORA"]."</li>
                                            			</ul>
                                            			<ul class='list-unstyled team-socil-w3pvts'>
                                                			<li class='d-inline'>HORA DE ENTREGA:".$row["HORAENTREGA"]."</li>
                                            			</ul>
                                            			<ul class='list-unstyled team-socil-w3pvts'>
                                            				<li class='d-inline'>ESTADO:<B>"; 
                                           						if($row["HORAENTREGA"]=='00:00:00'){
																	echo "PENDIENTE";
												                }else{
																	 echo "SURTIDO";
																	}
																   echo "</B>
															</li>
														</ul>
                                            		</div>
                                        		</div>
                                    		</div>";
		 
	 } 
	 
	 

			?>
			
			</div>
		</div>
	</section>
                    <!-- fin surtidor -->

				<!-- Sidebar -->
				
			</div>

			<?php
			function validanumero($valor){
				$str = $valor;
				$res="0";
				$pattern = '/^[0-9]\d{5}$/';
				$res=preg_match($pattern, $str); // Outputs 1
				return $res;
			}

			function guardaconsulta($valor,$ipx){
				$conexion= Conectar();
				$query="";
				$query = "INSERT INTO notas.consutas (fecha,hora,folioconsulta,ip) VALUES (Curdate(),Curtime(),'$valor','$ipx');" or die("Error in the consult.." . mysqli_error($conexion)); 
				$inser11 = mysqli_query($conexion,$query);
			}
   			 function getRealIP(){
		  		foreach ( [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ] as $key ) {
				// Comprobamos si existe la clave solicitada en el array de la variable $_SERVER 
				if ( array_key_exists( $key, $_SERVER ) ) {
				// Eliminamos los espacios blancos del inicio y final para cada clave que existe en la variable $_SERVER 
				foreach ( array_map( 'trim', explode( ',', $_SERVER[ $key ] ) ) as $ip ) {
					// Filtramos* la variable y retorna el primero que pase el filtro
					if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
						return $ip;
						}
					}
					}
					}
	
					return '?'; // Retornamos '?' si no hay ninguna IP o no pase el filtro
				    }
			?>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script language="JavaScript">
  function redireccionar() {
   setTimeout("location.href='index.php'", 9000);
  }
  </script>

	</body>
</html>