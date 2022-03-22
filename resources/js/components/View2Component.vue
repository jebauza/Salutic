<template>
<div class="container">


    <div class="card border-success mb-4">
        <div class="card-header">
            <h3 class="card-title text-success font-weight-bold">Vista 2</h3>
            <div class="card-tools float-right">
                <vs-tooltip>
                    <button @click="showForm('add')" class="btn btn-success" >
                        <i class="fas fa-plus-square text-white"></i>
                    </button>
                    <template #tooltip>
                        Nuevo Usuario
                    </template>
                </vs-tooltip>
            </div>
        </div>

        <div class="card-body">

            <div class="form-row">
                <div class="col-sm-5 form-group">
                    <label>Buscar</label>
                    <input v-model="filters.emailAndPhone" type="text" class="form-control" name="emailAndPhone" placeholder="Buscar">
                </div>
                <div class="col-sm-5 form-group">
                    <label>Centro</label>
                    <select v-model="filters.center" class="form-control">
                        <option value=""></option>
                        <option v-for="(center,index) in centers" :key="index" :value="center.ID">{{ center.NOMBRE }}</option>
                    </select>
                </div>
                <div class="form-group col-auto mt-4 pt-2">
                    <vs-tooltip>
                        <button @click="clearFilters()" type="button"
                            class="btn waves-effect waves-light btn-danger float-right">
                            <i class="fas fa-filter"></i>
                        </button>
                        <template #tooltip>
                            Eliminar filtros
                        </template>
                    </vs-tooltip>
                </div>
            </div>

            <div class="row">
                <div class="table-responsive">
                    <table v-if="users.length" class="table table-striped">
                        <thead>
                            <tr class="bg-success">
                                <th>EMAIL</th>
                                <th>TELEFONOS</th>
                                <th>CENTRO</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.EMAIL }}</td>
                                <td>{{ getPhonesString(user) }}</td>
                                <td>{{ user.center ? user.center.NOMBRE : '' }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>


        <div class="modal fade" id="modalUserFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 v-if="modalType=='add'" class="modal-title">Nuevo Usuario</h4>
                        <h4 v-else class="modal-title">Editar Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="needs-validation" v-on:submit.prevent="actionStoreUpdate">
                        <div class="modal-body">


                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name" :class="['control-label', errors.name ? 'text-danger' : '']">Nombre</label>
                                    <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" required>
                                    <small v-if="errors.name" class="form-control-feedback text-danger">
                                        {{ errors.name[0] }}
                                    </small>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label for="last_name2" :class="['control-label', errors.last_name1 ? 'text-danger' : '']">Apellido 1</label>
                                    <input v-model="form.last_name1" type="text" :class="['form-control', errors.last_name1 ? 'is-invalid' : '']" name="last_name1" required>
                                    <small v-if="errors.last_name1" class="form-control-feedback text-danger">
                                        {{ errors.last_name1[0] }}
                                    </small>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label for="last_name1" :class="['control-label', errors.last_name1 ? 'text-danger' : '']">Apellido 2</label>
                                    <input v-model="form.last_name2" type="text" :class="['form-control', errors.last_name2 ? 'is-invalid' : '']" name="last_name2" required>
                                    <small v-if="errors.last_name2" class="form-control-feedback text-danger">
                                        {{ errors.last_name2[0] }}
                                    </small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="email" :class="['control-label', errors.email ? 'text-danger' : '']">Email</label>
                                    <input v-model="form.email" type="text" :class="['form-control', errors.email ? 'is-invalid' : '']" name="email" required autocomplete="email">
                                    <small v-if="errors.email" class="form-control-feedback text-danger">
                                        {{ errors.email[0] }}
                                    </small>
                                </div>

                                <div class="form-group col-sm-6 col-md-4">
                                    <label for="phone1" :class="['control-label', errors.phone1 ? 'text-danger' : '']">Teléfono 1</label>
                                    <input v-model="form.phone1" type="tel" :class="['form-control', errors.phone1 ? 'is-invalid' : '']" name="phone1" required>
                                    <small v-if="errors.phone1" class="form-control-feedback text-danger">
                                        {{ errors.phone1[0] }}
                                    </small>
                                </div>

                                <div class="form-group col-sm-6 col-md-4">
                                    <label for="phone2" :class="['control-label', errors.phone2 ? 'text-danger' : '']">Teléfono 2</label>
                                    <input v-model="form.phone2" type="tel" :class="['form-control', errors.phone1 ? 'is-invalid' : '']" name="phone2" required>
                                    <small v-if="errors.phone2" class="form-control-feedback text-danger">
                                        {{ errors.phone2[0] }}
                                    </small>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="center" :class="['control-label', errors.center ? 'text-danger' : '']">Centro</label>
                                    <select v-model="form.center" :class="['custom-select', errors.center ? 'is-invalid' : '']" name="center" required>
                                        <option disabled value="">Seleccione un elemento</option>
                                        <option v-for="center in centers" :value="center.ID" :key="center.ID">{{ center.NOMBRE }}</option>
                                    </select>
                                    <small v-if="errors.center" class="form-control-feedback text-danger">
                                        {{ errors.center[0] }}
                                    </small>
                                </div>

                                <div class="form-group col-sm-6 col-md-4">
                                    <label for="password" :class="['control-label', errors.password ? 'text-danger' : '']">Contraseña</label>
                                    <input v-model="form.password" type="password" :class="['form-control', errors.password ? 'is-invalid' : '']" name="password" required autocomplete="new-password">
                                    <small v-if="errors.password" class="form-control-feedback text-danger">
                                        {{ errors.password[0] }}
                                    </small>
                                </div>
                                <div class="form-group col-sm-6 col-md-4">
                                    <label for="password" class="control-label">Confirmar contraseña</label>
                                    <input v-model="form.password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>



                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" >Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
</template>

<script>
export default {
    mounted() {

    },

    created() {
        this.getUsers();
        this.getCenters();
    },

    watch: {
        'filters.emailAndPhone': function(newValue, oldValue) {
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
                emailAndPhone: '',
                center:  ''
            },
            modalType: 'add',
            form: {
                name: '',
                last_name1: '',
                last_name2: '',
                email: '',
                phone1: '',
                phone2: '',
                center: '',
                password: '',
                password_confirmation: '',
                id: ''
            },
            errors: {},
        }
    },

    methods: {
        getUsers() {
            const url = `/view2/ajax/users`;

            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
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
            const url = `/view2/ajax/centers`;

            axios.get(url)
            .then(res => {
                this.centers = res.data.data;
            });
        },

        clearFilters() {
            this.filters = {
                emailAndPhone: '',
                center:  ''
            };
        },

        getPhonesString(user) {
            let phones = [];

            if (user.TELEFONO1) {
                phones.push(user.TELEFONO1)
            }
            if (user.TELEFONO2) {
                phones.push(user.TELEFONO2)
            }

            return phones.join(', ');
        },

        showForm(action, user = null) {
            if(this.modalType != action) {
                this.clearForm();
            }
            this.modalType = action;
            if(this.modalType === 'edit' && user) {
                this.form = {
                    name: user.NOMBRE,
                    last_name1: user.APELLIDO1,
                    last_name2: user.APELLIDO2,
                    email: user.EMAIL,
                    phone1: user.TELEFONO1,
                    phone2: user.TELEFONO2,
                    center: user.IDCENTRO,
                    password: '',
                    password_confirmation: '',
                    id: user.ID
                };
            }
            this.erros = {};
            $('#modalUserFormAddEdit').modal('show');
        },

        clearForm() {
            this.form = {
                name: '',
                last_name1: '',
                last_name2: '',
                email: '',
                phone1: '',
                phone2: '',
                center: '',
                password: '',
                password_confirmation: '',
                id: ''
            };
            this.errors = {};
        },

        actionStoreUpdate() {
            if(this.modalType == 'add') {
                this.store();
            }else if(this.modalType == 'edit'){
                this.update();
            }
        },

        store() {
            const url = '/view2/ajax/users/store';
            const loading = this.$vs.loading({
                type: 'points',
                color: 'blue',
                text: 'Saving...'
            });

            axios.post(url, this.form)
            .then(res => {
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getUsers();
                $('#modalUserFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                }else if(err.response.data.message) {
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
        },
    },
}
</script>

<style>

</style>
