let all_recipes = require('../mixins/all-lists-recipes.js');

Vue.component('show-all-recipes', {
    mixins: [all_recipes],

    data() {
        return {
            recipes        : []
        };
    },

    methods : {

        deleteConfirmMessage(){

            let recipeNames = '<p>Are you sure you want to delete these recipes?</p>';

            this.recipes.forEach(function (recipe) {
                recipeNames += "<p>" + JSON.parse(recipe).title + "</p>";
            });

            return recipeNames;
        }
    },

});
