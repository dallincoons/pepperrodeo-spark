<script>
    export default {
        methods : {
            deleteRecipes : function () {
                Bus.$emit('deleteRecipes');
            }
        }
    }
</script>

<template>
    <nav class="mini-nav">
        <ul class="mini-nav-options">
            <li v-on:click="showListSelection = !showListSelection"><i class="fa fa-shopping-cart"></i></li>
            <li><a href="/recipe/create"><i class="fa fa-plus"></i></a></li>
            <li><a v-on:click="deleteRecipes()"><i class="fa fa-trash"></i></a></li>
        </ul>
    </nav>
</template>
