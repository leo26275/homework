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
        }
    }
});