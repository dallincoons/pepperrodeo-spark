Vue.component('create-recipe', {
    data : function(){
        return {
            recipeItemElement : '<input type="text">',
            recipeItems : [],
            addingCategory : false,
            categories : PepperRodeo.categories || [],
            selectedCategory : PepperRodeo.categories[0] ? PepperRodeo.categories[0].id : '',
            newCategory : '',
            recipeFields : [],
            category_ids : [],
            item         : {},
            item_quantity : '',
            item_type : '',
            item_ingredient : '',
        }
    },
    methods : {
        addNewItem() {
            let newItem = this.item;

            if(
                newItem.quantity == "" ||
                newItem.type == "" ||
                newItem.name == "" ||
                newItem.item_category_id == ""
            ){
                return;
            }

            this.recipeItems.push(this.item);

            this.item = {};
        },
        addNewCategory() {
            this.categories.push({'name' : this.newCategory, 'id' : -1});
            this.selectedCategory = [-1, this.newCategory];
            this.addingCategory = false;
        }
    }
});
