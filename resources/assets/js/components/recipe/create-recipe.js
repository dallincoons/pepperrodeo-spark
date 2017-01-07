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
                this.addNewDepartment();
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

        addNewDepartment() {
            let self = this;

            swal({
                    title               : "Add a department",
                    text                : "Organize your grocery list",
                    type                : "input",
                    showCancelButton    : true,
                    closeOnConfirm      : true,
                    animation           : "slide-from-top",
                    confirmButtonText   : "Save",
                    inputPlaceholder    : "Pharmacy",
                    showLoaderOnConfirm : true,
                    confirmButtonColor: "#ff4b2e",
                },
                function (inputValue) {
                    if( inputValue === false) {
                        return;
                    }

                    self.$http.post('/departments', JSON.stringify({
                        'name' : inputValue
                    })).then(response => {
                        self.departments = response.data;
                    }).catch(response => {
                        this.invalidRequest = true;
                    });
                });
        },

        removeItem(index) {
            this.recipeItems.splice(index, 1);
        },
    }
});
