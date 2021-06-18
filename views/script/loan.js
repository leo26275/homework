var url = "./../models/LoanModel.php?action=";
var urlib = "./../models/BookModel.php?action=";
var urlE = "./../models/StudentModel.php?action=";

var app = new Vue({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        loans: [],
        students: [],
        books: [],
        showAddModal: false,
        showEditModal: false,
        showinactivateModal: false,
        showActivateModal: false,
        showInsertModal: true,
        newLoan: {idestudiante: "", idlibro: "", fecha_prestamo: "", fecha_dev: "", devuelto:""},
        correntLoan: {}
    },
    mounted: function() {
        this.getAllLoans();
        this.getAllBooks();
        this.getAllStudents();
    },
    methods: {
        getAllLoans() {
            axios.get(url.concat("read")).then(function(response) {
                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.loans = response.data.loans;
                }
            });
        },
        getAllBooks() {
            axios.get(urlib.concat("read")).then(function(response) {
                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.books = response.data.books;
                    
                }
            });
        },
        getAllStudents() {
            axios.get(urlE.concat("read")).then(function(response) {
                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.students = response.data.students;
                }
            });
        },
        toFormData(obj){
            var fd = new FormData();
            for (var i in obj){
                fd.append(i,obj[i]);
            }
            return fd;
        },
        clearMsg(){
            app.errorMsg = "";
            app.successMsg = "";
        },
        addLoan(){
            var formData = app.toFormData(app.newLoan);
            axios.post(url.concat("create"), formData).then(function(response){
                
                app.newLoan = {idestudiante: "", idlibro: "", fecha_prestamo: "", fecha_dev: "", devuelto: ""};

                if(response.data.error){
                    app.errorMsg = response.data.message;
                }else{
                    app.successMsg = response.data.message;
                    app.getAllLoans();
                    app.showAddModal = false;
                }
            });
        },
        selectLoan(loan){
            app.correntLoan = loan;
        },
        activarLoan() {
            var formData = app.toFormData(app.correntLoan);
            axios.post(url.concat("activar"), formData).then(function (response) {

                app.correntLoan = {};

                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.succesMsg = response.data.message;
                    app.getAllLoans();
                }
            });
        },
        alertaActivar() {
            Swal.fire({
                title: '¿Esta seguro de habilitar el prestamo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Habilitar',
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.value) {
                    app.activarLoan();
                    Swal.fire(
                        '¡Habilitado!',
                        'El registro ha sido habilitado',
                        'success'
                    )
                }
            })
        },
        desactivarLoan() {
            var formData = app.toFormData(app.correntLoan);
            axios.post(url.concat("desactivar"), formData).then(function (response) {

                app.correntLoan = {};

                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.succesMsg = response.data.message;
                    app.getAllLoans();
                }
            });
        },
        alertaDesabilitar() {
            Swal.fire({
                title: '¿Está seguro que desea deshabilitar el prestamo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Deshabilitar',
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.value) {
                    app.desactivarLoan();
                    Swal.fire(
                        'Deshabilitado!',
                        'El registro se ha deshabilitado.',
                        'success'
                    )
                }
            });
        }
    }
});