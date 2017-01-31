<script>
    let GroupedList = require('../../recipe/components/grouped-list.vue');

    export default {
        props : ['items'],
        components : {GroupedList},
        data(){
            return {
                departments : PepperRodeo.departments,
                groupByValue : 'department_name'
            }
        },

        created(){
            this.items.forEach(function(item){
                Vue.set(item, 'toggleOptions', false);
                Vue.set(item, 'editing', false);
                Vue.set(item, 'department_name', item.department.name);
            });

            Bus.$on('groupByValue', (value) => {
                this.groupByValue = value;
            });
        },

        computed : {
            itemsGrouped : function () {
                let items = _.sortBy(this.items, this.groupByValue);
                if(this.shouldCombine()){
                    items = this.combineItems();
                }
                return _.groupBy(items, this.groupByValue);
            }
        },

        methods : {
            shouldCombine(){
                return this.groupByValue == 'department_name';
            },

            combineItems() {
                let items = this.items;
                let newItems = [];

                items.forEach((item) => {
                    if(!_.findWhere(newItems, {department_name : item.department_name, name : item.name, type : item.type})) {
                        let likeItems = (_.where(items, {
                            department_name : item.department_name,
                            name            : item.name,
                            type            : item.type
                        }));
                        let newItem = Object.assign({}, item);
                        newItem.quantity = _.reduce(_.pluck(likeItems, 'quantity'), (a, b) => a + b, 0);
                        newItems.push(newItem);
                    }
                });

                return newItems;
            },

            toggleListOptions(item) {
                this.items.forEach(i => {
                    i.toggleOptions = false;
                    if(i.id == item.id){
                        this.toggledOption = i;
                        i.toggleOptions = true;
                    }
                });
                document.body.addEventListener('click', this.closeListOptions);
            },

            closeListOptions(event){
                if(typeof event.toElement.dataset.type !== 'undefined' && event.toElement.dataset.type == 'toggle-list-option'){
                    return
                }
                this.toggledOption.toggleOptions = false;
                document.body.removeEventListener('click', this.closeListOptions);
            },

            toggleItemEditing(item) {
                this.items.forEach(i => {
                    if(i.id == item.id){
                        this.toggledOption = i;
                        i.editing = !i.editing;
                    }
                });
            },
        }
    };
</script>

<template>
    <grouped-list :grouped-items="itemsGrouped">
        <template scope="props">
            <div v-if="!props.item.editing" class="list-item-editing">
                <div class="list-item-wrapper">
                    <div class="print-checkbox"></div><span class="list-item-added">{{ props.item.quantity }}</span>
                    <span class="list-item-added">{{ props.item.type }}</span>
                    <span class="list-item-added">{{ props.item.name }} </span>
                </div>
                <div class="options-dropdown-wrapper">
                    <a class="dropdown-indicator" v-on:click="toggleListOptions(props.item)" ><i data-type="toggle-list-option" class="fa fa-ellipsis-h"></i></a>
                    <ul class="options-dropdown" v-show="props.item.toggleOptions">
                        <li v-on:click="toggleItemEditing(props.item)"><i class="fa fa-pencil"></i><a> Edit Item</a></li>
                        <li v-on:click="$emit('delete', props.item)"><i class="fa fa-trash-o"></i><a> Delete Item</a></li>
                    </ul>
                </div>
            </div>
            <div v-else class="edit-info-wrapper">
                <div class="edit-inputs">
                    <input class="list-item-added ingredient-info" v-model="props.item.quantity" :value="props.item.quantity" type="number"/>
                    <input class="list-item-added ingredient-info" v-model="props.item.type" :value="props.item.type" />
                    <input class="list-item-added ingredient-info" v-model="props.item.name" :value="props.item.name" />
                    <select name="category" v-model="props.item.department.id" class="ingredient-info dept-edit-info">
                        <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                    </select>
                    <a class="edit-button" v-on:click="$emit('save-edit', props.item)"><i class="fa fa-check-circle-o"></i></a>
                </div>

                <div class="editing-button-wrapper">
                    <a class="edit-button" v-on:click="toggleItemEditing(props.item)"><i class="fa fa-times-circle-o"></i></a>
                </div>
            </div>
        </template>
    </grouped-list>
</template>