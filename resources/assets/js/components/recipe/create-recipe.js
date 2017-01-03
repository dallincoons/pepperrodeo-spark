Vue.component('create-recipe', {

    data : function(){

        return {
            recipeItemElement : '<input type="text">',
            recipeItems : [],
            addingCategory : false,
            addingDepartment : false,
            categories : PepperRodeo.categories || [],
            departments : PepperRodeo.departments || [],
            selectedCategory : PepperRodeo.categories[0] ? PepperRodeo.categories[0].id : '',
            newCategory : '',
            newDepartment : '',
            newDepartmentId : -1,
            recipeFields : [],
            item         : {},
            showNewItemInputs : true
        }

    },

    methods : {

        checkAddNew(id){
            if(id == 0){
                this.addingDepartment = true;
            }
        },

        addNewItem() {
            let newItem = this.item;

            if(
                !newItem.quantity ||
                !newItem.type ||
                !newItem.name ||
                !newItem.department_id
            ){
                return;
            }

            this.recipeItems.push(this.item);

            this.item = {};
        },

        addNewDepartment() {
            this.departments.push({id : this.newDepartmentId, name : this.newDepartment});
            this.item.department_id = this.newDepartmentId;
            this.item.department_name = this.newDepartment;

            this.addingDepartment = false;

            this.newDepartmentId--;
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
