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
            this.$http.post('/grocerylist/' + list.id + '/add/' + this.recipe.id).then(function (response) {
                this.grocerylists = response.data.grocerylists;
                if(response.status === 200){
                    swal({
                        title              : "",
                        text               : this.addConfirmMessage(list),
                        confirmButtonColor : "#DD6B55",
                        confirmButtonText  : "Ok",
                        closeOnConfirm     : true,
                        html               : true
                    });
                }
            });
        },
    },

});
