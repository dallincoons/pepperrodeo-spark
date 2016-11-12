Vue.component('all-grocery-lists', {
    methods : {
        deleteLists : function(){
            document.getElementById("deleteForm").submit();
        }
    }
});