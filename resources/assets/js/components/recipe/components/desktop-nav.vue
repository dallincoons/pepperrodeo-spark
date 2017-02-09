<script>
    export default {
        props : ['grocerylists'],

        methods : {
            addToGroceryList(list){

                Bus.$emit('addToGroceryList', list);

            }
        },
    }
</script>

<template>
    <div>
        <ul v-show="showListSelection" class="lists">
            <li class="list" v-for="list in grocerylists" :value="list.id" v-on:click="addToGroceryList(list)"><i class="fa fa-list"></i><a> {{ list.title }}</a></li>
        </ul>
    </div>
</template>
