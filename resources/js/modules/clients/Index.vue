<template>
    <div class="clients">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Clients Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">Add New <i class="fas fa-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Website</th>
                                    <th>Industry</th>
                                    <th>Phone</th>
                                    <th>Registered At</th>
                                    <th>Modify</th>
                                </tr>
                                <tr v-for="client in clients.data" :key="client.id">
                                    <td>{{ client.id }}</td>
                                    <td>{{ client.name }}</td>
                                    <td>{{ client.website }}</td>
                                    <td>{{ client.industry }}</td>
                                    <td>{{ client.phone }}</td>
                                    <td>{{ client.created_at | formatDate }}</td>
                                    <td>
                                        <a href="#" @click="editModal(client)"><i class="fas fa-edit text-info"></i></a>
                                        |
                                        <a href="#" @click="deleteClients(client.id)"><i class="fas fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="clients" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div> -->

        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Client</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Client's Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateClient() : createClient()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input v-model="form.name" type="text" name="name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="website">Website</label>
                                <input v-model="form.website" type="text" name="website"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('website') }">
                                <has-error :form="form" field="website"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="industry">Industry</label>
                                <input v-model="form.industry" type="text" name="industry"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('industry') }">
                                <has-error :form="form" field="industry"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input v-model="form.phone" type="text" name="phone"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="phone"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Update <i class="fas fa-pencil-alt fa-fw"></i></button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Create <i class="fas fa-plus fa-fw"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode: false,
                clients: {},
                form: new Form({
                    id: '',
                    name: '',
                    website: '',
                    industry: '',
                    phone: ''
                })
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/client?page=' + page)
                    .then(response => {
                        this.clients = response.data;
                    });
		    },
            updateClient() {
                this.$Progress.start();

                this.form.put('api/client/' + this.form.id)
                .then(() => {
                    // if success
                    $('#addNew').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                    )
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            editModal(client) {
                this.editmode = true;
                this.form.reset(); // Reset the modal
                $('#addNew').modal('show');
                this.form.fill(client); // Pass the data to the modal
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteClients(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // Send requesst to the server
                    if (result.value) {
                        this.form.delete('api/client/' + id).then(() => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                        }).catch(() => {
                            Swal.fire("Failed!", "There was something wrong.", "warning");
                        });
                    }
                })
            },
            loadClients() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("api/client").then(({ data }) => (this.clients = data));
                // }
            },
            createClient() {
                this.$Progress.start();
                this.form.post('api/client')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNew').modal('hide');
    
                    toast.fire({
                        type: 'success',
                        title: 'Client created in successfully'
                    })
    
                    this.$Progress.finish();

                })
                .catch(() => {
                    // If not success
                    this.$Progress.fail();
                    
                });
            }
        },
        created() {
            this.loadClients();
            Fire.$on('AfterCreate', () => {
                this.loadClients();
            }); // using event AfterCreate
            // setInterval(() => this.loadClients(), 3000);
        }
    }
</script>
