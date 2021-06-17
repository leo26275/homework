<?php
   include '../config/Connection.php';

   $resul = array('error'=> false);
   $action = '';

   if(isset($_GET['action'])){
       $action = $_GET['action'];
   }

   if($action == 'read'){
       $sql = "SELECT * FROM libros";
       $books = array();
       $stmt = sqlsrv_query( $conn, $sql );
       if( $stmt === false) {
           die( print_r( sqlsrv_errors (), true) );
       }

       while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
           array_push($books,$row);
       }

       $resul['books']=$books;
       sqlsrv_free_stmt( $stmt);
       
   }

   if($action == 'create'){
    $titulo = $_POST['titulo'];
    $editorial = $_POST['editorial'];
    $area = $_POST['area'];

    $sql ="INSERT INTO libros (titulo, editorial, area) VALUES ('$titulo', '$editorial', '$area')";
    
    $stmt = sqlsrv_query( $conn, $sql );

    if($stmt){
        $resul['message'] = "Libro added successfully!";
    }else{
        $resul['error'] = true;
        $resul['message'] = "The values are wrong!";
    }
}

   sqlsrv_close( $conn );
   echo json_encode($resul);
?>