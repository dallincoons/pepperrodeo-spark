Vue.component('add-recipe', {
    data : function(){
        return {
            recipeItemElement : '<input type="text">',
            recipeItems : [''],
            addingCategory : false,
            categories : PepperRodeo.categories,
            selectedCategory : PepperRodeo.categories[0].id,
            newCategory : '',
            recipeFields : [],
            category_ids : []
        }
    },
    methods : {
        addNewItem() {
            this.recipeItems.push('');
        },
        addNewCategory() {
            this.categories.push({'name' : this.newCategory, 'id' : -1});
            this.selectedCategory = -1;
            this.addingCategory = false;
        }
    }
});