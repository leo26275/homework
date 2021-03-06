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
                        <h3 class="div text-info">User list</h3>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-info float-right" @click="showAddModal=true; clearMsg();">
                        <i class="fas fa-user"></i>&nbsp;&nbsp;Add new User
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
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Estatus</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users">
                                    <td class="text-center">{{user.user}}</td>
                                    <td class="text-center">{{user.email}}</td>
                                    <td v-if="user.state == 1" class="text-center"><span class="badge badge-info">Active</span></td>
                                    <td v-else class="text-center"><span class="badge badge-danger">Inactive</span></td>
                                    <td style="text-align: center;">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-dark" title="Editar"  @click="showEditModal=true; selectUser(user);  clearMsg();"><i class="fa fa-pen"></i></i></button>
                                            &nbsp;


                                            <button v-if="user.state == 0" class="btn btn-info" title="Activate" @click="showinactivateModal=true; selectUser(user);  clearMsg();"><i
                                                    class="fa fa-check"></i></button>

                                            <button v-else class="btn btn-danger" title="Deactivate" @click="showActivateModal=true; selectUser(user);  clearMsg();"><i
                                                    class="fa fa-times"></i></button>                                                    
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <?php include('footer.php'); ?>
                </div>
            </div>

        </div>
</body> 
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
 
</html>