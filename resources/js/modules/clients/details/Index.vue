<template>
    <div class="content-wrapper">
        <content-header :page-title="getClientName()" page-name="Client Details"></content-header>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Projects</h3>

                                <div class="card-tools">
                                    <button class="btn btn-success" @click="newModalProject()">Add New <i class="fas fa-plus fa-fw"></i></button>
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
                                            <td><router-link :to="{ name: 'ProjectDetailsPage', params: { projectId: project.id }}">{{ project.project_name }}</router-link></td>
                                            <td>{{ project.project_manager.name }}</td>
                                            <td>{{ project.hourly_rate }}</td>
                                            <td>{{ project.budget }}</td>
                                            <td>{{ project.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModalProject(project)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteProjects(project.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="projects" @pagination-change-page="getProjects"></pagination>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Contacts</h3>

                                <div class="card-tools">
                                    <button class="btn btn-success" @click="newModalContact()">Add New <i class="fas fa-plus fa-fw"></i></button>
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
                                                <a href="#" @click="editModalProject(contact)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteProjects(contact.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="contacts" @pagination-change-page="getContacts"></pagination>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div v-if="!$gate.isAdminOrAuthor()">
                    <not-found></not-found>
                </div> -->

                <div class="modal fade" id="addNewProject" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmodeProject" id="addNewLabel">Add New Project</h5>
                                <h5 class="modal-title" v-show="editmodeProject" id="addNewLabel">Update Project's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmodeProject ? updateProject() : createProject()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="project_name">Project Name <span class="text-danger">*</span></label>
                                        <input v-model="formProject.project_name" type="text" name="project_name" class="form-control" :class="{ 'is-invalid': formProject.errors.has('project_name') }">
                                        <has-error :form="formProject" field="project_name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="project_manager_id">Project Manager <span class="text-danger">*</span></label>
                                        <select v-model="formProject.project_manager_id" id="" class="form-control" name="project_manager_id" :class="{ 'is-invalid': formProject.errors.has('project_manager_id') }">
                                            <option v-for="user in users" :value="user.id" :key="user.id">
                                                {{ user.name }}
                                            </option>
                                        </select>
                                        <has-error :form="formProject" field="project_manager_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="hourly_rate">Hourly Rate</label>
                                        <input v-model="formProject.hourly_rate" type="text" name="hourly_rate"
                                            class="form-control" :class="{ 'is-invalid': formProject.errors.has('hourly_rate') }">
                                        <has-error :form="formProject" field="hourly_rate"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="budget">Budget</label>
                                        <input v-model="formProject.budget" type="text" name="budget"
                                            class="form-control" :class="{ 'is-invalid': formProject.errors.has('budget') }">
                                        <has-error :form="formProject" field="budget"></has-error>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button v-show="editmodeProject" type="submit" class="btn btn-success">Update <i class="fas fa-pencil-alt fa-fw"></i></button>
                                    <button v-show="!editmodeProject" type="submit" class="btn btn-primary">Create <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addNewContact" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmodeContact" id="addNewLabel">Add New Contact</h5>
                                <h5 class="modal-title" v-show="editmodeContact" id="addNewLabel">Update Contact's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmodeContact ? updateContact() : createContact()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input v-model="formContact.first_name" type="text" name="first_name" class="form-control" :class="{ 'is-invalid': formContact.errors.has('first_name') }">
                                        <has-error :form="formContact" field="first_name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input v-model="formContact.last_name" type="text" name="last_name" class="form-control" :class="{ 'is-invalid': formContact.errors.has('last_name') }">
                                        <has-error :form="formContact" field="last_name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input v-model="formContact.email" type="email" name="email" class="form-control" :class="{ 'is-invalid': formContact.errors.has('email') }">
                                        <has-error :form="formContact" field="email"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="occupation">Occupation</label>
                                        <input v-model="formContact.occupation" type="text" name="occupation" class="form-control" :class="{ 'is-invalid': formContact.errors.has('occupation') }">
                                        <has-error :form="formContact" field="occupation"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input v-model="formContact.phone" type="text" name="phone" class="form-control" :class="{ 'is-invalid': formContact.errors.has('phone') }">
                                        <has-error :form="formContact" field="phone"></has-error>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button v-show="editmodeContact" type="submit" class="btn btn-success">Update <i class="fas fa-pencil-alt fa-fw"></i></button>
                                    <button v-show="!editmodeContact" type="submit" class="btn btn-primary">Create <i class="fas fa-plus fa-fw"></i></button>
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
                editmodeProject: false,
                projects: {},
                formProject: new Form({
                    id: '',
                    project_name: '',
                    project_manager_id: '',
                    hourly_rate: '',
                    budget: '',
                    created_at: '',
                    client_id: this.$route.params.clientId,
                }),

                editmodeContact: false,
                contacts: {},
                formContact: new Form({
                    id: '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    occupation: '',
                    phone: '',
                    created_at: ''
                }),

                users: {},
                client: []
            }
        },
        computed: {
            fetchClientData() {
                axios.get('/api/client/' + this.$route.params.clientId)
                    .then(response => {
                        this.client = response.data.data;
                    });
            },
        },
        methods:{
            getClientName() {
                if (this.client.name != null) {
                    return 'Client Details - ' + this.client.name;
                }
                return 'Client Details - ';
            },
            getProjects(page = 1) {
                axios.get('/api/projects?page=' + page)
                    .then(response => {
                        this.projects = response.data;
                    });
            },
            getContacts(page = 1) {
                axios.get('/api/contacts?page=' + page)
                    .then(response => {
                        this.contacts = response.data;
                    });
		    },
            updateProject() {
                this.$Progress.start();

                this.formProject.put('/api/projects/' + this.formProject.id)
                .then(() => {
                    // if success
                    $('#addNewProject').modal('hide');
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
            editModalProject(project) {
                this.editmodeProject = true;
                this.formProject.reset(); // Reset the modal
                $('#addNewProject').modal('show');
                this.formProject.fill(project); // Pass the data to the modal
            },
            editModalContact(contact) {
                this.editmodeContact = true;
                this.formContact.reset(); // Reset the modal
                $('#addNewContact').modal('show');
                this.formContact.fill(contact); // Pass the data to the modal
            },
            newModalProject() {
                this.editmodeProject = false;
                this.formProject.reset();
                $('#addNewProject').modal('show');
            },
            newModalContact() {
                this.editmodeContact = false;
                this.formContact.reset();
                $('#addNewContact').modal('show');
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
                        this.formProject.delete('/api/projects/' + id).then(() => {
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
                    axios.get("/api/projects?clientId=" + this.$route.params.clientId).then(({ data }) => (this.projects = data));
                // }
            },
            loadContacts() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/contacts").then(({ data }) => (this.contacts = data));
                // }
            },
            loadUsersManager() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/users/manager").then(({ data }) => (this.users = data.data));
                // }
            },
            createProject() {
                this.$Progress.start();
                this.formProject.post('/api/projects')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNewProject').modal('hide');

                    toast.fire({
                        type: 'success',
                        title: 'Information created in successfully'
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
            this.loadContacts();
            this.loadUsersManager();
            Fire.$on('AfterCreate', () => {
                this.loadProjects();
                this.loadContacts();
            }); // using event AfterCreate
            // setInterval(() => this.loadProjects(), 3000);
        }
    }
</script>
