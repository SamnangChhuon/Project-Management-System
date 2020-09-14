<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ crud.title }}</h3>

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
                        <td>{{ milestone.status }}</td>
                        <td>{{ milestone.due_date }}</td>
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

        <div class="modal fade" id="addNewMilestone" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmodeMilestone" id="addNewLabel">Add New Milestone</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Milestone's Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmodeMilestone ? updateMilestone() : createMilestone()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input v-model="formMilestone.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': formMilestone.errors.has('name') }">
                                <has-error :form="formMilestone" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" v-model="formMilestone.status" id="status" class="form-control" :class="{ 'is-valid': formMilestone.errors.has('status') }">
                                    <option v-for="status in milestoneStatuses" :value="status.id" :key="status.id">
                                        {{ status.name }}
                                    </option>
                                </select>
                                <has-error :form="formMilestone" field="status"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="status">Due Date</label>
                                <input v-model="formMilestone.due_date" type="date" name="due_date" class="form-control" :class="{ 'is-invalid': formMilestone.errors.has('due_date') }">
                                <has-error :form="formMilestone" field="due_date"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="deliverables">Deliverables</label>
                                <input v-model="formMilestone.deliverables" type="date" name="deliverables" class="form-control" :class="{ 'is-invalid': formMilestone.errors.has('deliverables') }">
                                <has-error :form="formMilestone" field="deliverables"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="total_hours">Total Hours</label>
                                <input v-model="formMilestone.total_hours" type="date" name="total_hours" class="form-control" :class="{ 'is-invalid': formMilestone.errors.has('total_hours') }">
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
    </div>

</template>

<script>
export default {
    props: [
        'crud'
    ],

    data() {
        return {
            editmode: false,
            users: {},
            roles: {},
            form: new Form({
                id: '',
                name: '',
                email: '',
                password: '',
                role_id: '',
                bio: '',
                photo: ''
            })
        }
    },
    methods:{
        getUserRole() {
            axios.get('api/user/role?user_id=' + page)
                .then(response => {
                    this.users = response.data;
                });
        },
        getResults(page = 1) {
            axios.get('api/user?page=' + page)
                .then(response => {
                    this.users = response.data;
                });
        },
        updateUser() {
            this.$Progress.start();

            this.form.put('api/user/' + this.form.id)
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
        editModal(user) {
            this.editmode = true;
            this.form.reset(); // Reset the modal
            $('#addNew').modal('show');
            this.form.fill(user); // Pass the data to the modal
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        deleteUsers(id) {
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
                    this.form.delete('api/user/' + id).then(() => {
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
        loadUsers() {
            // if (this.$gate.isAdminOrAuthor()) {
                axios.get("api/user").then(({ data }) => (this.users = data));
            // }
        },
        createUser() {
            this.$Progress.start();
            this.form.post('api/user')
            .then(() => {
                // If Insert Success
                Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                $('#addNew').modal('hide');

                toast.fire({
                    type: 'success',
                    title: 'User created in successfully'
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
        Fire.$on('searching', () => {
            let query = this.$parent.search;
            axios.get('api/findUser?q=' + query)
            .then((data) => {
                this.users = data.data;
            })
            .catch(() => {

            })
        })
        this.loadUsers();
        Fire.$on('AfterCreate', () => {
            this.loadUsers();
        }); // using event AfterCreate
        // setInterval(() => this.loadUsers(), 3000);
    }
}
</script>
