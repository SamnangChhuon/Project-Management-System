<template>
    <div class="content-wrapper">

        <content-header  page-title="Dashboard" page-name="Dashboard"></content-header>

        <div class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ data.clients }}</h3>
                                <p>Clients</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <router-link :to="{ name: 'ClientsPage' }" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ data.projects }}</h3>
                                <p>Projects</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <router-link :to="{name: 'ProjectsPage'}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ data.tasks }}</h3>
                                <p>Tasks</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <router-link :to="{name: 'TasksPage'}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ data.users }}</h3>
                                <p>Users Management</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <router-link :to="{name: 'UsersManagementPage'}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <section class="col-lg-5">
                        <!-- Calendar -->
                        <div class="card bg-gradient-success">
                            <div class="card-header border-0">

                                <h3 class="card-title">
                                <i class="far fa-calendar-alt"></i>
                                Calendar
                                </h3>
                                <!-- tools card -->
                                <div class="card-tools">
                                    <!-- button with a dropdown -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-bars"></i></button>
                                        <div class="dropdown-menu float-right" role="menu">
                                        <a href="#" class="dropdown-item">Add new event</a>
                                        <a href="#" class="dropdown-item">Clear events</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item">View calendar</a>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div id="calendar" style="width: 100%"></div>
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-clipboard-list mr-1"></i>
                                    To Do List - Tasks
                                </h3>
                                <div class="card-tools">
                                    <ul class="pagination pagination-sm">
                                        <li class="page-item"><a href="#" class="page-link">«</a></li>
                                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                                        <li class="page-item"><a href="#" class="page-link">»</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="todo-list ui-sortable" data-widget="todo-list">
                                    <li v-for="task in tasks.data" :key="task.id">
                                        <!-- checkbox -->
                                        <div class="icheck-primary d-inline ml-2">
                                            <input type="checkbox" v-bind:value="task.id" name="taskId">
                                            <label for="taskId"></label>
                                        </div>
                                        <span class="text">{{ task.task_name }}</span>
                                        <small class="badge badge-danger">
                                            <i class="fas fa-clock"></i> {{ task.total_hours }} hours
                                        </small>
                                        <div class="tools">
                                            <i class="fas fa-edit"></i>
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </li>

                                <li class="done">
                                    <span class="handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">
                                    <label for="todoCheck2"></label>
                                    </div>
                                    <span class="text">Make the theme responsive</span>
                                    <small class="badge badge-info"><i class="fas fa-clock"></i> 4 hours</small>
                                    <div class="tools">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo3" id="todoCheck3">
                                    <label for="todoCheck3"></label>
                                    </div>
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="badge badge-warning"><i class="fas fa-clock"></i> 1 day</small>
                                    <div class="tools">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo4" id="todoCheck4">
                                    <label for="todoCheck4"></label>
                                    </div>
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="badge badge-success"><i class="fas fa-clock"></i> 3 days</small>
                                    <div class="tools">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo5" id="todoCheck5">
                                    <label for="todoCheck5"></label>
                                    </div>
                                    <span class="text">Check your messages and notifications</span>
                                    <small class="badge badge-primary"><i class="fas fa-clock"></i> 1 week</small>
                                    <div class="tools">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle ui-sortable-handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo6" id="todoCheck6">
                                    <label for="todoCheck6"></label>
                                    </div>
                                    <span class="text">Let theme shine like a star</span>
                                    <small class="badge badge-secondary"><i class="fas fa-clock"></i> 1 month</small>
                                    <div class="tools">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-o"></i>
                                    </div>
                                </li>
                                </ul>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="button" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add item</button>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: [],
                tasks: []
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('/api/tasks?page=' + page)
                    .then(response => {
                        this.tasks = response.data;
                    });
            },
            loadTasks() {
                axios.get("/api/tasks").then(({ data }) => (this.tasks = data));
            },
            loadDashboardData() {
                axios.get("/api/dasbhoard/data").then(({ data }) => (this.data = data));
            }
        },
        created() {
            this.$Progress.start();
            this.loadDashboardData();
            this.loadTasks();
            this.$Progress.finish();
        },
    }
</script>
