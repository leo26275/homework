<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <title>Home Work</title>
</head>
<style>
a {
    color: #FCF8F7;
}
</style>
   <style type="text/css">
        #overlay{
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgb(0, 0, 0,0.6);
        }
    </style>
<body>
    <div class="container-fluid">
        <div id="app">
            <?php include('header.php') ?>
            <div class="container">
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <h3 class="div text-info">Lista de libros</h3>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-info float-right" @click="showAddModal=true; clearMsg();">
                        <i class="fas fa-book"></i>&nbsp;&nbsp;Agregar
                        </button>
                    </div>
                </div>
                <hr>
                    <div class="alert alert-danger" role="alert" v-if="errorMsg">
                    {{errorMsg}}
                    </div>
                    <div class="alert alert-success" role="alert" v-if="successMsg">
                    {{successMsg}}
                    </div>
                <div class="row">

                    <div class="col-lg-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center bg-info text-light">
                                    <th>Título</th>
                                    <th>Editorial</th>
                                    <th>Área</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="book in books">
                                    <td class="text-center">{{book.titulo}}</td>
                                    <td class="text-center">{{book.editorial}}</td>
                                    <td class="text-center">{{book.area}}</td>
                                    <td style="text-align: center;">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-dark" title="Editar"  @click=""><i class="fa fa-pen"></i></i></ button>
                                            &nbsp;
                                            <button v-if="book.estado==1" disabled="true" class="btn btn-danger" title="Eliminar"><i
                                                    class="fa fa-trash"></i></button> 
                                            <button v-if="book.estado==0" class="btn btn-danger" title="Eliminar" @click="selectBook(book), alertaDelete();"><i
                                                    class="fa fa-trash"></i></button>            
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <?php include('footer.php'); ?>
                </div>

                <div id="overlay" v-if="showAddModal"> 
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Agregar Nuevo Libro</h5>
                            <button type="button" class="close" @click="showAddModal=false">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="#" method="post">
                                <div class="form-group">
                                  <!--<small style="color: red">Book must be unique</small>-->
                                  <input type="text" name="titulo" class="form-control form-control-lg" placeholder="Title of the book" aria-describedby="helpId" v-model="newBook.titulo"> 
                                  <!--<small style="color: red" v-if="userRequired">Required field</small>-->
                                </div>
                                <div class="form-group">
                                  <input type="text" name="editorial" class="form-control form-control-lg" placeholder="Editorial" aria-describedby="helpId" v-model="newBook.editorial">
                                  <!--<small style="color: red"  v-if="passwordRequired">Required field</small>-->
                                </div>
                                <div class="form-group">
                                  <!--<small style="color: red">Email must be unique</small>-->
                                  <input type="text" name="area" class="form-control form-control-lg" placeholder="Area" aria-describedby="helpId" v-model="newBook.area">
                                  <!--<small style="color: red"  v-if="emailRequired">Required field</small>
                                  <small style="color: red"  v-if="invaleImail">Enter a valid email</small>-->
                                </div>   
                            </form>
                             <div class="form-group">
                                  <button class="btn btn-info btn-block btn-lg" @click="addBook();">Agregar Libro</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            

        </div>    

</body> 
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="./script/book.js"></script>
</html>