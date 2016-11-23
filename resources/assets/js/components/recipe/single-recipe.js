Vue.component('single-recipe', {
    data    : function () {
        return {
            recipe          : PepperRodeo.recipe,
            grocerylists      : PepperRodeo.grocerylists,
            selectedList      : '',
            showListSelection : false
        }
    },
    methods : {
        addToGroceryList        : function (list) {
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
        addConfirmMessage : function(list){
            return 'You have successfully added ' + this.recipe.title + ' to <a href="/grocerylist/' + list.id + '">' + list.title + '</a>';
        },
        toggleShowListSelection : function () {
            this.showListSelection = !this.showListSelection;
        },
        submitDeleteRecipe      : function () {
            document.getElementById('recipe-delete').submit();
        }
    }
});
