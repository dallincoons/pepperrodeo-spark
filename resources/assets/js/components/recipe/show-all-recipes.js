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

        this.recipes.forEach(function(item){
            Vue.set(item, 'toggleOptions', false);
        });

        Bus.$on('deleteRecipes', () => this.deleteRecipes());

        Bus.$on('addToGroceryList', (list) => this.addToGroceryList(list));

    },

    methods : {

        deleteRecipe(recipe){
            let self = this;

            this.$http.delete(`recipe/${recipe.id}`)
                .then((response) => {
                    self.removeItemFromView(recipe);
                });
        },

        deleteGroup(items){
            if(!items.length){
                return;
            }

            let categoryId = items[0].category.id;
            let self = this;

            this.$http.delete('recipe/categories/' + categoryId)
                .then((response) => {
                    items.forEach(function(item){
                        self.removeItemFromView(item);
                    });
                });
        },

        removeItemFromView(item){
            this.recipes = _.without(this.recipes, _.findWhere(this.recipes, {
                id : item.id
            }));
            this.recipes.push({});
            this.recipes.pop();
        },

        recipeUrl : function(recipeId){
            return `/recipe/${recipeId}`;
        },

        recipeEditUrl : function(recipeId){
            return `/recipe/${recipeId}/edit`;
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
        },

        toggleListOptions(recipe) {
            this.recipes.forEach(r => {
                r.toggleOptions = false;
                if(r.id == recipe.id){
                    this.toggledOption = r;
                    r.toggleOptions = true;
                }
            });
            document.body.addEventListener('click', this.closeListOptions);
        },

        closeListOptions(event){
            if(typeof event.toElement.dataset.type !== 'undefined' && event.toElement.dataset.type == 'toggle-list-option'){
                return
            }
            this.toggledOption.toggleOptions = false;
            document.body.removeEventListener('click', this.closeListOptions);
        },
    },

});
