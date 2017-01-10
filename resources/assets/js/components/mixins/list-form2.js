module.exports = {
    data () {
        return {
            grocerylist       : PepperRodeo.grocerylist,
            items             : typeof PepperRodeo.grocerylist == 'object' ? PepperRodeo.grocerylist.items : [],
            title             : typeof PepperRodeo.grocerylist == 'object' ? PepperRodeo.grocerylist.title : '',
            addedRecipes      : typeof PepperRodeo.grocerylist == 'object' ? PepperRodeo.grocerylist.recipes : [],
            unaddedRecipes    : Object.assign({}, PepperRodeo.recipes),
            departments        : PepperRodeo.departments,
            showRecipes       : false,
            recipesToAdd      : [],
            addAnItem         : false,
            recipeFields      : [],
            recipeIds         : [],
            list_form_errors  : [],
            newItemName       : '',
            newItemQty        : '',
            newItemType       : '',
            newDepartmentId : '',
            newItemId         : 0,
            groupByValue      : 'department',
            toggledOption     : {}
        }
    },
    created(){
        this.items.forEach(function(item){
            Vue.set(item, 'toggleOptions', false);
        });

        this.items.forEach(function(item){
            Vue.set(item, 'editing', false);
        });
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
                this.newDepartmentId == ""){
                return;
            }

            let newItem = {
                id               : --this.newItemId,
                quantity         : this.newItemQty,
                name             : this.newItemName,
                type             : this.newItemType,
                department_id : this.newDepartmentId,
                recipe_title     : 'Other',
                department       : this.departments[this.newDepartmentId].name
            };

            this.items.push(newItem);

            this.newItemQty        = '';
            this.newItemName       = '';
            this.newItemType       = '';
            this.newDepartmentId = '';
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
        removeItemFromView(item){
            this.items = _.without(this.items, _.findWhere(this.items, {
                id : item.id
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
        toggleEdit(){
            this.editing = !this.editing;
        },

        toggleListOptions(item) {
            this.items.forEach(i => {
                if(i == item){
                    return;
                }
                Vue.set(i, 'toggleOptions', false);
            });
            document.body.addEventListener('click', this.closeListOptions);
            this.toggledOption = item;
            item.toggleOptions = !item.toggleOptions;
        },

        toggleItemEditing(item) {
            item.editing = !item.editing;
        },

        saveItemEdit(item) {
            this.$http.patch('/grocerylistitem/edit/' + item.id, {item : {'quantity' : item.quantity, 'type' : item.type, 'name' : item.name}})
                .then(function(response){
                    if(response.status == 200){
                        item.editing = false;
                    }
                });
        },

        closeListOptions(event){
            if(typeof event.toElement.dataset.type !== 'undefined' && event.toElement.dataset.type == 'toggle-list-option'){
                return
            }
            this.toggledOption.toggleOptions = false;
            document.body.removeEventListener('click', this.closeListOptions);
        },

        showEditItemModal() {
            $('#editItemModal').modal('show');
        },

        editItemView() {
            return "<input type='text' placeholder='qty'>";
        }
    }
};
