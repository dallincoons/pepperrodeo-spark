<script>
    import listForm from '../mixins/list-form.js';

    export default {
        mixins : [listForm],
        data() {
            return {
                addAnItem         : false,
            }
        },
        methods : {
            emitShowRecipes(){
                this.$emit('show-recipes');
            },
            addItem(){

                let newItem = {
                    id               : --this.newItemId,
                    name             : this.form.name,
                    quantity         : parseInt(this.form.quantity),
                    type             : this.form.type,
                    department_id    : this.form.department_id,
                    department_name  : this.departments[this.form.department_id].name,
                    recipe_title     : 'Other',
                    department       : this.departments[this.form.department_id]
                };

                this.form.submit('post', `/grocerylist/${this.grocerylist.id}/item`)
                    .then(response => {
                        this.items.push(newItem);
                        this.form.reset();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
</script>

<template>
    <div>
        <div class="centering-buttons">
            <a v-on:click="emitShowRecipes()" class="create-list-option hide-options"><i class="fa fa-plus-circle"></i> Add a recipe</a>
            <a v-on:click="addAnItem = true" class="create-list-option hide-options"><i class="fa fa-plus-circle"></i> Add an item</a>
            <a class="create-list-option hide-options" onClick="window.print()"><i class="fa fa-print"></i> Printer Friendly</a>
        </div>
        <div class="item-section" v-if="addAnItem">
            <div class="items-inputs">
                <div class="ingredient-input">
                    <label for="quantity" class="sub-heading">Qty</label>
                    <input type="text" id="quantity" v-model="form.quantity" name="'recipeFields[' + index + '][quantity]'" class="ingredient-info" placeholder="1" @keyup.enter="addItem(recipeFields)"/>
                </div>

                <div class="ingredient-input">
                    <label for="type" class="sub-heading">Type</label>
                    <input type="text" id="type" v-model="form.type" name="'recipeFields[' + index + '][type]'" class="ingredient-info" placeholder="bottle" @keyup.enter="addItem(recipeFields)">
                </div>

                <div class="ingredient-input">
                    <label for="item" class="sub-heading">Item</label>
                    <input type="text" id="item" v-model="form.name" name="'recipeFields[' + index + '][name]'" class="ingredient-info" placeholder="shampoo" @keyup.enter="addItem(recipeFields)"/>
                </div>
                <div class="ingredient-input">
                    <label for="category" class="sub-heading dept-label">Department</label>
                    <select name="category" v-model="form.department_id">
                        <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                    </select>
                </div>
                <div class="add-wrapper ingredient-input">
                    <button type="button" v-on:click="addItem(recipeFields)" class="add-button"><i class="fa fa-plus-circle"></i></button>
                    <button type="button" v-on:click="addAnItem = false" class="add-button"><i class="fa fa-times-circle-o"></i></button>
                </div>
            </div>
        </div>
    </div>
</template>