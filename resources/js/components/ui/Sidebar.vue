<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Project MS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/img/profile.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ user.name }}</a>
                <span class="text-white">{{ user.type }}</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <router-link :to="{ name: 'DashboardPage' }" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{ name: 'ClientsPage'}" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Clients</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'ContactsPage'}" class="nav-link">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>Contacts</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'MilestonesPage'}" class="nav-link">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>Milestones</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'ProjectsPage'}" class="nav-link">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>Projects</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'TasksPage'}" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tasks</p>
                    </router-link>
                </li>
                <!-- @can('isAdmin') -->
                <li class="nav-item">
                    <router-link :to="{name: 'UsersManagementPage'}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users Management</p>
                    </router-link>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings <i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link :to="{ name: 'SettingMilestoneStatus' }" class="nav-link">
                                <i class="fas fa-cog nav-icon"></i>
                                <p>Milestone Status</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'SettingProjectStatus' }" class="nav-link">
                                <i class="fas fa-cog nav-icon"></i>
                                <p>Project Status</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'SettingTaskStatus' }" class="nav-link">
                                <i class="fas fa-cog nav-icon"></i>
                                <p>Task Status</p>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'SettingPassportToken' }" class="nav-link">
                                <i class="fas fa-cog nav-icon"></i>
                                <p>Passport Token</p>
                            </router-link>
                        </li>
                    </ul>
                </li>
                <!-- @endcan -->
                <li class="nav-item">
                    <router-link :to="{ name: 'UserProfilePage' }" class="nav-link">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>Profile</p>
                    </router-link>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>
<script>
export default {
    props: ['user'],
}
</script>
