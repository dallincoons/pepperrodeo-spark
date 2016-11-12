
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Components
 |--------------------------------------------------------------------------
 |
 | Here we will load the Spark components which makes up the core client
 | application. This is also a convenient spot for you to load all of
 | your components that you write while building your applications.
 */

require('./../spark-components/bootstrap');

/* Recipes */
require('./home');
require('./recipe/add-recipe');
require('./recipe/show-single');
require('./recipe/show-all');
require('./recipe/edit-single');

/* Grocery Lists */
require('./grocerylists/all-grocery-lists');
require('./grocerylists/create-grocery-list');
require('./grocerylists/edit-grocery-list');
require('./grocerylists/single-list');