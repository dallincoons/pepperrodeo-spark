Vue.component('desktop-nav', {
    methods : {
        toggleDeleteRecipes(){
            Bus.$emit('toggleDeleteRecipes');
        }
    }

});
