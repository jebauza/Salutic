<template>
<div class="container">

    <div class="card border-primary mb-4">
        <div class="card-header">
            <h3 class="card-title text-primary font-weight-bold">Vista 1</h3>
            <div class="card-tools float-right">

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
        }
    },

    methods: {
        getUsers() {
            const url = `/view1/ajax/users`;

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
    },
}
</script>

<style>

</style>
