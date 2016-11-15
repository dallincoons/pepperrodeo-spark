Vue.component('show-all-recipes', {
    data : function(){
        return {
            showCheckBoxes : false
        }
    },
    methods : {
        setShowCheckBoxes($bool){
            this.showCheckBoxes = $bool;
        },
        deleteRecipes : function(){
            document.getElementById("deleteForm").submit();
        }
    },

});
