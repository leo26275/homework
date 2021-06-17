<?php 

	$serverName = "MSI";
	$connectionInfo = array("Database" =>"libros");
	$conn = sqlsrv_connect($serverName, $connectionInfo);

	if($conn){
		//echo "Conexion establecida";
	}else{
		echo "No se puedo establecer conexion";
		die(print_r(sqlsrv_errors(), true));
	}


?>