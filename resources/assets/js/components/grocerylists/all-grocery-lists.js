let all_lists = require('../mixins/all-lists-recipes.js');

Vue.component('all-grocery-lists', {
    mixins: [all_lists],

    data() {
        return {
            lists        : []
        };
    },

    methods : {

        deleteConfirmMessage(){

            let itemNames = '<p>Are you sure you want to delete these lists?</p>';

            this.lists.forEach(function(list){
                itemNames += "<p>" + JSON.parse(list).title + "</p>";
            });

            return itemNames;
        }
    }
});
