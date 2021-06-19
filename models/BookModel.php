<?php
   include '../config/Connection.php';

   $resul = array('error'=> false);
   $action = '';

   if(isset($_GET['action'])){
       $action = $_GET['action'];
   }

   if($action == 'read'){
        $books = array();

       $sql = "EXEC selectBook";
       
       $stmt = sqlsrv_prepare( $conn, $sql);

       if(!$stmt) {      
        $resul['error'] = true;
        $resul['message'] = "Error";
       }
       
      if(sqlsrv_execute($stmt)){
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            $books[]=$row;
        }
        $resul['books']=$books;
        }else{  
            $resul['books']=$books;
        }
       
   }

   if($action == 'create'){
    $titulo = $_POST['titulo'];
    $editorial = $_POST['editorial'];
    $area = $_POST['area'];
    $myparants['titulo'] = $titulo;
    $myparants['editorial'] = $editorial;
    $myparants['area'] = $area; 
    $myparants['mensaje'] = '';

    $procedura_params = array(
        array(&$myparants['titulo'], SQLSRV_PARAM_IN),
        array(&$myparants['editorial'], SQLSRV_PARAM_IN),
        array(&$myparants['area'], SQLSRV_PARAM_IN),
        array(&$myparants['mensaje'], SQLSRV_PARAM_OUT)
    );

    $sql = "EXEC addBook @titulo = ?, @editorial = ?, @area = ?, @mensaje = ?";
    
    $stmt = sqlsrv_prepare( $conn, $sql, $procedura_params);

    if(!$stmt){
      
        $resul['error'] = true;
        $resul['message'] = "The values are wrong!";
    }

    if(sqlsrv_execute($stmt)){
        $resul['message'] = "Successfull!";
    }else{  
        $resul['error'] = true;
        $resul['message'] = "The values are wrong!";
    }
}

if($action == 'delete'){
    $idlibro = $_POST['idlibro'];
    $myparants['idlibro'] = intval($idlibro);
    $myparants['mensaje'] = '';

    $procedura_params = array(
        array(&$myparants['idlibro'], SQLSRV_PARAM_IN),
        array(&$myparants['mensaje'], SQLSRV_PARAM_OUT)
    );

    $sql = "EXEC deleteBook @idlibro = ?, @mensaje = ?";
    
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
    $idlibro = $_POST['idlibro'];
    $titulo = $_POST['titulo'];
    $editorial = $_POST['editorial'];
    $area = $_POST['area'];
    $myparants['idlibro'] = intval($idlibro);
    $myparants['titulo'] = $titulo;
    $myparants['editorial'] = $editorial;
    $myparants['area'] = $area; 
    $myparants['mensaje'] = '';

    $procedura_params = array(
        array(&$myparants['idlibro'], SQLSRV_PARAM_IN),
        array(&$myparants['titulo'], SQLSRV_PARAM_IN),
        array(&$myparants['editorial'], SQLSRV_PARAM_IN),
        array(&$myparants['area'], SQLSRV_PARAM_IN),
        array(&$myparants['mensaje'], SQLSRV_PARAM_OUT)
    );

    $sql = "EXEC updateBook @idlibro = ?, @titulo = ?, @editorial = ?, @area = ?, @mensaje = ?";
    
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