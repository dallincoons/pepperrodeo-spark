<script>
    export default {
        props : ['groupedItems']
    }
</script>

<template>
    <div class="category-wrapper">

        <div>
            <ul v-for="(items, groupName) in groupedItems">
                <li class="category-title"><h3>{{groupName}}</h3></li>
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