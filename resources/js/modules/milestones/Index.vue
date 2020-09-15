<template>
    <div class="content-wrapper">

        <content-header page-title="Milestones" page-name="Milestones"></content-header>

        <div class="content">
            <div class="container-fluid">
                <!-- <div class="row" v-if="$gate.isAdminOrAuthor()"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Milestones Table</h3>

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
                                            <th>Due Date</th>
                                            <th>Deliverables</th>
                                            <th>Status</th>
                                            <th>Project</th>
                                            <th>Total Hours</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="milestone in milestones.data" :key="milestone.id">
                                            <td>{{ milestone.id }}</td>
                                            <td>{{ milestone.name }}</td>
                                            <td>{{ milestone.due_date }}</td>
                                            <td>{{ milestone.deliverables }}</td>
                                            <td>{{ milestone.status.status }}</td>
                                            <td><router-link :to="{ name: 'ProjectDetailsPage', params: { projectId: milestone.project_id }}">{{ milestone.project.project_name }}</router-link></td>
                                            <td>{{ milestone.total_hours }}</td>
                                            <td>{{ milestone.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModal(milestone)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteMilestones(milestone.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="milestones" @pagination-change-page="getResults"></pagination>
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
                                <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Milestone</h5>
                                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Milestone's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmode ? updateMilestone() : createMilestone()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" required>
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                        <input v-model="form.due_date" type="date" name="due_date" class="form-control" :class="{ 'is-invalid': form.errors.has('due_date') }" required>
                                        <has-error :form="form" field="due_date"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="deliverables">Deliverables <span class="text-danger">*</span></label>
                                        <input v-model="form.deliverables" type="date" name="deliverables" class="form-control" :class="{ 'is-invalid': form.errors.has('deliverables') }" required>
                                        <has-error :form="form" field="deliverables"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_id">Status <span class="text-danger">*</span></label>
                                        <select name="status_id" v-model="form.status_id" class="form-control" :class="{ 'is-valid': form.errors.has('status_id') }" required>
                                            <option v-for="status in milestoneStatuses" :value="status.id" :key="status.id">
                                                {{ status.status }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="status_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="project_id">Project <span class="text-danger">*</span></label>
                                        <select name="project_id" v-model="form.project_id" class="form-control" :class="{ 'is-valid': form.errors.has('project_id') }" required>
                                            <option v-for="project in projects" :value="project.id" :key="project.id">
                                                {{ project.project_name }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="project_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_hours">Total Hours</label>
                                        <input v-model="form.total_hours" type="text" name="total_hours" id="total_hours" class="form-control" :class="{ 'is-invalid': form.errors.has('total_hours') }">
                                        <has-error :form="form" field="total_hours"></has-error>
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
                milestones: {},
                roles: {},
                form: new Form({
                    id: '',
                    name: '',
                    due_date: '',
                    deliverables: '',
                    status_id: '',
                    project_id: '',
                    total_hours: ''
                }),
                milestoneStatuses: {},
                projects: {}
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('/api/milestones?page=' + page)
                    .then(response => {
                        this.milestones = response.data;
                    });
		    },
            updateMilestone() {
                this.$Progress.start();
                this.form.put('/api/milestones/' + this.form.id)
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
            editModal(milestone) {
                this.editmode = true;
                this.form.reset(); // Reset the modal
                $('#addNew').modal('show');
                this.form.fill(milestone); // Pass the data to the modal
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteMilestones(id) {
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
                        this.form.delete('/api/milestone/' + id).then(() => {
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
            loadMilestones() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/milestones").then(({ data }) => (this.milestones = data));
                // }
            },
            loadMilestoneStatuses() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/milestones/getMilestoneStatus").then(({ data }) => (this.milestoneStatuses = data.data));
                // }
            },
            loadProjects() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/projects?getType=all").then(({ data }) => (this.projects = data.data));
                // }
            },
            createMilestone() {
                this.$Progress.start();
                this.form.post('/api/milestones')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Milestone created in successfully'
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
            this.loadMilestones();
            this.loadMilestoneStatuses();
            Fire.$on('AfterCreate', () => {
                this.$Progress.start();
                this.loadMilestones();
            }); // using event AfterCreate
            this.$Progress.finish();
            // setInterval(() => this.loadMilestones(), 3000);
        }
    }
</script>
