Vue.component('recipe-mobile-nav', {

    methods : {
        deleteRecipes : function(){
            Bus.$emit('deleteRecipes');
        }
    },

    template : `<nav class="mini-nav">
                 <ul class="mini-nav-options">
                     <li><a href="/recipe/create"><i class="fa fa-plus"></i></a></li>
                     <li v-on:click="showListSelection = !showListSelection"><i class="fa fa-shopping-cart"></i></li>
                     <li><a v-on:click="deleteRecipes()"><i class="fa fa-trash"></i></a></li>
                 </ul>
            </nav>`
});
