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
        correntBook: {}
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
        }
    }
});