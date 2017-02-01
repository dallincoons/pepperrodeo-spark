Vue.component('edit-single-recipe', {

    data : function(){
        return {
            recipeItemElement : '<input type="text">',
            addingCategory : false,
            categories : PepperRodeo.categories,
            departments : PepperRodeo.departments || [],
            selectedCategory : PepperRodeo.selectedCategory,
            recipeItems : PepperRodeo.recipeItems,
            recipeFields : [],
            item         : {},
            category_ids : [],
            newCategory : '',
            newDepartment : '',
            showNewItemInputs : false
        }
    },
    created(){
        this.intializeRecipeItems();
    },


    methods : {

        addCategory    : function () {
            let self = this;

            swal({
                    title               : "Add a Category",
                    text                : "Organize your recipes",
                    type                : "input",
                    showCancelButton    : true,
                    closeOnConfirm      : true,
                    animation           : "slide-from-top",
                    confirmButtonText   : "Save",
                    inputPlaceholder    : "Produce",
                    showLoaderOnConfirm : true,
                    confirmButtonColor: "#ff4b2e",
                },
                function (inputValue) {
                    if( inputValue === false) {
                        return;
                    }

                    self.$http.post('/recipe/categories', JSON.stringify({
                        'name' : inputValue
                    })).then(response => {
                        self.categories = response.data;
                }).catch(response => {
                        this.invalidRequest = true;
                });
                });
        },

        addNewItem() {
            this.recipeItems.push(this.item);

            this.item = {};
        },

        removeItem(index) {
            this.recipeItems.splice(index, 1);
        },

        addNewCategory() {
            this.categories.push({'name' : this.newCategory, 'id' : -1});
            this.selectedCategory = [-1,this.newCategory];
            this.addingCategory = false;
        },

        addDepartment() {
            this.departments.push({id : -1, name : this.newDepartment});
        },

        intializeRecipeItems(){
            let self = this,
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
