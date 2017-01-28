import http from 'axios';

export default class Form {
    constructor(data){
        this.originalData = data;

        for(let field in data){
            this[field] = data[field];
        }

        this.$http = http;
    }

    /* reset all form values */
    reset() {
        for(let field in this.originalData){
            this[field] = '';
        }
    }

    /* submit the form with current data */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            this.$http[requestType](url, this.data())
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error.response);
                });
        });
    }

    /* check against validation rules */
    validate() {
        for(let property in this.originalData){
            if(this[property].length == 0){
                return false;
            }
        }
        return true;
    }

    /* fetch all data from form */
    data(){
        let data = {};

        for(let property in this.originalData){
            data[property] = this[property];
        }

        return data;
    }
}