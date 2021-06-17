var url = "./../models/BookModel.php?action=";

var app = new Vue({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        books: [],
        showAddModal: false,
        showEditModal: false,
        showinactivateModal: false,
        showActivateModal: false,
        showInsertModal: true,
        newBook: {titulo: "", editorial: "", area: ""},
        correntBook: {}
    },
    mounted: function() {
        this.getAllBooks();
    },
    methods: {
        getAllBooks() {
            axios.get(url.concat("read")).then(function(response) {
                if (response.data.error) {
                    app.errorMsg = response.data.message;
                } else {
                    app.books = response.data.books;
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
        addBook(){
            var formData = app.toFormData(app.newBook);
            axios.post(url.concat("create"), formData).then(function(response){
                
                app.newBook = {titulo: "", editorial: "", area: ""};

                if(response.data.error){
                    app.errorMsg = response.data.message;
                }else{
                    app.successMsg = response.data.message;
                    app.getAllBooks();
                }
            });
        },
        deleteBook() {
            var formData = app.toFormData(app.correntBook);
            axios.post(url.concat("delete"), formData).then(function (response) {

                app.correntBook = {};

                if (response.data.error) {
                    //app.errorMsg = response.data.message;
                } else {
                    //app.successMsg = response.data.message;
                    app.getAllBooks();
                }
            });
        },
        selectBook(book) {
            app.correntBook = book;
        },
        alertaDelete() {
            Swal.fire({
                title: '¿Está seguro de borrar el registro: ' + app.correntBook.titulo + "?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Borrar',
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.value) {
                    app.deleteBook()
                    app.getAllBooks();
                    //y mostramos un msj sobre la eliminación  
                    Swal.fire(
                        '¡Eliminado!',
                        'El registro ha sido borrado.',
                        'success'
                    )
                }
            })
        }
    }
});