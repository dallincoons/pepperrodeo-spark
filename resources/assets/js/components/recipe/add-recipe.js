Vue.component('add-recipe', {
    data : function(){
        return {
            recipeItemElement : '<input type="text">',
            recipeItems : [{
                'quantity' : '',
                'type' : '',
                'ingredient' : '',
                'item_category_id' : ''
            }],
            addingCategory : false,
            categories : PepperRodeo.categories,
            selectedCategory : PepperRodeo.categories[0].id,
            newCategory : '',
            recipeFields : [],
            category_ids : [],
            item_quantity : '',
            item_type : '',
            item_ingredient : '',
        }
    },
    methods : {
        addNewItem() {
            this.recipeItems.unshift({
                'quantity' : '',
                'type' : '',
                'ingredient' : '',
                'item_category_id' : ''
            });
        },
        addNewCategory() {
            this.categories.push({'name' : this.newCategory, 'id' : -1});
            this.selectedCategory = -1;
            this.addingCategory = false;
        }
    }
});
