<?php
   include '../config/Connection.php';

   $resul = array('error'=> false);
   $action = '';

   if(isset($_GET['action'])){
       $action = $_GET['action'];
   }

   if($action == 'read'){
       $sql = "SELECT * FROM libro";
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

   sqlsrv_close( $conn );
   echo json_encode($resul);
?>