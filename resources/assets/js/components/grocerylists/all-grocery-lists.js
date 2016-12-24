let all_lists = require('../mixins/all-lists-recipes.js');

Vue.component('all-grocery-lists', {
    mixins: [all_lists],

    data() {
        return {
            lists        : []
        };
    },

    methods : {

        deleteLists : function () {

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

            let itemNames = '<p>Are you sure you want to delete these lists?</p>';

            this.lists.forEach(function(list){
                itemNames += "<p>" + JSON.parse(list).title + "</p>";
            });

            return itemNames;
        }
    }
});
