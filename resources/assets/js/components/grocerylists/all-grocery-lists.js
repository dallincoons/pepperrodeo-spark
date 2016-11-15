Vue.component('all-grocery-lists', {
    data : function(){
        return {
            showCheckBoxes : false
        }
    },
    methods : {
        setShowCheckBoxes($bool){
            this.showCheckBoxes = $bool;
        },
        deleteLists : function(){
            document.getElementById("deleteForm").submit();
        }
    }
});
