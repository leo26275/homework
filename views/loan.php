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
                        <h3 class="div text-info">Lista de prestamos</h3>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-info float-right" @click="showAddModal=true; clearMsg();">
                        <i class="fas fa-user"></i>&nbsp;&nbsp;Agregar
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
                                    <th>Estudiante</th>
                                    <th>Libro</th>
                                    <th>Fecha prestamo</th>
                                    <th>Fecha devolución</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="loan in loans">
                                    <td class="text-center">{{loan.estudiante}}</td>
                                    <td class="text-center">{{loan.titulo}}</td>
                                    <td class="text-center">{{loan.fecha_prestamo.date}}</td>
                                    <td class="text-center">{{loan.fecha_dev.date}}</td>
                                    <td v-if="loan.devuelto == 1" class="text-center"><span class="badge badge-info">Active</span></td>
                                    <td v-else class="text-center"><span class="badge badge-info">Desactivado</span></td>
                                    <td style="text-align: center;">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-dark" title="Editar"  @click=""><i class="fa fa-pen"></i></i></ button>
                                            &nbsp;
                                             <button v-if="loan.devuelto==1" class="btn btn-info" title="Activate" @click="selectLoan(loan), alertaDesabilitar()"><i
                                                    class="fa fa-check"></i></button>

                                            <button v-else class="btn btn-danger" title="Deactivate" @click="selectLoan(loan), alertaActivar()"><i
                                                    class="fa fa-times"></i></button>   
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
                            <h5 class="modal-title">Realizar Nuevo Prestamo</h5>
                            <button type="button" class="close" @click="showAddModal=false">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="#" method="post">
                                <div class="form-group">
                                  <!--<small style="color: red">Book must be unique</small>-->
                                  <select v-model="newLoan.idestudiante" class="form-control select-picker" name="idestudiante" id="idestudiante" required>
                                                    <option disabled="true">-- Seleccione un estudiante --</option>
                                                    <option v-for="student in students" :value="student.idestudiante">
                                                        {{student.nombre}}
                                                    </option>
                                                </select>
                                  <!--<small style="color: red" v-if="userRequired">Required field</small>-->
                                </div>
                                <div class="form-group">
                                <select v-model="newLoan.idlibro" class="form-control select-picker" name="idlibro" id="idlibro" required>
                                                    <option disabled="true">-- Seleccione un libro --</option>
                                                    <option v-for="book in books" :value="book.idlibro">
                                                        {{book.titulo}}
                                                    </option>
                                                </select>
                                  <!--<small style="color: red"  v-if="passwordRequired">Required field</small>-->
                                </div>
                                <div class="form-group">
                                  <!--<small style="color: red">Email must be unique</small>-->
                                  <input type="date" name="feha_prestamo" class="form-control form-control-lg" placeholder="Fecha de prestamo" aria-describedby="helpId" v-model="newLoan.fecha_prestamo">
                                  <!--<small style="color: red"  v-if="emailRequired">Required field</small>
                                  <small style="color: red"  v-if="invaleImail">Enter a valid email</small>-->
                                </div>   
                                <div class="form-group">
                                  <!--<small style="color: red">Email must be unique</small>-->
                                  <input type="date" name="feha_dev" class="form-control form-control-lg" placeholder="Fecha de devolucion" aria-describedby="helpId" v-model="newLoan.feha_dev">
                                  <!--<small style="color: red"  v-if="emailRequired">Required field</small>
                                  <small style="color: red"  v-if="invaleImail">Enter a valid email</small>-->
                                </div>   
                            </form>
                             <div class="form-group">
                                  <button class="btn btn-info btn-block btn-lg" @click="addLoan();">Agregar prestamo</button>
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
<script src="./script/loan.js"></script>
 
</html>