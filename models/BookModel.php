<?php
   include '../config/Connection.php';

   $resul = array('error'=> false);
   $action = '';

   if(isset($_GET['action'])){
       $action = $_GET['action'];
   }

   if($action == 'read'){
       $sql = "SELECT idlibro, titulo, editorial, area, '1' AS estado
       FROM libros
       WHERE
           EXISTS (SELECT prestamo.idlibro FROM prestamo WHERE libros.idlibro = prestamo.idlibro) UNION ALL
       SELECT idlibro, titulo, editorial, area, '0' AS tipo
       FROM
           libros
       WHERE 
           NOT EXISTS (SELECT prestamo.idlibro FROM prestamo WHERE libros.idlibro = prestamo.idlibro)";
       
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

if($action == 'delete'){
    $idlibro = $_POST['idlibro'];

    $sql ="DELETE FROM libros WHERE idlibro = '$idlibro'";
    $stmt = sqlsrv_query( $conn, $sql );

    if($sql){
        $resul['message'] = "The book was deleted successfully!";
    }else{
        $resul['error'] = true;
        $resul['message'] = "Could not delete the book";
    }
}


   sqlsrv_close( $conn );
   echo json_encode($resul);
?>