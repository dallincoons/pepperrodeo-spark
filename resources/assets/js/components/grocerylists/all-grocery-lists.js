Vue.component('all-grocery-lists', {
    data    : function () {
        return {
            showCheckBoxes : false,
            lists          : []
        }
    },
    methods : {
        setShowCheckBoxes($bool){
            this.showCheckBoxes = $bool;
        },
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

            var itemNames = '<p>Are you sure you want to delete these lists?</p>';

            this.lists.forEach(function(list){
                itemNames += "<p>" + JSON.parse(list).title + "</p>";
            });

            return itemNames;
        }
    }
});
