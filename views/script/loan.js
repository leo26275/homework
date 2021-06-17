var url = "./../models/LoanModel.php?action=";

var app = new Vue({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        loans: [],
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
        }
    }
});