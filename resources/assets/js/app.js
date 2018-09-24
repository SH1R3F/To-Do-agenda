
window.Vue = require('vue');

/**
* Next, we will create a fresh Vue application instance and attach it to
* the page. Then, you may begin adding components to this application
* or customize the JavaScript scaffolding to fit your unique needs.
*/
// Here I stopped

const app = new Vue({
    el: '#app',
    data: function(){
        return {
            login: {
                email: '',
                password: '',
                remember: false,
                errors: {},
                disableBtn: false
            },
            register: {
                name: '',
                email: '',
                password: '',
                errors: {},
                disableBtn: false
            },
            tasks: {
                taskBody: '',
                taskDate: '',
                errors: {}
            }
        };
    },
    methods: {
        signIn: function(){
            if(!this.login.disableBtn && this.isBtnReady){
                this.login.disableBtn = true;
                axios.post(APP_URL + '/login', {
                    'email': this.login.email,
                    'password': this.login.password

                }).then(response => {
                    if(response.data.status === 'success'){
                        window.location = '/';
                    }
                }).catch(error => {
                    this.login.disableBtn = false;
                    this.login.errors = error.response.data.errors;
                    if("email" in this.login.errors){
                        Popper1 = new Popper($("#login #email"), $("#EmailErr"), {
                            placement: 'top'
                        });
                    }
                    if("password" in this.login.errors){
                        Popper2 = new Popper($("#login #password"), $("#PasswordErr"), {
                            placement: 'top'
                        });
                    }
                });
            }
        },
        signUp: function(){
            if(!this.register.disableBtn && this.isBtn2Ready){
                this.register.disableBtn = true;
                axios.post(APP_URL + '/register', {
                    'name': this.register.name,
                    'email': this.register.email,
                    'password': this.register.password
                }).then(response => {
                    if(response.data.status === 'success'){
                        window.location = '/';
                    }
                }).catch(error => {
                    this.register.disableBtn = false;
                    this.register.errors = error.response.data.errors;
                    if("name" in this.register.errors){
                        Popper3 = new Popper($("#registration #name"), $("#NameErr"), {
                            placement: 'top'
                        });
                    }
                    if("email" in this.register.errors){
                        Popper4 = new Popper($("#registration #email2"), $("#EmailErr2"), {
                            placement: 'top'
                        });
                    }
                    if("password" in this.register.errors){
                        Popper5 = new Popper($("#registration #password2"), $("#PasswordErr2"), {
                            placement: 'top'
                        });
                    }
                });
            }
        },
        isEmailValid: function(email){
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },
        addTask: function(){
            if(this.isTaskSbmtRdy){
                axios.post(APP_URL + '/store', {
                    'body': this.tasks.taskBody,
                    'deadline': this.tasks.taskDate
                }).then(response=>{
                    if(response.data.status === 'success'){
                        $(".newTask").addClass("fold");
                        setTimeout(function(){
                            $(".newTask").hide();
                            $(".newTask").removeClass('fold');
                        }, 900);


                        let task_date = new Date(this.tasks.taskDate)
                        task_date.setHours(0, 0, 0, 0);
                        let todaysDate = new Date()
                        todaysDate.setHours(0, 0, 0, 0);
                        dateDifference = Number(todaysDate) - task_date;

                        if(dateDifference === 0){ // If Today
                            $('<div id="' + response.data.task_id + '" draggable="true" class="sticky-note task col-sm-3" ondragstart="drag(event)"><p>' + this.tasks.taskBody + '</p><span>' + this.tasks.taskDate + '</span></div>').hide().prependTo(".container-fluid>.row>.section:eq(0)>.row").fadeIn('slow');
                        }else if(dateDifference > 0){
                            $('<div id="' + response.data.task_id + '" draggable="true" class="sticky-note task col-sm-3" ondragstart="drag(event)"><p>' + this.tasks.taskBody + '</p><span>' + this.tasks.taskDate + '</span></div>').hide().prependTo(".container-fluid>.row>.section:eq(3)>.row").fadeIn('slow');
                        }else if(dateDifference === (-86400000)){
                            $('<div id="' + response.data.task_id + '" draggable="true" class="sticky-note task col-sm-3" ondragstart="drag(event)"><p>' + this.tasks.taskBody + '</p><span>' + this.tasks.taskDate + '</span></div>').hide().prependTo(".container-fluid>.row>.section:eq(1)>.row").fadeIn('slow');
                        }else{
                            $('<div id="' + response.data.task_id + '" draggable="true" class="sticky-note task col-sm-3" ondragstart="drag(event)"><p>' + this.tasks.taskBody + '</p><span>' + this.tasks.taskDate + '</span></div>').hide().prependTo(".container-fluid>.row>.section:eq(2)>.row").fadeIn('slow');
                        }

                        this.tasks = {
                            taskBody: '',
                            taskDate: '',
                            errors: {}
                        };
                    }
                }).catch(error => {
                    console.error(error);
                    this.tasks.errors = error.response.data.errors;
                    if("body" in this.tasks.errors){
                        Popper6 = new Popper($("#taskBody"), $("#bodyErr"), {
                            placement: 'top'
                        });
                    }
                    if("date" in this.tasks.errors){
                        Popper7 = new Popper($("#taskDate"), $("#dateErr"), {
                            placement: 'top'
                        });
                    }
                });
            }
        },
        showAdder: function(){
            $(".newTask").toggle('slow');
        },
        closeAdder: function(){
            $(".newTask").addClass("fold");
            setTimeout(function(){
                $(".newTask").hide();
                $(".newTask").removeClass("fold");
            }, 900);
        }
    },
    computed: {
        isBtnReady: function(){
            return this.isEmailValid(this.login.email) && (this.login.password.length > 0);
        },
        isBtn2Ready: function(){
            return this.isEmailValid(this.register.email) && (this.register.password.length > 0) && (this.register.name.length > 0);
        },
        isTaskSbmtRdy: function(){
            return (this.tasks.taskBody.length > 0) && (this.tasks.taskDate.length > 0);
        }
    }
});
