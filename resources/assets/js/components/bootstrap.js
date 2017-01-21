/*
 |--------------------------------------------------------------------------
 | Laravel Spark Components
 |--------------------------------------------------------------------------
 |
 | Here we will load the Spark components which makes up the core client
 | application. This is also a convenient spot for you to load all of
 | your components that you write while building your applications.
 */

if (window.Vue === undefined) {
    window.Vue = require('vue');

    window.Bus = new Vue();
}

require('./../spark-components/bootstrap');

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

/* Lists */
require('./recipe/components/recipe-mobile-nav.vue');
require('./recipe/components/desktop-nav.vue');
require('./recipe/components/mini-nav-options.vue');

/* Recipes */
require('./home');
require('./recipe/create-recipe');
require('./recipe/single-recipe');
require('./recipe/show-all-recipes');
require('./recipe/edit-recipe');

/* Grocery Lists */
require('./grocerylists/all-grocery-lists');
require('./grocerylists/show-list');
require('./grocerylists/create-list');

require('./departments/show-departments');

require('./recipe_categories/all-recipe-categories');
