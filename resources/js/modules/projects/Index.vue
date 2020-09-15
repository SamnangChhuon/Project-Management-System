<template>
    <div class="content-wrapper">

        <content-header page-title="Projects" page-name="Projects"></content-header>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Projects Table</h3>

                                <div class="card-tools">
                                    <button class="btn btn-success" @click="newModal()">Add New <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>Client</th>
                                            <th>Active</th>
                                            <th>Project Name</th>
                                            <th>Status</th>
                                            <th>Project Manager</th>
                                            <th>Hourly Rate</th>
                                            <th>Budget</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="project in projects.data" :key="project.id">
                                            <td><router-link :to="{ name: 'ClientDetailsPage', params: { clientId: project.client_id }}">{{ project.client.name }}</router-link></td>
                                            <td>{{ (project.active) ? 'Active' : 'UnActive' }}</td>
                                            <td><router-link :to="{ name: 'ProjectDetailsPage', params: { projectId: project.id }}">{{ project.project_name }}</router-link></td>
                                            <td>{{ project.status.status }}</td>
                                            <td>{{ project.project_manager.name }}</td>
                                            <td>{{ project.hourly_rate }}</td>
                                            <td>{{ project.budget }}</td>
                                            <td>{{ project.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModal(project)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteProjects(project.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="projects" @pagination-change-page="getResults"></pagination>
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
                                <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Project</h5>
                                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Project's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmode ? updateProject() : createProject()" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="client_id">Client <span class="text-danger">*</span></label>
                                        <select v-model="form.client_id" name="client_id" class="form-control" :class="{ 'is-invalid': form.errors.has('client_id') }">
                                            <option v-for="client in clients" :value="client.id" :key="client.id">
                                                {{ client.name }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="client_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="active">Active</label>
                                        <select v-model="form.active" name="active" class="form-control" :class="{ 'is-invalid': form.errors.has('active') }">
                                            <option value="1">Active</option>
                                            <option value="0">InActive</option>
                                        </select>
                                        <has-error :form="form" field="active"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="project_name">Project Name <span class="text-danger">*</span></label>
                                        <input v-model="form.project_name" type="text" name="project_name" class="form-control" :class="{ 'is-invalid': form.errors.has('project_name') }">
                                        <has-error :form="form" field="project_name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_id">Status <span class="text-danger">*</span></label>
                                        <select v-model="form.status_id" name="status_id" class="form-control" :class="{ 'is-invalid': form.errors.has('status_id') }">
                                            <option v-for="status in projectStatuses" :value="status.id" :key="status.id">
                                                {{ status.status }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="status_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="project_manager_id">Project Manager <span class="text-danger">*</span></label>
                                        <select v-model="form.project_manager_id" name="project_manager_id" class="form-control" :class="{ 'is-invalid': form.errors.has('project_manager_id') }">
                                            <option v-for="user in users" :value="user.id" :key="user.id">
                                                {{ user.name }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="project_manager_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="hourly_rate">Hourly Rate</label>
                                        <input v-model="form.hourly_rate" type="text" name="hourly_rate" class="form-control" :class="{ 'is-invalid': form.errors.has('hourly_rate') }">
                                        <has-error :form="form" field="hourly_rate"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="budget">Budget</label>
                                        <input v-model="form.budget" type="text" name="budget"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('budget') }">
                                        <has-error :form="form" field="budget"></has-error>
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
                projects: {},
                form: new Form({
                    id: '',
                    client_id: '',
                    active: true,
                    project_name: '',
                    status_id: '',
                    project_manager_id: '',
                    hourly_rate: '',
                    budget: ''
                }),
                clients:{},
                users: {},
                projectStatuses: {}
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/projects?page=' + page)
                    .then(response => {
                        this.projects = response.data;
                    });
		    },
            updateProject() {
                this.$Progress.start();

                this.form.put('api/projects/' + this.form.id)
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
            editModal(project) {
                this.editmode = true;
                this.form.reset(); // Reset the modal
                $('#addNew').modal('show');
                this.form.fill(project); // Pass the data to the modal
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteProjects(id) {
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
                        this.form.delete('api/projects/' + id).then(() => {
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
            loadProjects() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("api/projects").then(({ data }) => (this.projects = data));
                // }
            },
            loadProjectStatuses() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("api/projects/getStatus").then(({ data }) => (this.projectStatuses = data.data));
                // }
            },
            loadClients() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/clients/getClients").then(({ data }) => (this.clients = data.data));
                // }
            },
            loadUsersManager() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/users/manager").then(({ data }) => (this.users = data.data));
                // }
            },
            createProject() {
                this.$Progress.start();
                this.form.post('api/projects')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Project created in successfully'
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
            this.loadProjects();
            this.loadProjectStatuses();
            this.loadUsersManager();
            this.loadClients();
            Fire.$on('AfterCreate', () => {
                this.$Progress.start();
                this.loadProjects();
            }); // using event AfterCreate
            this.$Progress.finish();
            // setInterval(() => this.loadProjects(), 3000);
        }
    }
</script>
