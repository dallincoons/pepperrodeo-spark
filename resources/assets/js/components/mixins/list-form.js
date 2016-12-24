module.exports = {
    data () {
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
            newItemType       : '',
            newItemCategoryId : '',
            newItemId         : 0,
            groupByValue      : 'category',
        }
    },
    computed : {
        itemsGrouped : function () {
            let items = _.sortBy(this.items, this.groupByValue);
            return _.groupBy(items, this.groupByValue);
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
                this.newItemType == "" ||
                this.newItemCategoryId == ""){
                return;
            }

            let newItem = {
                id               : --this.newItemId,
                quantity         : this.newItemQty,
                name             : this.newItemName,
                type             : this.newItemType,
                item_category_id : this.newItemCategoryId,
                recipe_title     : 'Other',
                category         : this.categories[this.newItemCategoryId].name
            };

            this.items.push(newItem);

            this.newItemQty        = '';
            this.newItemName       = '';
            this.newItemType       = '';
            this.newItemCategoryId = '';
        },
        removeItem(itemId){
            this.items = _.without(this.items, _.findWhere(this.items, {
                id: itemId
            }));
            this.items.push({});
            this.items.pop();
        },
        removeAddedRecipe(recipeIndex){
            this.addedRecipes.splice(recipeIndex, 1);
        },
        addRecipes(recipeIds){
            let self = this,
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
        removeGroup(groupName){
            let self        = this;
            this.itemsGrouped[groupName].forEach(function(item){
                self.removeItem(item.id);
            });
        },
        toggleEdit(){
            this.editing = !this.editing;
        }
    }
};
