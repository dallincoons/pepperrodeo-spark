Vue.component('show-all-recipes', {
    data    : function () {
        return {
            showCheckBoxes : false,
            recipes        : []
        }
    },

    created(){
        this.showCheckBoxes = (typeof PepperRodeo !== 'undefined' && PepperRodeo.showCheckBoxes == true);
    },

    methods : {
        toggleShowCheckBoxes(){
            this.showCheckBoxes = !this.showCheckBoxes;
        },
        deleteRecipes : function () {

            swal({
                    title              : "",
                    text               : this.deleteConfirmMessage(),
                    showCancelButton   : true,
                    confirmButtonColor : "#DD6B55",
                    confirmButtonText  : "Yes",
                    closeOnConfirm     : true,
                    html               : true
                },
                function () {
                    document.getElementById("deleteForm").submit();
                });
        },

        deleteConfirmMessage(){

            var recipeNames = '<p>Are you sure you want to delete these recipes?</p>';

            this.recipes.forEach(function (recipe) {
                recipeNames += "<p>" + JSON.parse(recipe).title + "</p>";
            });

            return recipeNames;
        }
    },

});
