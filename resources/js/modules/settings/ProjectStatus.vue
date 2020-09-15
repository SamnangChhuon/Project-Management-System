<template>
    <div class="content-wrapper">

        <content-header page-title="Project Statuses" page-name="Project Statuses"></content-header>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Project Status Table</h3>

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
                                            <th>Status</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="value in statuses.data" :key="value.id">
                                            <td>{{ value.id }}</td>
                                            <td>{{ value.status }}</td>
                                            <td>{{ value.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModal(value)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteStatus(value.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="statuses" @pagination-change-page="getResults"></pagination>
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
                                <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmode ? updateData() : createData()" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input v-model="form.status" type="text" name="status" placeholder="Status"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                                        <has-error :form="form" field="status"></has-error>
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
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode: false,
                statuses: {},
                form: new Form({
                    id: '',
                    status: '',
                })
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('/api/projects/statuses?page=' + page)
                    .then(response => {
                        this.statuses = response.data;
                    });
		    },
            updateData() {
                this.$Progress.start();

                this.form.put('/api/projects/statuses/' + this.form.id)
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
            editModal(statuses) {
                this.editmode = true;
                this.form.reset(); // Reset the modal
                $('#addNew').modal('show');
                this.form.fill(statuses); // Pass the data to the modal
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteStatus(id) {
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
                        this.form.delete('/api/projects/statuses/' + id).then(() => {
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
            loadData() {
                // if (this.$gate.isAdminOrAuthor()) {
                //     }
                    axios.get("/api/projects/statuses").then(({ data }) => (this.statuses = data));
            },
            createData() {
                this.$Progress.start();
                this.form.post('/api/projects/statuses')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Status created in successfully'
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
            this.$Progress.start();
            this.loadData();
            Fire.$on('AfterCreate', () => {
                this.$Progress.start();
                this.loadData();
            }); // using event AfterCreate
            this.$Progress.finish();
            // setInterval(() => this.loadData(), 3000);
        }
    }
</script>
