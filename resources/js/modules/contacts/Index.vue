<template>
    <div class="content-wrapper">

        <content-header page-title="Contacts" page-name="Contacts"></content-header>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
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
                                            <th class="id">ID</th>
                                            <th class="name">Name</th>
                                            <th class="title">Title</th>
                                            <th class="first_name">First Name</th>
                                            <th class="middle">Middle</th>
                                            <th class="last_name">Last Name</th>
                                            <th class="email">Email</th>
                                            <th class="gender">Gender</th>
                                            <th class="occupation">Occupation</th>
                                            <th class="phone">Phone</th>
                                            <th class="birthday">Birthday</th>
                                            <th class="notes">Notes</th>
                                            <th class="created_at">Registered At</th>
                                            <th class="action">Modify</th>
                                        </tr>
                                        <tr v-for="contact in contacts.data" :key="contact.id">
                                            <td>{{ contact.id }}</td>
                                            <td>{{ contact.name }}</td>
                                            <td>{{ contact.title }}</td>
                                            <td>{{ contact.first_name }}</td>
                                            <td>{{ contact.middle }}</td>
                                            <td>{{ contact.last_name }}</td>
                                            <td>{{ contact.email }} {{ (contact.email_verified_at != null) ? 'Verified' : '' }}</td>
                                            <td>{{ contact.gender }}</td>
                                            <td>{{ contact.occupation }}</td>
                                            <td>{{ contact.phone }}</td>
                                            <td>{{ contact.birthday }}</td>
                                            <td>{{ contact.notes }}</td>
                                            <td>{{ contact.created_at | formatDate }}</td>
                                            <td>
                                                <a href="#" @click="editModal(contact)"><i class="fas fa-edit text-info"></i></a>
                                                |
                                                <a href="#" @click="deleteUsers(contact.id)"><i class="fas fa-trash text-danger"></i></a>
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
                                <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Contact</h5>
                                <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Contact's Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="editmode ? updateContact() : createContact()" autocomplete="off">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input v-model="form.name" type="text" name="name" placeholder=""
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.title" type="text" name="title" placeholder=""
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                        <has-error :form="form" field="title"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.first_name" type="text" name="first_name" placeholder=""
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                                        <has-error :form="form" field="first_name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.middle" type="text" name="middle" placeholder=""
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('middle') }">
                                        <has-error :form="form" field="middle"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.last_name" type="text" name="last_name" placeholder=""
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                                        <has-error :form="form" field="last_name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.email" type="email" name="email" placeholder="Email Address"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                        <has-error :form="form" field="email"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="gender_male" name="gender" v-model="form.gender">
                                            <label for="gender_male" class="custom-control-label">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="gender_female" name="gender" v-model="form.gender" checked="">
                                            <label for="gender_female" class="custom-control-label">Female</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.occupation" type="text" name="occupation" placeholder=""
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('occupation') }">
                                        <has-error :form="form" field="occupation"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.phone" type="text" name="phone" placeholder=""
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                                        <has-error :form="form" field="phone"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <input v-model="form.birthday" type="text" name="birthday" placeholder=""
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('birthday') }">
                                        <has-error :form="form" field="birthday"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <textarea v-model="form.notes" name="notes" id="notes"  placeholder="Remark"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('notes') }"></textarea>
                                        <has-error :form="form" field="notes"></has-error>
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
                contacts: {},
                form: new Form({
                    id: '',
                    name: '',
                    title: '',
                    first_name: '',
                    middle: '',
                    last_name: '',
                    email: '',
                    email_verified_at: '',
                    gender: '',
                    occupation: '',
                    phone: '',
                    birthday: '',
                    notes: '',
                    client_id: '',
                    created_at: ''
                })
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('/api/contacts?page=' + page)
                    .then(response => {
                        this.contacts = response.data;
                    });
		    },
            updateContact() {
                this.$Progress.start();

                this.form.put('/api/contacts/' + this.form.id)
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
            deleteContacts(id) {
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
                        this.form.delete('/api/contacts/' + id).then(() => {
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
            loadContacts() {
                // if (this.$gate.isAdminOrAuthor()) {
                    axios.get("/api/contacts").then(({ data }) => (this.contacts = data));
                // }
            },
            createContact() {
                this.$Progress.start();
                this.form.post('/api/contacts')
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
            this.$Progress.start();
            this.loadContacts();
            Fire.$on('AfterCreate', () => {
                this.$Progress.start();
                this.loadContacts();
            }); // using event AfterCreate
            this.$Progress.finish();
            // setInterval(() => this.loadUsers(), 3000);
        }
    }
</script>
