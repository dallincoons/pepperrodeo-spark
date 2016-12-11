Vue.component('all-recipe-categories', {
    data    : function () {
        return {
            recipe_categories : PepperRodeo.recipe_categories,
            invalidRequest    : false
        }
    },
    methods : {
        removeCategory : function (id) {
            let self = this;

            swal({
                    title              : "Hold on!",
                    text               : "Are you sure you want to delete this category?",
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
            self.$http.delete('recipecategory/' + id, {params : {force : force}}).then(response => {
                if (response.status == 290) {
                    swal({
                            title              : "There are items still associated with this category",
                            text               : "Do you want to delete all associated items?",
                            showCancelButton   : true,
                            confirmButtonColor : "#DD6B55",
                            confirmButtonText  : "Yes, nuke 'em!",
                            closeOnConfirm     : true
                        },
                        function () {
                            self.sendRemoveRequest(id, 'true');
                        });
                } else if (response.status = 200) {
                    self.recipe_categories = response.data;
                }
            }).catch(response => {
                //
            });
        },
        addCategory    : function () {
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
                    self.$http.post('recipecategory', JSON.stringify({
                        'name' : inputValue
                    })).then(response => {
                        self.recipe_categories = response.data;
                    }).catch(response => {
                        this.invalidRequest = true;
                    });
                });
        }
    }
});