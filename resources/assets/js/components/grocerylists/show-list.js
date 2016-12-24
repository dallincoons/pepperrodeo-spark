let list_form = require('../mixins/list-form.js');

Vue.component('single-list', {
    mixins : [list_form],
    data() {
        return {
            editing : false
        }
    },
    methods : {
        submitDeleteList : function(){
            document.getElementById('list-delete').submit();
        }
    }
});
