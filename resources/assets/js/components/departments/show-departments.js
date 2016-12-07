Vue.component('show-departments', {
    data    : function () {
        return {
            departments : PepperRodeo.departments,
        }
    },
    methods : {
        removeDepartment : function(id){
            let index = _.findIndex(this.departments, {id : id}),
                self = this;

            swal({
                    title: "Hold on!",
                    text: "Are you sure you want to delete this department?",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                },
                function(){
                    self.departments.splice(index, 1);
                });
        },
        addDepartment : function(){
            let self = this;

            swal({
                    title: "Add a department",
                    text: "Do eeeet",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    confirmButtonText: "Save",
                    inputPlaceholder: "Write something",
                    showLoaderOnConfirm: true,
                },
                function(inputValue){

                    self.departments.push({id : -1, name : inputValue});

                    return false;
                });
        }
    }
});
