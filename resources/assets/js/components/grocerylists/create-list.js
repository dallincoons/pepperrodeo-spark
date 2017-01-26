let list_form = require('../mixins/list-form.js');

Vue.component('create-list', {
    mixins : [list_form],
    data() {
        return {
            editing : true
        }
    },
    methods : {

    }
});
