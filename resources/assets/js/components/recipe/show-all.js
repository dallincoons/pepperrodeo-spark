Vue.component('show-all-recipes', {
    methods : {
        deleteRecipes : function(){
            document.getElementById("deleteForm").submit();
        }
    }
});
