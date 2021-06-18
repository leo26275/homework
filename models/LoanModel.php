<?php
   include '../config/Connection.php';

   $resul = array('error'=> false);
   $action = '';

   if(isset($_GET['action'])){
       $action = $_GET['action'];
   }

   if($action == 'read'){
       $sql = "SELECT x.estudiante, x.titulo, x.fecha_prestamo, x.fecha_dev, x.devuelto
       FROM(
       SELECT es.nombre AS estudiante, li.titulo AS titulo, p.fecha_prestamo, p.fecha_dev, p.devuelto
       FROM prestamo p, (SELECT e.idestudiante, e.nombre FROM estudiante e)es,
       (SELECT l.idlibro, l.titulo FROM libros l)li
       WHERE p.idestudiante = es.idestudiante AND p.idlibro = li.idlibro)x";
       $loans = array();
       $stmt = sqlsrv_query( $conn, $sql );
       if( $stmt === false) {
           die( print_r( sqlsrv_errors (), true) );
       }

       while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
           array_push($loans,$row);
       }

       $resul['loans']=$loans;
       sqlsrv_free_stmt( $stmt);
       
   }	

   if($action == 'create'){
    $idestudiante = $_POST['idestudiante'];
    $idlibro = $_POST['idlibro'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $fecha_dev = $_POST['fecha_dev'];

    $sql ="INSERT INTO prestamo (idestudiante, idlibro, fecha_prestamo, fecha_dev, devuelto) VALUES ('$idestudiante', '$idlibro', '$fecha_prestamo', '$fecha_dev', 
    1)";
    
    $stmt = sqlsrv_query( $conn, $sql );

    if($stmt){
        $resul['message'] = "Prestamo added successfully!";
    }else{
        $resul['error'] = true;
        $resul['message'] = "The values are wrong!";
    }
}

   sqlsrv_close( $conn );
   echo json_encode($resul);
?>