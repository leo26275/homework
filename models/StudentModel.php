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

    if($action == 'delete'){
        $idestudiante = $_POST['idestudiante'];
    
        $sql ="DELETE FROM estudiante WHERE idestudiante = '$idestudiante'";
        $stmt = sqlsrv_query( $conn, $sql);
    
        if($stmt){
            $resul['message'] = "The student was deleted successfully!";
        }else{
            $resul['error'] = true;
            $resul['message'] = "Could not delete the student";
        }
    }

    if($action == 'update'){
        $idestudiante = $_POST['idestudiante'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $carrera = $_POST['carrera'];
        $fechanac = $_POST['fechanac'];
    
        $sql = "UPDATE estudiante SET nombre = '$nombre', direccion = '$direccion', carrera = '$carrera', fechanac = '$fechanac' WHERE idestudiante = '$idestudiante'";
        $stmt = sqlsrv_query( $conn, $sql);
        
        if($stmt){
            $resul['message'] = "Student updated successfully!";
        }else{
            $resul['error'] = true;
            $resul['message'] = "Failed to update student!";
        }
    }

    sqlsrv_close( $conn );
    echo json_encode($resul);
?>