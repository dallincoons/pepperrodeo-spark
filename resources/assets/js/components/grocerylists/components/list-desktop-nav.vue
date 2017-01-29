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
        }
    }
</script>

<template>
    <div>

    </div>
</template>