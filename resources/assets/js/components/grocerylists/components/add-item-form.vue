<script>
    import Form from '../../../Form.js';

    export default {
        data(){
            return {
                form : new Form({
                    quantity          : '',
                    name              : '',
                    type              : '',
                    department_id     : '',
                }),
                departments : PepperRodeo.departments,
            }
        },

        methods : {
            addEvent(){
                this.$emit('add', this.form.data());
                this.form.reset();
            }
        }
    }
</script>

<template>
    <div class="item-section">
        <div class="items-inputs">
            <div class="ingredient-input">
                <label for="quantity" class="sub-heading">Qty</label>
                <input type="text" name="quantity" id="quantity" v-model="form.quantity" class="ingredient-info" placeholder="1" @keyup.enter="$emit('add')"/>
            </div>
            <div class="ingredient-input">
                <label for="type" class="sub-heading">Type</label>
                <input type="text" name="type" id="type" v-model="form.type" class="ingredient-info" placeholder="bottle" @keyup.enter="$emit('add')">
            </div>

            <div class="ingredient-input">
                <label for="item" class="sub-heading">Item</label>
                <input type="text" name="name" id="item" v-model="form.name" class="ingredient-info" placeholder="shampoo" @keyup.enter="$emit('add')"/>
            </div>

            <div class="ingredient-input">
                <label for="category" class="sub-heading dept-label">Department</label>
                <select name="department" v-model="form.department_id">
                    <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                </select>
            </div>
            <div class="add-wrapper ingredient-input">
                <button type="button" v-on:click="addEvent()" id="addItem" class="add-button"><i class="fa fa-plus-circle"></i></button>
                <button type="button" v-on:click="$emit('hide')" class="add-button"><i class="fa fa-times-circle-o"></i></button>
            </div>
        </div>
    </div>
</template>
