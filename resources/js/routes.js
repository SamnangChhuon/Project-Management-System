import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let routes = [
    {
        path: '/dashboard',
        name: 'DashboardPage',
        component: require('./modules/mains/Dashboard.vue').default
    },
    {
        path: '/clients',
        name: 'ClientsPage',
        component: require('./modules/clients/Index.vue').default,
    },
    {
        path: '/client-details/:clientId',
        name: 'ClientDetailsPage',
        components: require('./modules/clients/details/Index.vue')
    },
    {
        path: '/contacts',
        name: 'ContactsPage',
        component: require('./modules/contacts/Index.vue').default
    },
    {
        path: '/milestones',
        name: 'MilestonesPage',
        component: require('./modules/milestones/Index.vue').default
    },
    {
        path: '/projects',
        name: 'ProjectsPage',
        component: require('./modules/projects/Index.vue').default
    },
    {
        path: '/project-details/:projectId',
        name: 'ProjectDetailsPage',
        component: require('./modules/projects/details/Index.vue').default
    },
    {
        path: '/tasks',
        name: 'TasksPage',
        component: require('./modules/tasks/Index.vue').default
    },
    {
        path: '/users-management',
        name: 'UsersManagementPage',
        component: require('./modules/users/managements/Users.vue').default
    },
    {
        path: '/user/profile',
        name: 'UserProfilePage',
        component: require('./modules/users/Profile.vue').default
    },

    /** Settings */
    {
        path: '/milestone-status',
        name: 'SettingMilestoneStatus',
        component: require('./modules/settings/MileStoneStatus.vue').default
    },
    {
        path: '/project-status',
        name: 'SettingProjectStatus',
        component: require('./modules/settings/ProjectStatus.vue').default
    },
    {
        path: '/task-status',
        name: 'SettingTaskStatus',
        component: require('./modules/settings/TaskStatus.vue').default
    },
    {
        path: '/passport-token',
        name: 'SettingPassportToken',
        component: require('./modules/settings/PassportToken.vue').default
    },
    /** 404 not found page */
    {
        path: '*',
        name: 'NotFoundPage',
        component: require('./errors/NotFound.vue').default
    }
];

const router = new VueRouter({
    mode: 'history',
    routes,  // short for `routes: routes`
    linkActiveClass: 'active'
})

router.beforeEach((to, from, next) => {
    // this.$Progress.start();

    next()
});

router.afterEach((to, from) => {
    // this.$Progress.finish();
})

export default router
