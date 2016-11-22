Vue.component('single-recipe', {
    data    : function () {
        return {
            recipeId          : PepperRodeo.recipe_id,
            grocerylists      : PepperRodeo.grocerylists,
            selectedList      : '',
            showListSelection : false
        }
    },
    methods : {
        addToGroceryList        : function () {
            this.$http.post('/grocerylist/' + this.selectedList + '/add/' + this.recipeId).then(function (response) {
                this.grocerylists = response.data.grocerylists;
                if(response.status === 200){
                    alert('you have successed');
                }
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
