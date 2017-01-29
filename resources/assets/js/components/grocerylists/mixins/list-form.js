import Form from '../../../Form.js';

module.exports = {
    data () {
        return {
            grocerylist       : PepperRodeo.grocerylist,
            items             : typeof PepperRodeo.grocerylist == 'object' ? PepperRodeo.grocerylist.items : [],
            title             : typeof PepperRodeo.grocerylist == 'object' ? PepperRodeo.grocerylist.title : '',
            departments        : PepperRodeo.departments,
            form              : new Form({
                quantity          : '',
                name              : '',
                type              : '',
                department_id     : '',
            }),
            addedRecipes      : typeof PepperRodeo.grocerylist == 'object' ? PepperRodeo.grocerylist.recipes : [],
            unaddedRecipes    : Object.assign({}, PepperRodeo.recipes),
            showRecipes       : false,
            recipesToAdd      : [],
            addAnItem         : false,
            recipeFields      : [],
            recipeIds         : [],
            groupByValue      : 'department_name',
            toggledOption     : {}
        }
    },
    created(){
        this.items.forEach(function(item){
            Vue.set(item, 'toggleOptions', false);
            Vue.set(item, 'editing', false);
            Vue.set(item, 'department_name', item.department.name);
        });
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
        shouldCombine(){
            return this.groupByValue == 'department_name';
        },
        combineItems() {
            let items = this.items;
            let newItems = [];

            items.forEach((item) => {
                if(!_.findWhere(newItems, {department_name : item.department_name, name : item.name, type : item.type})) {
                    let likeItems = (_.where(items, {
                        department_name : item.department_name,
                        name            : item.name,
                        type            : item.type
                    }));
                    let newItem = Object.assign({}, item);
                    newItem.quantity = _.reduce(_.pluck(likeItems, 'quantity'), (a, b) => a + b, 0);
                    newItems.push(newItem);
                }
            });

            return newItems;
        },

        removeItemFromView(item){
            this.items = _.without(this.items, _.findWhere(this.items, {
                id : item.id
            }));
            this.items.push({});
            this.items.pop();
        },

        toggleListOptions(item) {
            this.items.forEach(i => {
                i.toggleOptions = false;
                if(i.id == item.id){
                    this.toggledOption = i;
                    i.toggleOptions = true;
                }
            });
            document.body.addEventListener('click', this.closeListOptions);
        },

        closeListOptions(event){
            if(typeof event.toElement.dataset.type !== 'undefined' && event.toElement.dataset.type == 'toggle-list-option'){
                return
            }
            this.toggledOption.toggleOptions = false;
            document.body.removeEventListener('click', this.closeListOptions);
        },

        toggleItemEditing(item) {
            this.items.forEach(i => {
                if(i.id == item.id){
                    this.toggledOption = i;
                    i.editing = !i.editing;
                }
            });
        },

    }
};
