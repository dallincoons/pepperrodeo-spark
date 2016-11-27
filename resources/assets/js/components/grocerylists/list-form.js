Vue.component('list-form', {
    data     : function () {
        return {
            items             : PepperRodeo.items || [],
            title             : PepperRodeo.title,
            addedRecipes      : PepperRodeo.addedRecipes || [],
            unaddedRecipes    : Object.assign({}, PepperRodeo.recipes),
            categories        : PepperRodeo.categories,
            showRecipes       : false,
            recipesToAdd      : [],
            addAnItem         : false,
            recipeFields      : [],
            recipeIds         : [],
            list_form_errors  : [],
            newItemName       : '',
            newItemQty        : '',
            newItemCategoryId : '',
            newItemId         : 0,
            groupByValue      : 'category',
        }
    },
    computed : {
        itemsGrouped : function () {
            return window._.groupBy(this.items, this.groupByValue);
        }
    },
    methods  : {
        submitListForm : function(){
            this.validateForm();
            let $form = $('#list-form');

            if($form.parsley().validate() && this.noFormErrors()){
                $form.submit();
            }
        },
        validateForm : function(){
            if(this.items.length < 1){
                this.list_form_errors.push({
                    'reason' : 'No items added'
                });
                return;
            }

            this.list_form_errors = [];
        },
        noFormErrors : function(){
            return this.list_form_errors.length < 1;
        },
        setGroupBy(groupBy){
            this.groupByValue = groupBy;
        },
        setShowRecipes($bool) {
            this.showRecipes = $bool;
        },
        setAddAnItem($bool){
            this.addAnItem = $bool;
        },
        addItem(){

            if( this.newItemQty == "" ||
                this.newItemName == "" ||
                this.newItemCategoryId == ""){
                return;
            }

            var newItem = {
                id               : --this.newItemId,
                quantity         : this.newItemQty,
                name             : this.newItemName,
                item_category_id : this.newItemCategoryId,
                recipe_title     : 'Other',
                category         : this.categories[this.newItemCategoryId].name
            };

            this.items.push(newItem);

            this.newItemQty        = '';
            this.newItemName       = '';
            this.newItemCategoryId = '';
        },
        removeItem(itemId){
            window._.remove(this.items, function (item) {
                return item.id == itemId;
            });
            this.items.push({});
            this.items.pop();
        },
        removeAddedRecipe(recipeIndex){
            this.addedRecipes.splice(recipeIndex, 1);
        },
        addRecipes(recipeIds){
            var self = this,
                recipe;
            recipeIds.forEach(function (recipeId) {
                self.recipeIds.push(recipeId);
                self.addedRecipes.push(self.unaddedRecipes[recipeId]);
                recipe = self.unaddedRecipes[recipeId];

                self.items = Array.from(self.items).concat(recipe.items);

                self.recipesToAdd = [];
                delete self.unaddedRecipes[recipeId];
            });

            this.setShowRecipes(false);
        },
        removeRecipe(recipeId, index){
            var self        = this;
            var itemIndexes = [];
            self.items.forEach(function (item) {
                if (item.recipe_id == recipeId) {
                    itemIndexes.push(self.items.indexOf(item));
                }
            });
            itemIndexes = itemIndexes.sort(function (a, b) {
                return b - a
            });
            itemIndexes.forEach(function (index) {
                self.items.splice(index, 1);
            });
            self.removeAddedRecipe(index);
        }
    }
});
