<script>
    export default {
        data(){
            return {
                groupByValue : 'department_name'
            }
        },

        methods : {
            changeGroupByValue(groupBy){
                Bus.$emit('groupByValue', groupBy);
                this.groupByValue = groupBy;
            },
        }
    }
</script>

<template>
    <div class="centering-buttons">
        <a  v-bind:class="{ 'toggle-active': groupByValue == 'department_name', 'toggle-inactive': groupByValue != 'department_name' }"  v-on:click="changeGroupByValue('department_name')" class="toggle">By Dept.</a>
        <a v-bind:class="{ 'toggle-active': groupByValue == 'recipe_title', 'toggle-inactive': groupByValue != 'recipe_title' }" v-on:click="changeGroupByValue('recipe_title')" class="toggle">By Recipe</a>
    </div>
</template>