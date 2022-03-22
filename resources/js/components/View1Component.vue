<template>
<div class="container">

    <div class="card border-primary mb-4">
        <div class="card-header">
            <h3 class="card-title text-primary font-weight-bold">Vista 1</h3>
            <div class="card-tools float-right">
                <!-- <button @click="showForm('add')" class="btn btn-info btn-sm">
                    <i class="fas fa-plus-square text-white"> New Student</i>
                </button> -->
            </div>
        </div>

        <div class="card-body">

            <div class="form-row">
                <div class="col-sm-5 form-group">
                    <label>Nombre</label>
                    <input v-model="filters.name" type="text" class="form-control" name="name" placeholder="Nombre">
                </div>
                <div class="col-sm-5 form-group">
                    <label>Centro</label>
                    <select v-model="filters.center" class="form-control">
                        <option value=""></option>
                        <option v-for="(center,index) in centers" :key="index" :value="center.ID">{{ center.NOMBRE }}</option>
                    </select>
                </div>
                <div class="form-group col-auto mt-4 pt-2">
                    <button @click="clearFilters()" title="remove filters" type="button"
                        class="btn waves-effect waves-light btn-danger float-right">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="table-responsive">
                    <table v-if="users.length" class="table table-striped">
                        <thead>
                            <tr class="bg-info">
                                <th>NOMBRE</th>
                                <th>CENTRO</th>
                                <th class="text-nowrap text-center"><span>ACCIONES</span></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.fullName }}</td>
                                <td>{{ user.center ? user.center.NOMBRE : '' }}</td>
                                <td class="text-nowrap text-center">
                                    <div>
                                        <!-- <button type="button" @click="showForm('edit', student)"
                                            class="btn m-r-10 waves-effect waves-light btn-outline-primary">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button> -->
                                        <button :disabled="user.IDCENTRO != 2" type="button" @click="destroy(user)"
                                            class="btn waves-effect waves-light btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>


        <!-- <div class="modal fade" id="modalStudentFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-if="modalType=='add'" class="modal-title">New Student</h4>
                        <h4 v-else class="modal-title">Edit Student</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="needs-validation" v-on:submit.prevent="actionStoreUpdate">
                        <div class="modal-body">

                            <div class="form-row">

                                <div class="form-group col-12">
                                    <label for="name" :class="['control-label', errors.name ? 'text-danger' : '']">Name</label>
                                    <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" placeholder="Name" required>
                                    <small v-if="errors.name" class="form-control-feedback text-danger">
                                        {{ errors.name[0] }}
                                    </small>
                                </div>

                                <div class="form-group col-12">
                                    <label for="surnames" :class="['control-label', errors.surnames ? 'text-danger' : '']">Surnames</label>
                                    <input v-model="form.surnames" type="text" :class="['form-control', errors.surnames ? 'is-invalid' : '']" name="surnames" placeholder="Surnames" required>
                                    <small v-if="errors.surnames" class="form-control-feedback text-danger">
                                        {{ errors.surnames[0] }}
                                    </small>
                                </div>

                                <div class="form-group col-12">
                                    <label for="courses" :class="['control-label', errors.courses ? 'text-danger' : '']">Courses</label>
                                    <multiselect
                                        v-model="form.courses"
                                        :options="courses"
                                        placeholder="Courses"
                                        label="name"
                                        track-by="id"
                                        :multiple="true"
                                        :close-on-select="false"
                                        :clear-on-select="false"
                                        :preserve-search="true"
                                        >
                                    </multiselect>
                                    <small v-if="errors.courses" class="form-control-feedback text-danger">
                                        {{ errors.courses[0] }}
                                    </small>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" >Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->

    </div>

</div>
</template>

<script>
// import Multiselect from 'vue-multiselect';

