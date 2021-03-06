var url = "./../models/StudentModel.php?action=";

var app = new Vue({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        students: [],
        showAddModal: false,
        showEditModal: false,
        showinactivateModal: false,
        showActivateModal: false,
        showInsertModal: true,
        newStudent: {nombre: "", direccion: "", carrera: "", fechanac: ""},
        correntStudent: {}
    },
    mounted: function() {
        this.getAllStudents();
    },
    methods: {
        getAllStudents() {
            axios.get(url.concat("read")).then(function(response) {
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
        addStudent(){
            var formData = app.toFormData(app.newStudent);
            axios.post(url.concat("create"), formData).then(function(response){
                
                app.newStudent = {nombre: "", direccion: "", carrera: "", fechanac: ""};

                if(response.data.error){
                    app.errorMsg = response.data.message;
                }else{
                    app.successMsg = response.data.message;
                    app.getAllStudents();
                    app.showAddModal = false;
                }
            });
        },
        deleteStudent() {
            var formData = app.toFormData(app.correntStudent);
            axios.post(url.concat("delete"), formData).then(function (response) {

                app.correntStudent = {};

                if (response.data.error) {
                    //app.errorMsg = response.data.message;
                } else {
                    //app.successMsg = response.data.message;
                   
                }
                app.getAllStudents();
            });
        },
        selectStuden(student) {
            app.correntStudent = student;
        },
        alertaDelete() {
            Swal.fire({
                title: '??Est?? seguro de borrar el registro: ' + app.correntStudent.nombre + "?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Borrar',
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.value) {
                    app.deleteStudent()
                    
                    //y mostramos un msj sobre la eliminaci??n  
                    Swal.fire(
                        '??Eliminado!',
                        'El registro ha sido borrado.',
                        'success'
                    )
                    app.getAllStudents();
                }
            })
        },
        updateStudent(){
            var formData = app.toFormData(app.correntStudent);
            axios.post(url.concat("update"), formData).then(function(response){
                
                app.correntStudent = {};

                if(response.data.error){
                    app.errorMsg = response.data.message;
                }else{
                    app.successMsg = response.data.message;
                    app.getAllStudents();
                }
            });
        },
        clearMsg(){
            app.errorMsg = "";
            app.successMsg = "";
        }
    }
});