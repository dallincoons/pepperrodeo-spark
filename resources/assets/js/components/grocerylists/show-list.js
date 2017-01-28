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
        }
    }
});
