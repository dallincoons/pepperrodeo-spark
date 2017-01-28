let list_form = require('../mixins/list-form.js');
import Form from '../../Form.js';

Vue.component('create-list', {
    mixins : [list_form],
    data() {
        return {
            editing : true,
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

            console.log(this.form.department_id);
            console.log(this.departments);

            let newItem = {
                id               : --this.newItemId,
                name             : this.form.name,
                quantity         : parseInt(this.form.quantity),
                type             : this.form.type,
                department_id    : this.form.department_id,
                department_name  : this.departments[this.form.department_id].name,
                recipe_title     : 'Other',
                department       : this.departments[this.form.department_id]
            };

            this.items.push(newItem);
            this.form.reset();
        },
        submitListForm : function(){
            this.validateForm();
            let $form = $('#list-form');

            console.log(this.items);

            if($form.parsley().validate() && this.noFormErrors()){
                this.$http.post('/grocerylist', {items : this.items, title : this.title})
                    .then(function(response){
                        window.location.href = '/grocerylist/' + response.data.grocerylist;
                    });
            }
        },
    }
});
