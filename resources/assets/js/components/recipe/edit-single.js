Vue.component('edit-single-recipe', {
    data : function(){
        return {
            recipeItemElement : '<input type="text">',
            addingCategory : false,
            categories : PepperRodeo.categories,
            selectedCategory : PepperRodeo.selectedCategory,
            recipeItems : PepperRodeo.recipeItems,
            recipeFields : [],
            category_ids : [],
            newCategory : '',
        }
    },
    created(){
        this.intializeRecipeItems();
    },
    methods : {
        addNewItem() {
            this.recipeItems.push('');
        },
        addNewCategory() {
            this.categories.push({'name' : this.newCategory, 'id' : -1});
            this.selectedCategory = -1;
            this.addingCategory = false;
        },
        intializeRecipeItems(){
            var self = this,
                index = 0;
            this.recipeItems.forEach(function(item){
                self.recipeFields[index] = {};
                self.recipeFields[index].qty = item.quantity;
                self.recipeFields[index].type = item.type;
                self.recipeFields[index].name = item.name;
            });
        }
    }
});