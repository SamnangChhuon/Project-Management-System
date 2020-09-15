<template>
    <div class="content-wrapper">
        <content-header  page-title="Users Management" page-name="Users Management"></content-header>

        <div class="content">
            <div class="container-fluid">
                <!-- <div class="row" v-if="$gate.isAdminOrAuthor()"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Users Table</h3>

                                <div class="card-tools">
                                    <button class="btn btn-success" @click="newModalUser()">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Bio</th>
                                            <th>Photo</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="user in users.data" :key="user.id">
                                            <td>{{ user.id }}</td>
                                            <td>{{ user.name }}</td>
                                            <td>{{ user.email }}</td>
                                            <td>{{ user.role.name }}</td>
                                            <td>{{ user.bio }}</td>
                                            <td><img :src="getImage(user.photo)" class="img-fluid" style="width: 25px;"></td>
                                            <td>{{ user.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModalUser(user)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteUser(user.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="users" @pagination-change-page="getResultUsers"></pagination>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Roles Table</h3>

                                <div class="card-tools">
                                    <button class="btn btn-success" @click="newModalRole()">Add New <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Registered At</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr v-for="role in roles.data" :key="role.id">
                                            <td>{{ role.id }}</td>
                                            <td>{{ role.name }}</td>
                                            <td>{{ role.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModalRole(role)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteRole(role.id)"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="roles" @pagination-change-page="getResultRoles"></pagination>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div v-if="!$gate.isAdminOrAuthor()">
                    <not-found></not-found>
                </div> -->

                <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmodeRole" id="addNewLabel">Add New User</h5>
                                <h5 class="modal-title" v-show="editmodeRole" id="addNewLabel">Update User's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmodeRole ? updateUser() : createUser()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input v-model="formUser.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': formUser.errors.has('name') }">
                                        <has-error :form="formUser" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input v-model="formUser.email" type="email" name="email"
                                            class="form-control" :class="{ 'is-invalid': formUser.errors.has('email') }">
                                        <has-error :form="formUser" field="email"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="bio">Bio (Optional)</label>
                                        <textarea v-model="formUser.bio" name="bio" id="bio"  placeholder="Short bio for user"
                                            class="form-control" :class="{ 'is-invalid': formUser.errors.has('bio') }"></textarea>
                                        <has-error :form="formUser" field="bio"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="role_id">Role</label>
                                        <select name="role_id" v-model="formUser.role_id" id="role_id" class="form-control" :class="{ 'is-valid': formUser.errors.has('role_id') }">
                                            <option v-for="role in roles.data" :value="role.id" :key="role.id">
                                                {{ role.name }}
                                            </option>
                                        </select>
                                        <has-error :form="formUser" field="role_id"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input v-model="formUser.password" type="password" name="password" id="password"
                                            class="form-control" :class="{ 'is-invalid': formUser.errors.has('password') }">
                                        <has-error :form="formUser" field="password"></has-error>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button v-show="editmodeRole" type="submit" class="btn btn-success">Update <i class="fas fa-pencil-alt fa-fw"></i></button>
                                    <button v-show="!editmodeRole" type="submit" class="btn btn-primary">Create <i class="fas fa-plus fa-fw"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addNewRole" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmodeRole" id="addNewLabel">Add New Role</h5>
                                <h5 class="modal-title" v-show="editmodeRole" id="addNewLabel">Update Role's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmodeRole ? updateRole() : createRole()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input v-model="formRole.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': formRole.errors.has('name') }">
                                        <has-error :form="formRole" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button v-show="editmodeRole" type="submit" class="btn btn-success">Update <i class="fas fa-pencil-alt fa-fw"></i></button>
                                    <button v-show="!editmodeRole" type="submit" class="btn btn-primary">Create <i class="fas fa-plus fa-fw"></i></button>
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
                editmodeUser: false,
                users: {},
                formUser: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    role_id: '',
                    bio: '',
                    photo: ''
                }),

                editmodeRole: false,
                roles: {},
                formRole: new Form({
                    id: '',
                    name: '',
                })
            }
        },
        methods:{
            getImage(image) {
                console.log(image);
                return (image != null) ? 'img/'+image : 'img/profile/default.png';
            },
            getResultUsers(page = 1) {
                axios.get('/api/users?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            },
            getResultRoles(page = 1) {
                axios.get('/api/users/roles?page=' + page)
                    .then(response => {
                        this.roles = response.data;
                    });
		    },
            updateUser() {
                this.$Progress.start();
                this.form.put('/api/users/' + this.form.id)
                .then(() => {
                    // if success
                    $('#addNewUser').modal('hide');
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
            updateRole() {
                this.$Progress.start();
                this.form.put('/api/users/roles/' + this.form.id)
                .then(() => {
                    // if success
                    $('#addNewRole').modal('hide');
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
            editModalUser(user) {
                this.editmodeUser = true;
                this.formUser.reset(); // Reset the modal
                $('#addNewUser').modal('show');
                this.formUser.fill(user); // Pass the data to the modal
            },
            editModalRole(user) {
                this.editmodeRole = true;
                this.formRole.reset(); // Reset the modal
                $('#addNewRole').modal('show');
                this.formRole.fill(user); // Pass the data to the modal
            },
            newModalUser() {
                this.editmodeUser = false;
                this.formUser.reset();
                $('#addNewUser').modal('show');
            },
            newModalRole() {
                this.editmodeRole = false;
                this.formRole.reset();
                $('#addNewRole').modal('show');
            },
            deleteUser(id) {
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
                        this.formUser.delete('/api/users/' + id).then(() => {
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
            deleteRole(id) {
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
                        this.formRole.delete('/api/users/roles/' + id).then(() => {
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
                    axios.get("/api/users").then(({ data }) => (this.users = data));
                // }
            },
            loadRoles() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/users/roles").then(({ data }) => (this.roles = data));
                // }
            },
            createUser() {
                this.$Progress.start();
                this.form.post('/api/users')
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
            },
            createRole() {
                this.$Progress.start();
                this.formRole.post('/api/users/roles')
                .then(() => {
                    // If Insert Success
                    Fire.$emit('AfterCreate'); // Register new event "AfterCreate"
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'Role created in successfully'
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
            this.loadUsers();
            this.loadRoles();
            Fire.$on('AfterCreate', () => {
                this.$Progress.start();
                this.loadUsers();
                this.loadRoles();
            }); // using event AfterCreate
            this.$Progress.finish();
            // setInterval(() => this.loadUsers(), 3000);
        }
    }
</script>
