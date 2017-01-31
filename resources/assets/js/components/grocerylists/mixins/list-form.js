import Form from '../../../Form.js';

module.exports = {
    data () {
        return {
            grocerylist       : PepperRodeo.grocerylist,
            items             : typeof PepperRodeo.grocerylist == 'object' ? PepperRodeo.grocerylist.items : [],
            title             : typeof PepperRodeo.grocerylist == 'object' ? PepperRodeo.grocerylist.title : '',
            departments        : PepperRodeo.departments,
            addedRecipes      : typeof PepperRodeo.grocerylist == 'object' ? PepperRodeo.grocerylist.recipes : [],
            unaddedRecipes    : Object.assign({}, PepperRodeo.recipes),
            showRecipes       : false,
            recipesToAdd      : [],
            addAnItem         : false,
            recipeIds         : [],
            groupByValue      : 'department_name',
            toggledOption     : {}
        }
    },

    computed : {
        itemsGrouped : function () {
            let items = _.sortBy(this.items, this.groupByValue);
            if(this.shouldCombine()){
                items = this.combineItems();
            }
            return _.groupBy(items, this.groupByValue);
        }
    },

    methods  : {

        removeItemFromView(item){
            this.items = _.without(this.items, _.findWhere(this.items, {
                id : item.id
            }));
            this.items.push({});
            this.items.pop();
        },
    }
};
