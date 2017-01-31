module.exports = {

    data() {
        return {
            showCheckBoxes : false,
            recipes        : []
        };
    },

    mounted(){
        Bus.$on('deleteGroup', items => {
            this.deleteGroup(items);
        });
    },

    created(){
        this.showCheckBoxes = (typeof PepperRodeo !== 'undefined' && PepperRodeo.showCheckBoxes == true);
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
        toggleShowCheckBoxes(){
            this.showCheckBoxes = !this.showCheckBoxes;
        },
    },
};
