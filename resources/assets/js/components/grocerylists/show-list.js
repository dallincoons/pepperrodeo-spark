let list_form = require('./mixins/list-form.js');
let AddItemForm = require('./components/add-item-form.vue');
let GroupedGroceryLists = require('./components/grouped-grocery-lists.vue');
let ListItemGroupByMenu = require('./components/list-item-group-by-menu.vue');

Vue.component('show-list', {
    mixins : [list_form],
    components : {AddItemForm, GroupedGroceryLists, ListItemGroupByMenu},
    data() {
        return {
            editing : false,
        }
    },

    mounted(){
        Bus.$on('deleteGroup', items => {
            this.deleteGroup(items);
        });

        //Add margin top dynamically to grocery list form
        $('#list-form').css("margin-top", $("#list_header").height() + 'px');
    },

    methods : {
        saveTitle() {
            this.$http.patch('/grocerylist/' + this.grocerylist.id, {title : this.title}).then((response) => {
                this.editing = false;
            });
        },

        submitDeleteList : function(){
            document.getElementById('list-delete').submit();
        },

        addItem(item){

            let newItem = {
                name             : item.name,
                quantity         : parseInt(item.quantity),
                type             : item.type,
                department_id    : item.department_id,
                department_name  : this.departments[item.department_id].name,
                recipe_title     : 'Other',
                department       : this.departments[item.department_id]
            };

            this.$http.post(`/grocerylist/${this.grocerylist.id}/item`, item)
                .then(response => {
                    this.items.push(newItem);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        saveItemEdit(item) {
            this.$http.patch('/grocerylistitem/edit/' + item.id, {'quantity' : item.quantity, 'type' : item.type, 'name' : item.name, 'department_id' : item.department.id})
                .then(function(response){
                    if(response.status == 200){
                        this.items.forEach(i => {
                            if(i.id == item.id){
                                i.department_name = this.departments[item.department.id].name;
                                i.quantity = item.quantity;
                                i.type = item.type;
                                i.name = item.name;
                                i.editing = false;
                            }
                        });
                    }
                });
        },

        addRecipes(recipeIds){
            let self = this,
                recipe;

            self.$http.post('/grocerylist/' + self.grocerylist.id + '/recipe', {recipes : recipeIds})
                .then(response => {
                    recipeIds.forEach(function (recipeId) {
                        self.recipeIds.push(recipeId);
                        self.addedRecipes.push(self.unaddedRecipes[recipeId]);
                        recipe = self.unaddedRecipes[recipeId];

                        recipe.items.forEach(function(item){
                            Vue.set(item, 'department_name', item.department.name);
                        });

                        self.items = Array.from(self.items).concat(recipe.items);

                        self.recipesToAdd = [];
                        delete self.unaddedRecipes[recipeId];
                    });
                });

            this.showRecipes = false;
        },

        removeItemFromList(item){
            let self = this;

            swal({
                    title              : "Hold on!",
                    text               : "Are you sure you want to remove " + item.name + " from this grocery list?",
                    showCancelButton   : true,
                    confirmButtonColor : "#DD6B55",
                    confirmButtonText  : "Yes",
                    closeOnConfirm     : true
                },
                function () {
                    self.$http.post('/grocerylistitem/remove', {grocerylist : self.grocerylist.id, itemIds : [item.id]})
                        .then(function(response){
                            if(response.status == 200) {
                                self.removeItemFromView(item);
                            }
                        });
                });
        },

        deleteGroup(items){
            let self = this;
            this.$http.post('/grocerylistitem/remove', {grocerylist : this.grocerylist.id, itemIds : _.pluck(items, 'id')})
                .then(function(response){
                    if(response.status == 200){
                        items.forEach(function(item){
                            self.removeItemFromView(item);
                        });
                    }
                });
        },
    }
});
