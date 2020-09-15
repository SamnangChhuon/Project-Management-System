<template>
    <div class="content-wrapper">

        <content-header :page-title="getProjectName()" page-name="Project Details"></content-header>

        <div class="content">
            <div class="container-fluid">
                <!-- <div class="row" v-if="$gate.isAdminOrAuthor()"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Milestones</h3>

                                <div class="card-tools">
                                    <button class="btn btn-success" @click="newModalMilestone()">Add New <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Due Date</th>
                                            <th>Deliverables</th>
                                            <th>Total Hours</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="milestone in milestones.data" :key="milestone.id">
                                            <td>{{ milestone.id }}</td>
                                            <td>{{ milestone.name }}</td>
                                            <td>{{ milestone.status.status }}</td>
                                            <td>{{ milestone.due_date | formatDate }}</td>
                                            <td>{{ milestone.deliverables }}</td>
                                            <td>{{ milestone.total_hours }}</td>
                                            <td>{{ milestone.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModalMilestone(milestone)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteMilestone(milestone.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="milestones" @pagination-change-page="getMilestoneResults"></pagination>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tasks</h3>

                                <div class="card-tools">
                                    <button class="btn btn-success" @click="newModalTask()">Add New <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Employee</th>
                                            <th>Task Name</th>
                                            <th>Instructions</th>
                                            <th>Status</th>
                                            <th>Milestone</th>
                                            <th>Total Hours</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="task in tasks.data" :key="task.id">
                                            <td>{{ task.id }}</td>
                                            <td>{{ task.employee.name }}</td>
                                            <td>{{ task.task_name }}</td>
                                            <td>{{ task.instructions }}</td>
                                            <td>{{ task.status.status }}</td>
                                            <td>{{ task.milestone.name }}</td>
                                            <td>{{ task.total_hours }}</td>
                                            <td>{{ task.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModalTask(task)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteTask(task.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="tasks" @pagination-change-page="getTaskResults"></pagination>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Hours</h3>

                                <div class="card-tools">
                                    <button class="btn btn-success" @click="newModalHour()">Add New <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Work Completed</th>
                                            <th>Task</th>
                                            <th>Employee</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="hour in hours.data" :key="hour.id">
                                            <td>{{ hour.id }}</td>
                                            <td>{{ hour.date | formatDate }}</td>
                                            <td>{{ hour.time }}</td>
                                            <td>{{ hour.work_completed }}</td>
                                            <td>{{ hour.task.task_name }}</td>
                                            <td>{{ hour.employee.name }}</td>
                                            <td>{{ hour.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModalHour(hour)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteHour(hour.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="hours" @pagination-change-page="getHourResults"></pagination>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Costs</h3>

                                <div class="card-tools">
                                    <button class="btn btn-success" @click="newModalCost()">Add New <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Price Per</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="cost in costs.data" :key="cost.id">
                                            <td>{{ cost.id }}</td>
                                            <td>{{ cost.name }}</td>
                                            <td>{{ cost.description }}</td>
                                            <td>{{ cost.quantity }}</td>
                                            <td>{{ cost.price_per }}</td>
                                            <td>{{ cost.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModalCost(cost)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteCost(cost.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="costs" @pagination-change-page="getCostResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div v-if="!$gate.isAdminOrAuthor()">
                    <not-found></not-found>
                </div> -->

                <div class="modal fade" id="addNewMilestone" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmodeMilestone" id="addNewLabel">Add New Milestone</h5>
                                <h5 class="modal-title" v-show="editmodeMilestone" id="addNewLabel">Update Milestone's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmodeMilestone ? updateMilestone() : createMilestone()" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input v-model="formMilestone.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': formMilestone.errors.has('name') }">
                                        <has-error :form="formMilestone" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_id">Status <span class="text-danger">*</span></label>
                                        <select name="status_id" v-model="formMilestone.status_id" class="form-control" :class="{ 'is-valid': formMilestone.errors.has('status_id') }">
                                            <option v-for="status in milestoneStatuses" :value="status.id" :key="status.id">
                                                {{ status.status }}
                                            </option>
                                        </select>
                                        <has-error :form="formMilestone" field="status_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="due_date">Due Date</label>
                                        <input v-model="formMilestone.due_date" type="date" name="due_date" class="form-control" :class="{ 'is-invalid': formMilestone.errors.has('due_date') }">
                                        <has-error :form="formMilestone" field="due_date"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="deliverables">Deliverables</label>
                                        <input v-model="formMilestone.deliverables" type="text" name="deliverables" class="form-control" :class="{ 'is-invalid': formMilestone.errors.has('deliverables') }">
                                        <has-error :form="formMilestone" field="deliverables"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_hours">Total Hours</label>
                                        <input v-model="formMilestone.total_hours" type="text" name="total_hours" class="form-control" :class="{ 'is-invalid': formMilestone.errors.has('total_hours') }">
                                        <has-error :form="formMilestone" field="total_hours"></has-error>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button v-show="editmodeMilestone" type="submit" class="btn btn-success">Update <i class="fas fa-pencil-alt fa-fw"></i></button>
                                    <button v-show="!editmodeMilestone" type="submit" class="btn btn-primary">Create <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addNewTask" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmodeTask" id="addNewLabel">Add New Task</h5>
                                <h5 class="modal-title" v-show="editmodeTask" id="addNewLabel">Update Task's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmodeTask ? updateTask() : createTask()" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="employee_id">Employee <span class="text-danger">*</span></label>
                                        <select name="employee_id" v-model="formTask.employee_id" class="form-control" :class="{ 'is-valid': formTask.errors.has('employee_id') }">
                                            <option v-for="employee in employees" :value="employee.id" :key="employee.id">
                                                {{ employee.name }}
                                            </option>
                                        </select>
                                        <has-error :form="formTask" field="employee_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="task_name">Task Name <span class="text-danger">*</span></label>
                                        <input v-model="formTask.task_name" type="text" name="task_name" class="form-control" :class="{ 'is-invalid': formTask.errors.has('task_name') }">
                                        <has-error :form="formTask" field="task_name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="instructions">Instructions</label>
                                        <input v-model="formTask.instructions" type="text" name="instructions" class="form-control" :class="{ 'is-invalid': formTask.errors.has('instructions') }">
                                        <has-error :form="formTask" field="instructions"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_id">Status <span class="text-danger">*</span></label>
                                        <select name="status_id" v-model="formTask.status_id" class="form-control" :class="{ 'is-valid': formTask.errors.has('status_id') }">
                                            <option v-for="status in taskStatuses" :value="status.id" :key="status.id">
                                                {{ status.status }}
                                            </option>
                                        </select>
                                        <has-error :form="formTask" field="status_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="milestone_id">Milestone <span class="text-danger">*</span></label>
                                        <select name="milestone_id" v-model="formTask.milestone_id" id="milestone_id" class="form-control" :class="{ 'is-valid': formTask.errors.has('milestone_id') }">
                                            <option v-for="milestone in milestones.data" :value="milestone.id" :key="milestone.id">
                                                {{ milestone.name }}
                                            </option>
                                        </select>
                                        <has-error :form="formTask" field="milestone_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_hours">Total Hours</label>
                                        <input v-model="formTask.total_hours" type="text" name="total_hours" class="form-control" :class="{ 'is-invalid': formTask.errors.has('total_hours') }">
                                        <has-error :form="formTask" field="total_hours"></has-error>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button v-show="editmodeTask" type="submit" class="btn btn-success">Update <i class="fas fa-pencil-alt fa-fw"></i></button>
                                    <button v-show="!editmodeTask" type="submit" class="btn btn-primary">Create <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addNewHour" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmodeHour" id="addNewLabel">Add New Hour</h5>
                                <h5 class="modal-title" v-show="editmodeHour" id="addNewLabel">Update Hour's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmodeHour ? updateHour() : createHour()" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="date">Date <span class="text-danger">*</span></label>
                                        <input v-model="formHour.date" type="date" name="date" class="form-control" :class="{ 'is-invalid': formHour.errors.has('date') }">
                                        <has-error :form="formHour" field="date"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="time">Time <span class="text-danger">*</span></label>
                                        <input v-model="formHour.time" type="text" name="time" class="form-control" :class="{ 'is-invalid': formHour.errors.has('time') }">
                                        <has-error :form="formHour" field="time"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="work_completed">Work Completed</label>
                                        <input v-model="formHour.work_completed" type="text" name="work_completed" class="form-control" :class="{ 'is-invalid': formHour.errors.has('work_completed') }">
                                        <has-error :form="formHour" field="work_completed"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="task_id">Task <span class="text-danger">*</span></label>
                                        <select name="task_id" v-model="formHour.task_id" class="form-control" :class="{ 'is-valid': formHour.errors.has('task_id') }">
                                            <option v-for="task in tasks.data" :value="task.id" :key="task.id">
                                                {{ task.task_name }}
                                            </option>
                                        </select>
                                        <has-error :form="formHour" field="task_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="employee_id">Employee <span class="text-danger">*</span></label>
                                        <select name="employee_id" v-model="formHour.employee_id" class="form-control" :class="{ 'is-valid': formHour.errors.has('employee_id') }">
                                            <option v-for="employee in employees" :value="employee.id" :key="employee.id">
                                                {{ employee.name }}
                                            </option>
                                        </select>
                                        <has-error :form="formHour" field="employee_id"></has-error>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button v-show="editmodeHour" type="submit" class="btn btn-success">Update <i class="fas fa-pencil-alt fa-fw"></i></button>
                                    <button v-show="!editmodeHour" type="submit" class="btn btn-primary">Create <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addNewCost" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmodeCost" id="addNewLabel">Add New Cost</h5>
                                <h5 class="modal-title" v-show="editmodeCost" id="addNewLabel">Update Cost's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmodeCost ? updateCost() : createCost()" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input v-model="formCost.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': formCost.errors.has('name') }">
                                        <has-error :form="formCost" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input v-model="formCost.description" type="text" name="description" class="form-control" :class="{ 'is-invalid': formCost.errors.has('description') }">
                                        <has-error :form="formCost" field="description"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input v-model="formCost.quantity" type="text" name="quantity" class="form-control" :class="{ 'is-invalid': formCost.errors.has('quantity') }">
                                        <has-error :form="formCost" field="quantity"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="price_per">Price Per</label>
                                        <input v-model="formCost.price_per" type="text" name="price_per" class="form-control" :class="{ 'is-invalid': formCost.errors.has('price_per') }">
                                        <has-error :form="formCost" field="price_per"></has-error>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button v-show="editmodeCost" type="submit" class="btn btn-success">Update <i class="fas fa-pencil-alt fa-fw"></i></button>
                                    <button v-show="!editmodeCost" type="submit" class="btn btn-primary">Create <i class="fas fa-plus fa-fw"></i></button>
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
                editmodeMilestone: false,
                milestones: {},
                formMilestone: new Form({
                    id: '',
                    name: '',
                    due_date: '',
                    deliverables: '',
                    status_id: '',
                    total_hours: '',
                    project_id: this.$route.params.projectId
                }),


                editmodeTask: false,
                tasks: {},
                formTask: new Form({
                    id: '',
                    task_name: '',
                    instructions: '',
                    total_hours: '',
                    status_id: '',
                    milestone_id: '',
                    project_id: this.$route.params.projectId,
                    employee_id: ''
                }),


                editmodeHour: false,
                hours: {},
                formHour: new Form({
                    id: '',
                    date: '',
                    time: '',
                    work_completed: '',
                    task_id: '',
                    project_id: this.$route.params.projectId,
                    employee_id: ''
                }),

                editmodeCost: false,
                costs: {},
                formCost: new Form({
                    id: '',
                    name: '',
                    description: '',
                    price_per: '',
                    quantity: '',
                    total_cost: '',
                    project_id: this.$route.params.projectId,
                    milesone_id: ''
                }),

                project: {},
                milestoneStatuses: {},
                taskStatuses: {},
                employees: {},
            }
        },
        methods:{
            fetchProjectData() {
                axios.get('/api/projects/' + this.$route.params.projectId)
                    .then(response => {
                        this.project = response.data.data;
                    });
            },
            getProjectName() {
                return 'Project Details - ' + this.project.project_name;
            },
            getMilestoneStatuses() {
                axios.get('/api/milestones/getMilestoneStatus')
                    .then(response => {
                        this.milestoneStatuses = response.data.data;
                    });
            },
            getTaskStatuses() {
                axios.get('/api/tasks/getTaskStatuses')
                    .then(response => {
                        this.taskStatuses = response.data.data;
                    });
            },
            getEmployees() {
                axios.get('/api/users/manager')
                    .then(response => {
                        this.employees = response.data.data;
                    });
            },

            // fetch all values
            getMilestoneResults(page = 1) {
                axios.get('/api/milestones?page=' + page)
                    .then(response => {
                        this.milestones = response.data;
                    });
            },
            getTaskResults(page = 1) {
                axios.get('/api/tasks?page=' + page)
                    .then(response => {
                        this.tasks = response.data;
                    });
            },
            getHourResults(page = 1) {
                axios.get('/api/milestones-hours?page=' + page)
                    .then(response => {
                        this.hours = response.data;
                    });
            },
            getCostResults(page = 1) {
                axios.get('/api/milestones-costs?page=' + page)
                    .then(response => {
                        this.costs = response.data;
                    });
            },

            updateMilestone() {
                this.$Progress.start();
                this.formMilestone.put('/api/milestones/' + this.formMilestone.id)
                .then(() => {
                    // if success
                    $('#addNewMilestone').modal('hide');
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
            updateTask() {
                this.$Progress.start();
                this.formTask.put('/api/tasks/' + this.formTask.id)
                .then(() => {
                    // if success
                    $('#addNewTask').modal('hide');
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
            updateHour() {
                this.$Progress.start();
                this.formHour.put('/api/milestones-hours/' + this.formHour.id)
                .then(() => {
                    // if success
                    $('#addNewHour').modal('hide');
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
            updateCost() {
                this.$Progress.start();
                this.formCost.put('/api/milestones-costs/' + this.formCost.id)
                .then(() => {
                    // if success
                    $('#addNewCost').modal('hide');
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

            editModalMilestone(milestone) {
                this.editmodeMilestone = true;
                this.formMilestone.reset(); // Reset the modal
                $('#addNewMilestone').modal('show');
                this.formMilestone.fill(milestone); // Pass the data to the modal
            },
            editModalTask(task) {
                this.editmodeTask = true;
                this.formTask.reset(); // Reset the modal
                $('#addNewTask').modal('show');
                this.formTask.fill(task); // Pass the data to the modal
            },
            editModalHour(hour) {
                this.editmodeHour = true;
                this.formHour.reset(); // Reset the modal
                $('#addNewHour').modal('show');
                this.formHour.fill(hour); // Pass the data to the modal
            },
            editModalCost(cost) {
                this.editmodeCost = true;
                this.formCost.reset(); // Reset the modal
                $('#addNewCost').modal('show');
                this.formCost.fill(cost); // Pass the data to the modal
            },

            newModalMilestone() {
                this.editmodeMilestone = false;
                this.formMilestone.reset();
                $('#addNewMilestone').modal('show');
            },
            newModalTask() {
                this.editmodeTask = false;
                this.formTask.reset();
                $('#addNewTask').modal('show');
            },
            newModalHour() {
                this.editmodeHour = false;
                this.formHour.reset();
                $('#addNewHour').modal('show');
            },
            newModalCost() {
                this.editmodeCost = false;
                this.formCost.reset();
                $('#addNewCost').modal('show');
            },

            deleteMilestone(id) {
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
                        this.formMilestone.delete('/api/milestones/' + id).then(() => {
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
            deleteTask(id) {
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
                        this.formTask.delete('/api/tasks/' + id).then(() => {
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
            deleteHour(id) {
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
                        this.formHour.delete('/api/milestones-hours/' + id).then(() => {
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
            deleteCost(id) {
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
                        this.formCost.delete('/api/milestones-costs/' + id).then(() => {
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
                    axios.get("/api/milestones?projectId=" + this.$route.params.projectId).then(({ data }) => (this.milestones = data));

                // }
            },
            loadTasks() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/tasks?projectId=" + this.$route.params.projectId).then(({ data }) => (this.tasks = data));
                // }
            },
            loadHours() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/milestones-hours?projectId=" + this.$route.params.projectId).then(({ data }) => (this.hours = data));
                // }
            },
            loadCosts() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/milestones-costs?projectId=" + this.$route.params.projectId).then(({ data }) => (this.costs = data));
                // }
            },

            createMilestone() {
                this.$Progress.start();
                this.formMilestone.post('/api/milestones')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNewMilestone').modal('hide');
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
            },
            createTask() {
                this.$Progress.start();
                this.formTask.post('/api/tasks')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNewTask').modal('hide');
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
            },
            createHour() {
                this.$Progress.start();
                this.formHour.post('/api/milestones-hours')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNewHour').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Hour created in successfully'
                    })
                    this.$Progress.finish();
                })
                .catch(() => {
                    // If not success
                    this.$Progress.fail();
                });
            },
            createCost() {
                this.$Progress.start();
                this.formCost.post('/api/milestones-costs')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNewCost').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Cost created in successfully'
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
            this.fetchProjectData();
            this.getMilestoneStatuses();
            this.getTaskStatuses();
            this.getEmployees();

            this.loadMilestones();
            this.loadTasks();
            this.loadHours();
            this.loadCosts();
            Fire.$on('AfterCreate', () => {
                this.$Progress.start();
                this.loadMilestones();
                this.loadTasks();
                this.loadHours();
                this.loadCosts();
            }); // using event AfterCreate
            this.$Progress.finish();
            // setInterval(() => this.loadUsers(), 3000);
        }
    }
</script>