export default {
    // components: {Multiselect},
    mounted() {

    },

    created() {
        this.getUsers();
        this.getCenters();
    },

    watch: {
        'filters.name': function(newValue, oldValue) {
            this.getUsers();
        },
        'filters.center': function(newValue, oldValue) {
            this.getUsers();
        }
    },

    data() {
        return {
            users: [],
            centers: [],

            filters: {
                name: '',
                center:  ''
            },
            // modalType: 'add',
            // form: {
            //     name: '',
            //     surnames: '',
            //     courses: [],
            //     id: ''
            // },
            errors: {},
        }
    },

    methods: {
        getUsers() {
            const url = `/view1/ajax/users`;

            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                // background: '#7a76cb',
                text: 'Cargando...'
            });

            axios.get(url, {
                params: this.filters
            })
            .then(res => {
                this.users = res.data.data;
                this.getCenters();
            }).catch(err => {
                console.error(err);
            }).finally(() => {
                loading.close();
            });
        },

        getCenters() {
            const url = `/view1/ajax/centers`;

            axios.get(url)
            .then(res => {
                this.centers = res.data.data;
            });
        },

        clearFilters() {
            this.filters = {
                name: '',
                center:  ''
            };
        },

        // showForm(action, student = null) {
        //     if(this.modalType != action) {
        //         this.clearForm();
        //     }
        //     this.modalType = action;
        //     if(this.modalType === 'edit' && student) {
        //         this.form = {
        //             name: student.name,
        //             surnames: student.surnames,
        //             courses: student.courses,
        //             id: student.id
        //         }
        //     }
        //     this.erros = {};
        //     $('#modalStudentFormAddEdit').modal('show');
        // },

        // clearForm() {
        //     this.form = {
        //         name: '',
        //         surnames: '',
        //         courses: [],
        //         id: ''
        //     };
        //     this.errors = {};
        // },

        // actionStoreUpdate() {
        //     if(this.modalType == 'add') {
        //         this.store();
        //     }else if(this.modalType == 'edit'){
        //         this.update();
        //     }
        // },

        // store() {
        //     const url = 'api/students/store';
        //     const loading = this.$vs.loading({
        //         type: 'points',
        //         color: 'blue',
        //         // background: '#7a76cb',
        //         text: 'Saving...'
        //     });
        //     axios.post(url, {
        //             name: this.form.name,
        //             surnames: this.form.surnames,
        //             courses: this.form.courses.map(item => item.id)
        //     }).then(res => {
        //         loading.close();
        //         Swal.fire({
        //             title: res.data.nessage,
        //             icon: "success",
        //             timer: 1500,
        //             showConfirmButton: false
        //         });
        //         this.getStudents();
        //         $('#modalStudentFormAddEdit').modal('hide');
        //         this.clearForm();
        //     })
        //     .catch(err => {
        //         loading.close();
        //         if(err.response && err.response.status == 422) {
        //             this.errors = err.response.data.errors;
        //             this.errorsCourses();
        //         }else if(err.response.data.message) {
        //             Swal.fire({
        //                 title: 'Error!',
        //                 text: err.response.data.message,
        //                 icon: "error",
        //                 showCloseButton: true,
        //                 closeButtonColor: 'red',
        //             });
        //         }
        //         console.log(err.response);
        //     });
        // },

        // update() {
        //     const url = `api/students/${this.form.id}/update`;
        //     const loading = this.$vs.loading({
        //         type: 'points',
        //         color: 'blue',
        //         // background: '#7a76cb',
        //         text: 'Saving...'
        //     });
        //     axios.put(url, {
        //             name: this.form.name,
        //             surnames: this.form.surnames,
        //             courses: this.form.courses.map(item => item.id)
        //     }).then(res => {
        //         loading.close();
        //         Swal.fire({
        //             title: res.data.message,
        //             icon: "success",
        //             timer: 1500,
        //             showConfirmButton: false
        //         });
        //         $('#modalStudentFormAddEdit').modal('hide');
        //         this.clearForm();
        //         this.getStudents();
        //     })
        //     .catch(err => {
        //         loading.close();
        //         if(err.response && err.response.status == 422) {
        //             this.errors = err.response.data.errors;
        //             this.errorsCourses();
        //         }else if(err.response.data.message) {
        //             Swal.fire({
        //                 title: 'Error!',
        //                 text: err.response.data.message,
        //                 icon: "error",
        //                 showCloseButton: true,
        //                 closeButtonColor: 'red',
        //             });
        //         }
        //         console.log(err.response);
        //     });
        // },

        destroy(user) {
            Swal.fire({
                title: 'Está seguro?',
                text: `Quieres eliminar a (${user.fullName})?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = `/view1/ajax/users/${user.ID}/destroy`;
                    const loading = this.$vs.loading({
                        type: 'points',
                        color: 'red',
                        // background: '#7a76cb',
                        text: 'Deleting...'
                    });
                    axios.delete(url)
                    .then(res => {
                        Swal.fire({
                            title: res.data.message,
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        this.getUsers();
                    }).catch(err => {
                        if(err.response.data.message) {
                            Swal.fire({
                                title: 'Error!',
                                text: err.response.data.message,
                                icon: "error",
                                showCloseButton: true,
                                closeButtonColor: 'red',
                            });
                        }
                        console.log(err.response);
                    }).finally(() => {
                        loading.close();
                    });
                }
            });
        },

        // errorsCourses() {
        //     if(Object.keys(this.errors).length !== 0) {
        //         if(!this.errors.courses){
        //             for (let i = 0; i < this.courses.length; i++) {
        //                 if(this.errors.hasOwnProperty(`courses.${i}`)){
        //                     this.errors.courses = this.errors[`courses.${i}`];
        //                     break;
        //                 }
        //             }
        //         }
        //     }
        // }
    },
}
</script>

<style>

</style>
