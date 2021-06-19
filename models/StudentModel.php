<?php

    include '../config/Connection.php';

    $resul = array('error'=> false);
    $action = '';

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }

    if($action == 'read'){
        $students = array();
        $sql = "EXEC selectStudent";
       
       $stmt = sqlsrv_prepare( $conn, $sql);

       if(!$stmt) {      
        $resul['error'] = true;
        $resul['message'] = "Error";
       }
       
      if(sqlsrv_execute($stmt)){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $students[]=$row;
        }
        $resul['students']=$students;
        }else{  
            $resul['students']=$students;
        }
        
    }
    
    if($action == 'create'){
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $carrera = $_POST['carrera'];
        $fechanac = $_POST['fechanac'];
        $myparants['nombre'] = $nombre;
        $myparants['direccion'] = $direccion;
        $myparants['carrera'] = $carrera;
        $myparants['fechanac'] = $fechanac; 
        $myparants['mensaje'] = '';
    
        $procedura_params = array(
            array(&$myparants['nombre'], SQLSRV_PARAM_IN),
            array(&$myparants['direccion'], SQLSRV_PARAM_IN),
            array(&$myparants['carrera'], SQLSRV_PARAM_IN),
            array(&$myparants['fechanac'], SQLSRV_PARAM_IN),
            array(&$myparants['mensaje'], SQLSRV_PARAM_OUT)
        );
    
        $sql = "EXEC addStudent @nombre = ?, @direccion = ?, @carrera = ?, @fechanac = ?, @mensaje = ?";
        
        $stmt = sqlsrv_prepare( $conn, $sql, $procedura_params);
    
        if(!$stmt){
          
            $resul['error'] = true;
            $resul['message'] = "The values are wrong!";
        }
    
        if(sqlsrv_execute($stmt)){
            $resul['message'] = "Successfull Add Student!";
        }else{  
            $resul['error'] = true;
            $resul['message'] = "The values are wrong!";
        }
    }

    if($action == 'delete'){
        $idestudiante = $_POST['idestudiante'];
        $myparants['idestudiante'] = intval($idestudiante);
        $myparants['mensaje'] = '';
    
        $procedura_params = array(
            array(&$myparants['idestudiante'], SQLSRV_PARAM_IN),
            array(&$myparants['mensaje'], SQLSRV_PARAM_OUT)
        );
    
        $sql = "EXEC deleteStudent @idestudiante = ?, @mensaje = ?";
        
        $stmt = sqlsrv_prepare( $conn, $sql, $procedura_params);
    
        if(!$stmt){
            $resul['error'] = true;
            $resul['message'] = "The values are wrong!";
        }
    
        if(sqlsrv_execute($stmt)){
            $resul['message'] = "Successfull delete!";
        }else{  
            $resul['error'] = true;
            $resul['message'] =$myparants;
        }
    }

    if($action == 'update'){
        $idestudiante = $_POST['idestudiante'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $carrera = $_POST['carrera'];
        $fechanac = $_POST['fechanac'];
        $myparants['idestudiante'] = intval($idestudiante);
        $myparants['nombre'] = $nombre;
        $myparants['direccion'] = $direccion;
        $myparants['carrera'] = $carrera;
        $myparants['fechanac'] = $fechanac; 
        $myparants['mensaje'] = '';
    
        $procedura_params = array(
            array(&$myparants['idestudiante'], SQLSRV_PARAM_IN),
            array(&$myparants['nombre'], SQLSRV_PARAM_IN),
            array(&$myparants['direccion'], SQLSRV_PARAM_IN),
            array(&$myparants['carrera'], SQLSRV_PARAM_IN),
            array(&$myparants['fechanac'], SQLSRV_PARAM_IN),
            array(&$myparants['mensaje'], SQLSRV_PARAM_OUT)
        );
    
        $sql = "EXEC updateStudent @idestudiante = ?, @nombre = ?, @direccion = ?, @carrera = ?, @fechanac = ?, @mensaje = ?";
        
        $stmt = sqlsrv_prepare( $conn, $sql, $procedura_params);
    
        if(!$stmt){
          
            $resul['error'] = true;
            $resul['message'] = "The values are wrong!";
        }
    
        if(sqlsrv_execute($stmt)){
            $resul['message'] = "Successfull Update!";
        }else{  
            $resul['error'] = true;
            $resul['message'] =$myparants;
        }
    }

    sqlsrv_close( $conn );
    echo json_encode($resul);
?>