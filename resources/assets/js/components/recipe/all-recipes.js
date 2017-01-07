let all_recipes = require('../mixins/all-lists-recipes.js');

Vue.component('show-all-recipes', {
    mixins: [all_recipes],

    data() {
        return {
            recipes        : [],
            showListSelection : false,
            grocerylists : PepperRodeo.grocerylists
        };
    },

    methods : {

        deleteConfirmMessage(){

            let recipeNames = '<p>Are you sure you want to delete these recipes?</p>';

            this.recipes.forEach(function (recipe) {
                recipeNames += "<p>" + JSON.parse(recipe).title + "</p>";
            });

            return recipeNames;
        },

        addToGroceryList(list) {
            this.$http.post('/grocerylist/' + list.id + '/add', {recipes : this.recipes}).then(function (response) {
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
