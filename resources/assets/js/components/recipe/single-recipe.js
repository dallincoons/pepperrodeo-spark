import MiniNavOptions from './components/mini-nav-options.vue';

Vue.component('single-recipe', {

    components : {MiniNavOptions},

    data    : function () {
        return {
            recipe          : PepperRodeo.recipe,
            grocerylists      : PepperRodeo.grocerylists,
            selectedList      : '',
            showListSelection : false
        }
    },

    created() {

        Bus.$on('toggleShowListSelection', () => this.toggleShowListSelection());

    },

    methods : {

        toggleShowListSelection : function () {
            this.showListSelection = !this.showListSelection;
        },

        addToGroceryList        : function (list) {
            this.$http.post('/grocerylist/' + list.id + '/add', {grocerylist : list.id, recipes : [this.recipe.id]}).then(function (response) {
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

    }
});
