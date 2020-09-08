<template>
    <div class="projects">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Projects</h3>

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
                                    <th>Project Name</th>
                                    <th>Project Manager ID</th>
                                    <th>Hourly Rate</th>
                                    <th>Budeget</th>
                                    <th>Registered At</th>
                                    <th>Modify</th>
                                </tr>
                                <tr v-for="project in projects.data" :key="project.id">
                                    <td>{{ project.id }}</td>
                                    <td>{{ project.project_name }}</td>
                                    <td>{{ project.project_manager_id }}</td>
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

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Contacts</h3>

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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Occupation</th>
                                    <th>Phone</th>
                                    <th>Registered At</th>
                                    <th>Modify</th>
                                </tr>
                                <tr v-for="contact in contacts.data" :key="contact.id">
                                    <td>{{ contact.id }}</td>
                                    <td>{{ contact.first_name }}</td>
                                    <td>{{ contact.last_name }}</td>
                                    <td>{{ contact.email }}</td>
                                    <td>{{ contact.occupation }}</td>
                                    <td>{{ contact.phone }}</td>
                                    <td>{{ contact.created_at | formatDate }}</td>
                                    <td>
                                        <a href="#" @click="editModal(contact)"><i class="fas fa-edit text-info"></i></a>
                                        |
                                        <a href="#" @click="deleteProjects(contact.id)"><i class="fas fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="contacts" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
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
                    <form @submit.prevent="editmode ? updateProject() : createProject()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="project_name">Project Name</label>
                                <input v-model="form.project_name" type="text" name="project_name" class="form-control" :class="{ 'is-invalid': form.errors.has('project_name') }">
                                <has-error :form="form" field="project_name"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="project_manager_id">Project Manager</label>
                                <select v-model="form.project_manager_id" id="" class="form-control" name="project_manager_id" :class="{ 'is-invalid': form.errors.has('project_manager_id') }">

                                </select>
                                <has-error :form="form" field="project_manager_id"></has-error>
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
                projects: {},
                contacts: {},
                users: {},
                form: new Form({
                    id: '',
                    project_name: '',
                    project_manager_id: '',
                    hourly_rate: '',
                    budget: '',
                    created_at: ''
                })
            }
        },
        methods:{
            getProjectManager(role_id) {
                axios.get('api/users/' + role_id)
                    .then(response => {
                        this.projects = response.data;
                    });
            },
            getResults(page = 1) {
                axios.get('api/project?page=' + page)
                    .then(response => {
                        this.projects = response.data;
                    });
		    },
            updateProject() {
                this.$Progress.start();

                this.form.put('api/project/' + this.form.id)
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
                        this.form.delete('api/project/' + id).then(() => {
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
                    axios.get("api/project").then(({ data }) => (this.projects = data));
                // }
            },
            createProject() {
                this.$Progress.start();
                this.form.post('api/project')
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
            this.loadProjects();
            this.getProjectManager(1);
            Fire.$on('AfterCreate', () => {
                this.loadProjects();
            }); // using event AfterCreate
            // setInterval(() => this.loadProjects(), 3000);
        }
    }
</script>
