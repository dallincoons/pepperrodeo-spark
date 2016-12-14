module.exports = {

    data() {
        return {
            showCheckBoxes : false,
            recipes        : []
        };
    },

    created(){
        this.showCheckBoxes = (typeof PepperRodeo !== 'undefined' && PepperRodeo.showCheckBoxes == true);
    },
    toggleShowCheckBoxes(){
        this.showCheckBoxes = !this.showCheckBoxes;
    },

    methods : {

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
    },
};
