<template>
    <div class="content-wrapper">

        <content-header page-title="Tasks" page-name="Tasks"></content-header>

        <div class="content">
            <div class="container-fluid">
                <!-- <div class="row" v-if="$gate.isAdminOrAuthor()"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tasks Table</h3>

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
                                            <th>Task Name</th>
                                            <th>Instructions</th>
                                            <th>Total Hours</th>
                                            <th>Status</th>
                                            <th>Milestone</th>
                                            <th>Project</th>
                                            <th>Employee</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="task in tasks.data" :key="task.id">
                                            <td>{{ task.id }}</td>
                                            <td>{{ task.task_name }}</td>
                                            <td>{{ task.instructions }}</td>
                                            <td>{{ task.total_hours }}</td>
                                            <td>{{ task.status.status }}</td>
                                            <td>{{ task.milestone.name }}</td>
                                            <td><router-link :to="{ name: 'ProjectDetailsPage', params: { projectId: task.project_id }}">{{ task.project.project_name }}</router-link></td>
                                            <td>{{ task.employee.name }}</td>
                                            <td>{{ task.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModal(task)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteTasks(task.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="tasks" @pagination-change-page="getResults"></pagination>
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
                                <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Task</h5>
                                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Task's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmode ? updateTask() : createTask()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="task_name">Task Name <span class="text-danger">*</span></label>
                                        <input v-model="form.task_name" type="text" name="task_name" class="form-control" :class="{ 'is-invalid': form.errors.has('task_name') }" required>
                                        <has-error :form="form" field="task_name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="instructions">Instructions</label>
                                        <input v-model="form.instructions" type="text" name="instructions" class="form-control" :class="{ 'is-invalid': form.errors.has('instructions') }">
                                        <has-error :form="form" field="instructions"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_hours">Total Hours</label>
                                        <input v-model="form.total_hours" type="text" name="total_hours" id="total_hours" class="form-control" :class="{ 'is-invalid': form.errors.has('total_hours') }">
                                        <has-error :form="form" field="total_hours"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_id">Status <span class="text-danger">*</span></label>
                                        <select name="status_id" v-model="form.status_id" class="form-control" :class="{ 'is-valid': form.errors.has('status_id') }" required>
                                            <option v-for="status in taskStatuses" :value="status.id" :key="status.id">
                                                {{ status.status }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="status_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="milestone_id">Milestone <span class="text-danger">*</span></label>
                                        <select name="milestone_id" v-model="form.milestone_id" class="form-control" :class="{ 'is-valid': form.errors.has('milestone_id') }" required>
                                            <option v-for="project in projects" :value="project.id" :key="project.id">
                                                {{ project.project_name }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="milestone_id"></has-error>
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
                                        <label for="employee_id">Employee <span class="text-danger">*</span></label>
                                        <select name="employee_id" v-model="form.employee_id" class="form-control" :class="{ 'is-valid': form.errors.has('employee_id') }" required>
                                            <option v-for="employee in employees" :value="employee.id" :key="employee.id">
                                                {{ employee.name }}
                                            </option>
                                        </select>
                                        <has-error :form="form" field="employee_id"></has-error>
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
                tasks: {},
                form: new Form({
                    id: '',
                    task_name: '',
                    instructions: '',
                    total_hours: '',
                    status_id: '',
                    milestone_id: '',
                    project_id: '',
                    employee_id: '',
                }),
                taskStatuses: {},
                milestones: {},
                projects: {},
                employees: {},
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('/api/tasks?page=' + page)
                    .then(response => {
                        this.tasks = response.data;
                    });
		    },
            updateTask() {
                this.$Progress.start();
                this.form.put('/api/tasks/' + this.form.id)
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
            editModal(task) {
                this.editmode = true;
                this.form.reset(); // Reset the modal
                $('#addNew').modal('show');
                this.form.fill(task); // Pass the data to the modal
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteTasks(id) {
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
                        this.form.delete('/api/task/' + id).then(() => {
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
            loadTasks() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/tasks").then(({ data }) => (this.tasks = data));
                // }
            },
            loadTaskStatuses() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/tasks/statuses?getType=all").then(({ data }) => (this.taskStatuses = data.data));
                // }
            },
            loadMilestones() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/milestones?getType=all").then(({ data }) => (this.milestones = data.data));
                // }
            },
            loadProjects() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/projects?getType=all").then(({ data }) => (this.projects = data.data));
                // }
            },
            loadEmployees() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/users/manager").then(({ data }) => (this.employees = data.data));
                // }
            },
            createTask() {
                this.$Progress.start();
                this.form.post('/api/tasks')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Task created in successfully'
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
            this.loadTasks();
            this.loadTaskStatuses();
            this.loadMilestones();
            this.loadProjects();
            this.loadEmployees();
            Fire.$on('AfterCreate', () => {
                this.$Progress.start();
                this.loadTasks();
            }); // using event AfterCreate
            this.$Progress.finish();
            // setInterval(() => this.loadTasks(), 3000);
        }
    }
</script>
