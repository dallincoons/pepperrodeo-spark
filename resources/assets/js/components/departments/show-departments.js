Vue.component('show-departments', {
    data    : function () {
        return {
            departments       : PepperRodeo.departments,
            invalidRequest : false
        }
    },
    methods : {
        removeDepartment : function (id) {
            let self  = this;

            swal({
                    title              : "Hold on!",
                    text               : "Are you sure you want to delete this department?",
                    showCancelButton   : true,
                    confirmButtonColor : "#DD6B55",
                    confirmButtonText  : "Yes, delete it!",
                    closeOnConfirm     : true
                },
                function () {
                    self.sendRemoveRequest(id, 'false');
                });
        },
        sendRemoveRequest(id, force){
            let self = this;
            self.$http.delete('departments/' + id, {params : {force : force}}).then(response => {
                if(response.status == 290){
                    swal({
                            title              : "There are items still associated with this department",
                            text               : "Do you want to delete all associated items?",
                            showCancelButton   : true,
                            confirmButtonColor : "#DD6B55",
                            confirmButtonText  : "Yes, nuke 'em!",
                            closeOnConfirm     : true
                        },
                        function () {
                            self.sendRemoveRequest(id, 'true');
                        });
                }else if(response.status = 200){
                    self.departments = response.data;
                }
            }).catch(response => {
                //
            });
        },
        addDepartment    : function () {
            let self = this;

            swal({
                    title               : "Add a department",
                    text                : "Do eeeet",
                    type                : "input",
                    showCancelButton    : true,
                    closeOnConfirm      : true,
                    animation           : "slide-from-top",
                    confirmButtonText   : "Save",
                    inputPlaceholder    : "Write something",
                    showLoaderOnConfirm : true,
                },
                function (inputValue) {
                    self.$http.post('departments', JSON.stringify({
                        'name' : inputValue
                    })).then(response => {
                        self.departments = response.data;
                    }).catch(response => {
                        this.invalidRequest = true;
                    });
                });
        }
    }
});
