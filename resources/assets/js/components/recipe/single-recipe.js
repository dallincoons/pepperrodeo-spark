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
            this.$http.post('/grocerylist/' + list.id + '/add', {recipes : [list.id]}).then(function (response) {
                if(response.status === 200){
                    this.removeGroceryList(list);
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

        removeGroceryList(list){
            this.grocerylists = _.without(this.grocerylists, _.findWhere(this.grocerylists, {
                id: list.id
            }));
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
