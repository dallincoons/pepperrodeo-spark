let list_form = require('./mixins/list-form.js');

Vue.component('create-list', {
    mixins : [list_form],
    data() {
        return {
            editing : true,
            newItemId : 0
        }
    },
    methods : {
        addRecipes(recipeIds){
            let self = this,
                recipe;

            recipeIds.forEach(function (recipeId) {
                self.recipeIds.push(recipeId);
                self.addedRecipes.push(self.unaddedRecipes[recipeId]);
                recipe = self.unaddedRecipes[recipeId];

                recipe.items.forEach(function(item){
                    Vue.set(item, 'department_name', item.department.name);
                    Vue.set(item, 'toggleOptions', false);
                    Vue.set(item, 'editing', false);
                });

                self.items = Array.from(self.items).concat(recipe.items);

                self.recipesToAdd = [];
                delete self.unaddedRecipes[recipeId];
            });

            this.showRecipes = false;
        },

        addItem(){

            if(!this.form.validate()){
                return;
            }

            let newItem = {
                id               : --this.newItemId,
                name             : this.form.name,
                quantity         : parseInt(this.form.quantity),
                type             : this.form.type,
                department_id    : this.form.department_id,
                department_name  : this.departments[this.form.department_id].name,
                recipe_title     : 'Other',
                department       : this.departments[this.form.department_id],
                toggleOptions    : false,
                editing          : false
            };

            this.items.push(newItem);
            this.form.reset();
        },

        saveItemEdit(item){
            let og_item = _.findWhere(this.items, {id : item.id});

            og_item.raw_quantity = item.quantity;
            og_item.quantity = item.quantity;
            og_item.type = item.type;
            og_item.name = item.name;
            og_item.department_id = item.department_id;

            this.toggleItemEditing(og_item);
        },

        removeItemFromList(item){
            self.removeItemFromView(item);
        },

        submitListForm : function(){
            let $form = $('#list-form');

            if($form.parsley().validate()){
                this.$http.post('/grocerylist', {items : this.items, title : this.title})
                    .then(function(response){
                        window.location.href = '/grocerylist/' + response.data.grocerylist;
                    });
            }
        },

        deleteGroup(items){
            let self = this;
            items.forEach(function(item){
                self.removeItemFromView(item);
            });
        },
    }
});
