Vue.component('create-grocery-list', {
    data     : function () {
        return {
            showRecipes       : false,
            addAnItem         : false,
            recipes           : PepperRodeo.recipes,
            unaddedRecipes    : Object.assign({}, PepperRodeo.recipes),
            categories        : PepperRodeo.categories,
            addedRecipes      : [],
            recipesToAdd      : [],
            items             : [],
            recipeIds         : [],
            recipeFields      : [],
            title             : '',
            newItemName       : '',
            newItemQty        : '',
            newItemCategoryId : '',
            groupByValue      : 'category',
            computedTest      : ''
        }
    },
    computed : {
        itemsGrouped : function () {
            return window._.groupBy(this.items, this.groupByValue);
        }
    },
    created(){
        console.log(this.categories);
    },
    methods  : {
        setShowRecipes($bool) {
            this.showRecipes = $bool;
        },
        setGroupBy(groupBy){
            this.groupByValue = groupBy;
        },
        setAddAnItem($bool){
            this.addAnItem = $bool;
        },
        groupBy(groupValue){
            this.groupBy      = groupValue;
            this.itemsGrouped = window._.groupBy(this.itemsGrouped, groupValue);
        },
        addItem(){
            var newItem = {
                quantity         : this.newItemQty,
                name             : this.newItemName,
                item_category_id : this.newItemCategoryId,
                recipe_title     : 'Other',
                category : this.categories[this.newItemCategoryId].name
            };
            this.items.push(newItem);

            this.newItemQty        = '';
            this.newItemName       = '';
            this.newItemCategoryId = '';
        },
        removeItem(itemId){
            window._.remove(this.items, function(item){
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
            self.recipeIds.splice(recipeId, 1);
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
