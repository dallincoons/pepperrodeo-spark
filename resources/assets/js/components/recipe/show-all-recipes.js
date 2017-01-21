let all_recipes = require('../mixins/all-lists-recipes.js');
import GroupedList from './components/grouped-list.vue';
import DesktopNav from './components/desktop-nav.vue';
import RecipeMobileNav from './components/recipe-mobile-nav.vue';

Vue.component('show-all-recipes', {
    mixins: [all_recipes],

    components: { DesktopNav, RecipeMobileNav, GroupedList },

    data() {
        return {
            recipes          : PepperRodeo.recipes,
            selectedRecipes        : [],
            showListSelection : false,
            grocerylists : PepperRodeo.grocerylists
        };
    },

    computed : {

        recipesByCategory : function(){
            let recipes = _.sortBy(this.recipes, 'category_name');
            return _.groupBy(recipes, 'category_name');
        },

    },

    created() {

        Bus.$on('deleteRecipes', () => this.deleteRecipes());

        Bus.$on('addToGroceryList', (list) => this.addToGroceryList(list));

    },

    methods : {

        recipeUrl : function(recipeId){
            return `/recipe/${recipeId}`;
        },

        deleteConfirmMessage(){

            return '<p>Are you sure you want to permanently delete this?</p>';
        },

        addToGroceryList(list) {
            this.$http.post('/grocerylist/' + list.id + '/add', {recipes : this.selectedRecipes}).then(function (response) {
                if(response.status === 200){
                    swal({
                        title              : "",
                        text               : this.confirmMessage(list),
                        confirmButtonColor : "#DD6B55",
                        confirmButtonText  : "Ok",
                        closeOnConfirm     : true,
                        html               : true
                    });
                }
            });
        },

        confirmMessage(list) {
            return 'You have successfully added recipes to <a href="/grocerylist/' + list.id + '">' + list.title + '</a>';
        }
    },

});
