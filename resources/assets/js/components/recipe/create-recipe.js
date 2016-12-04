Vue.component('create-recipe', {

    data : function(){

        return {
            recipeItemElement : '<input type="text">',
            recipeItems : [],
            addingCategory : false,
            addingItemCategory : false,
            categories : PepperRodeo.categories || [],
            itemCategories : PepperRodeo.itemCategories || [],
            selectedCategory : PepperRodeo.categories[0] ? PepperRodeo.categories[0].id : '',
            newCategory : '',
            newItemCategory : '',
            newItemCategoryId : -1,
            recipeFields : [],
            item         : {},
            showNewItemInputs : true
        }

    },

    methods : {

        checkAddNew(id){
            if(id == 0){
                this.addingItemCategory = true;
            }
        },

        addNewItem() {
            let newItem = this.item;

            if(
                !newItem.quantity ||
                !newItem.type ||
                !newItem.name ||
                !newItem.item_category_id
            ){
                return;
            }

            this.recipeItems.push(this.item);

            this.item = {};
        },

        addNewItemCategory() {
            this.itemCategories.push({id : this.newItemCategoryId, name : this.newItemCategory});

            this.item.item_category_id = this.newItemCategoryId;
            this.item.item_category_name = this.newItemCategory;

            this.addingItemCategory = false;

            this.newItemCategoryId--;
        },

        removeItem(index) {
            this.recipeItems.splice(index, 1);
        },


        addNewCategory() {
            this.categories.push({'name' : this.newCategory, 'id' : -1});
            this.selectedCategory = [-1, this.newCategory];
            this.addingCategory = false;
        }
    }
});
