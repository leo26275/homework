<?php 

	/*$serverName = "MSI";
	$connectionInfo = array("Database" =>"libros");
	$conn = sqlsrv_connect($serverName, $connectionInfo);*/

	$serverName = "devlg"; //serverName\instanceName
	$connectionInfo = array( "Database"=>"libros", "UID"=>"bdatos", "PWD"=>"bdatos");
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

	if($conn){
		//echo "Conexion establecida";
	}else{
		echo "No se puedo establecer conexion";
		die(print_r(sqlsrv_errors(), true));
	}


?>