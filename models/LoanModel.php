<?php
   include '../config/Connection.php';

   $resul = array('error'=> false);
   $action = '';

   if(isset($_GET['action'])){
       $action = $_GET['action'];
   }

   if($action == 'read'){
       $loans = array();
       $sql = "EXEC selectLoan";
       
       $stmt = sqlsrv_prepare( $conn, $sql);

       if(!$stmt) {      
        $resul['error'] = true;
        $resul['message'] = "Error";
       }
       
      if(sqlsrv_execute($stmt)){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $loans[]=$row;
        }
        $resul['loans']=$loans;
        }else{  
            $resul['loans']=$loans;
        }
   }	

   if($action == 'create'){
        $idestudiante = $_POST['idestudiante'];
        $idlibro = $_POST['idlibro'];
        $fecha_prestamo = $_POST['fecha_prestamo'];
        $fecha_dev = $_POST['fecha_dev'];
        $myparants['idestudiante'] = $idestudiante;
        $myparants['idlibro'] = $idlibro;
        $myparants['fecha_prestamo'] = $fecha_prestamo; 
        $myparants['fecha_dev'] = $fecha_dev; 
        $myparants['mensaje'] = '';

        $procedura_params = array(
            array(&$myparants['idestudiante'], SQLSRV_PARAM_IN),
            array(&$myparants['idlibro'], SQLSRV_PARAM_IN),
            array(&$myparants['fecha_prestamo'], SQLSRV_PARAM_IN),
            array(&$myparants['fecha_dev'], SQLSRV_PARAM_IN),
            array(&$myparants['mensaje'], SQLSRV_PARAM_OUT)
        );

        $sql = "EXEC addLoan @idestudiante = ?, @idlibro = ?, @fecha_prestamo = ?, @fecha_dev = ?, @mensaje = ?";
        
        $stmt = sqlsrv_prepare( $conn, $sql, $procedura_params);

        if(!$stmt){
        
            $resul['error'] = true;
            $resul['message'] = "The values are wrong!";
        }

        if(sqlsrv_execute($stmt)){
            $resul['message'] = "Successfull Add Loan!";
        }else{  
            $resul['error'] = true;
            $resul['message'] = "The values are wrong!";
        }
        
    }

    if($action == 'activar'){
        $idprestamo = $_POST['idprestamo'];
        $myparants['idprestamo'] = intval($idprestamo);
        $myparants['mensaje'] = '';

        $procedura_params = array(
            array(&$myparants['idprestamo'], SQLSRV_PARAM_IN),
            array(&$myparants['mensaje'], SQLSRV_PARAM_OUT)
        );

        $sql = "EXEC activateLoan @idprestamo = ?, @mensaje = ?";
        
        $stmt = sqlsrv_prepare( $conn, $sql, $procedura_params);

        if(!$stmt){
            $resul['error'] = true;
            $resul['message'] = "Dened activate!";
        }

        if(sqlsrv_execute($stmt)){
            $resul['message'] = "Successfull activate prestamo!";
        }else{  
            $resul['error'] = true;
            $resul['message'] =$myparants;
        }
    }

    if($action == 'desactivar'){
        $idprestamo = $_POST['idprestamo'];
        $myparants['idprestamo'] = intval($idprestamo);
        $myparants['mensaje'] = '';

        $procedura_params = array(
            array(&$myparants['idprestamo'], SQLSRV_PARAM_IN),
            array(&$myparants['mensaje'], SQLSRV_PARAM_OUT)
        );

        $sql = "EXEC disabledLoan @idprestamo = ?, @mensaje = ?";
        
        $stmt = sqlsrv_prepare( $conn, $sql, $procedura_params);

        if(!$stmt){
            $resul['error'] = true;
            $resul['message'] = "Dened disabled!";
        }

        if(sqlsrv_execute($stmt)){
            $resul['message'] = "Successfull disabled prestamo!";
        }else{  
            $resul['error'] = true;
            $resul['message'] =$myparants;
        }
    }



   sqlsrv_close( $conn );
   echo json_encode($resul);
?>