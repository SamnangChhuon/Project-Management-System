import Vue from 'vue'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component(
    'content-header',
    require('./ui/ContentHeader.vue').default
);

Vue.component(
    'ui-navbar',
    require('./ui/Navbar.vue').default
);

Vue.component(
    'ui-sidebar',
    require('./ui/Sidebar.vue').default
);

Vue.component(
    'ui-footer',
    require('./ui/Footer.vue').default
);

Vue.component(
    'passport-clients',
    require('./passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./../errors/NotFound.vue').default
);

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
