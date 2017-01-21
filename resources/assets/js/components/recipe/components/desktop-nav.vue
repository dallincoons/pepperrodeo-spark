<script>
    export default {
        props : ['grocerylists'],

        data() {
            return {
                showListSelection : false
            }
        },

        methods : {
            addToGroceryList(list){

                Bus.$emit('addToGroceryList', list);

            }
        },
    }
</script>

<template>
    <div>
        <div class="centering-buttons">
            <a class="create-list-option" v-on:click="showListSelection = !showListSelection">
                <i class="fa fa-plus-circle"></i> Add Recipes to List</a>
        </div>

        <ul v-show="showListSelection" class="lists">
            <li class="list" v-for="list in grocerylists" :value="list.id" v-on:click="addToGroceryList(list)"><i class="fa fa-list"></i><a> {{ list.title }}</a></li>
        </ul>
    </div>
</template>