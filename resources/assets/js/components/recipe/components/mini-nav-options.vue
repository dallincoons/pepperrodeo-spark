<script>
    export default {
        data    : function () {
            return {
                recipe          : PepperRodeo.recipe,
                showListSelection : false
            }
        },

        computed : {
            recipeUrl : function(){
                return `/recipe/${this.recipe.id}/edit`;
            }
        },

        methods : {

            submitDeleteRecipe      : function () {
                this.$http.delete(`/recipe/${this.recipe.id}`)
                .then(() => window.location.href = '/recipe');
            },

            toggleShowListSelection : function () {
                Bus.$emit('toggleShowListSelection');
            },

        }
    }
</script>

<template>
    <ul>
        <li><a v-on:click="toggleShowListSelection()"><i class="fa fa-cart-plus"></i><span class="lg-mini-nav__options-text"> Add to Grocery List</span></a></li>
        <li><a :href="recipeUrl"><i class="fa fa-pencil"></i><span class="lg-mini-nav__options-text"> Edit</span></a></a></li>
        <li><a v-on:click="submitDeleteRecipe()"><i class="fa fa-trash"></i><span class="lg-mini-nav__options-text"> Delete</span></a></a></li>
    </ul>
</template>
