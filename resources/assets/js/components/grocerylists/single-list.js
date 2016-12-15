Vue.component('single-list', {
    methods : {
        submitDeleteList : function(){
            document.getElementById('list-delete').submit();
        },
        showEditModal(item){
            swal2({
                html : this.editModalHtml(item),
                confirmButtonText: 'Save',
                preConfirm: function (email) {
                    return new Promise(function (resolve, reject) {
                        // this.$http.patch('')
                    })
                },
                allowOutsideClick: false
            }).then(function (email) {
                swal({
                    type: 'success',
                    title: 'Ajax request finished!',
                    html: 'Submitted email: ' + email
                })
            });
        },
        editModalHtml(item){
            return `
                <input value='${item.quantity}' />
                <input value='${item.type}' />
                <input value='${item.name}' />
            `
        }
    }
});
