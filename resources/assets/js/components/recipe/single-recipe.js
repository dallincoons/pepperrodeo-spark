Vue.component('single-recipe', {
    data    : function () {
        return {
            recipeId          : PepperRodeo.recipe_id,
            selectedList      : '',
            showListSelection : false
        }
    },
    methods : {
        addToGroceryList        : function () {
            this.$http.post('/grocerylist/' + this.selectedList + '/add/' + this.recipeId).then(function (response) {
                console.log(response.data);
            });
        },
        toggleShowListSelection : function () {
            this.showListSelection = !this.showListSelection;
        },
        submitDeleteRecipe      : function () {
            document.getElementById('recipe-delete').submit();
        }
    }
});
