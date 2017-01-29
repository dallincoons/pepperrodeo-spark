let list_form = require('./mixins/list-form.js');
import ListDesktopNav from './components/list-desktop-nav.vue';

Vue.component('show-list', {
    mixins : [list_form],
    components : {ListDesktopNav},
    data() {
        return {
            editing : true
        }
    },
    methods : {
        submitDeleteList : function(){
            document.getElementById('list-delete').submit();
        },
        saveItemEdit(item) {
            this.$http.patch('/grocerylistitem/edit/' + item.id, {item : {'quantity' : item.quantity, 'type' : item.type, 'name' : item.name, 'department_id' : item.department.id}})
                .then(function(response){
                    if(response.status == 200){
                        this.items.forEach(i => {
                            if(i.id == item.id){
                                i.department_name = this.departments[item.department.id].name;
                                i.quantity = item.quantity;
                                i.type = item.type;
                                i.name = item.name;
                                i.editing = false;
                            }
                        });
                    }
                });
        },

        deleteGroup(items){
            let self = this;
            this.$http.post('/grocerylistitem/remove', {grocerylist : this.grocerylist.id, itemIds : _.pluck(items, 'id')})
                .then(function(response){
                    if(response.status == 200){
                        items.forEach(function(item){
                            self.removeItemFromView(item);
                        });
                    }
                });
        },
    }
});
