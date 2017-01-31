<script>
    export default {
        props : ['groupedItems'],
        methods : {
            deleteGroup(items){
                Bus.$emit('deleteGroup', items);
            }
        }
    }
</script>

<template>
    <div class="category-wrapper">

        <div>
            <ul v-for="(items, groupName) in groupedItems">
                <li class="category-title"><h3>{{groupName}}</h3><span v-on:click="deleteGroup(items)" class="remove-dept"><i class="fa fa-times-circle-o"></i></span></li>
                <li>
                    <ul class="items">
                        <li v-for="item in items" class="recipe">
                            <slot :item="item"></slot>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</template>