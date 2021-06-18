<?php

    include '../config/Connection.php';

    $resul = array('error'=> false);
    $action = '';

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }

    if($action == 'read'){
        $sql = "SELECT idestudiante, nombre, direccion, carrera, fechanac, '1' AS estado
        FROM estudiante
        WHERE
            EXISTS (SELECT prestamo.idestudiante FROM prestamo WHERE estudiante.idestudiante = prestamo.idestudiante) UNION ALL
        SELECT idestudiante, nombre, direccion, carrera, fechanac, '0' AS tipo
        FROM estudiante
        WHERE 
            NOT EXISTS (SELECT prestamo.idestudiante FROM prestamo WHERE estudiante.idestudiante = prestamo.idestudiante)";
        $students = array();
        $stmt = sqlsrv_query( $conn, $sql );
        if( $stmt === false) {
            die( print_r( sqlsrv_errors (), true) );
        }

        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($students,$row);
        }

        $resul['students']=$students;
        sqlsrv_free_stmt( $stmt);
        
    }
    
    if($action == 'create'){
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $carrera = $_POST['carrera'];
        $fechanac = $_POST['fechanac'];
    
        $sql ="INSERT INTO estudiante (nombre, direccion, carrera, fechanac) VALUES ('$nombre', '$direccion', '$carrera', '$fechanac')";
        
        $stmt = sqlsrv_query( $conn, $sql );
    
        if($stmt){
            $resul['message'] = "Student added successfully!";
        }else{
            $resul['error'] = true;
            $resul['message'] = "The values are wrong!";
        }
    }

    sqlsrv_close( $conn );
    echo json_encode($resul);
?>