
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('response-counter', require('./components/ResponseCounter.vue'));
Vue.component('response-content', require('./components/ResponseContent.vue'));
Vue.component('response-list', require('./components/ResponseList.vue'));
Vue.component('notification-counter', require('./components/NotificationCounter.vue'));
Vue.component('notification-content', require('./components/NotificationContent.vue'));
Vue.component('notification-list', require('./components/NotificationList.vue'));

const response = new Vue({
    el: '#response',
    data: {
		responses: []
    },
    methods: {
        set: function(response)
        {
            console.log(response);
            var notification = response.notification;
            this.responses.unshift(notification);
	    	// axios.get('/notification/retrieve/reply').then((response) => {
	    	// 	this.responses = response.data;
	    	// });
        }
    },
    created() {        
    	let user_id = document.head.querySelector('meta[name="user_id"]').content;

    	axios.get('/notification/retrieve/reply').then((response) => {
    		this.responses = response.data;

            console.log(this.responses);
    	});

        window.Echo.private('response.'+user_id)
         .listen('ResponseEvent', e => {
            this.responses.unshift(e.notification);
         });
    },
    mounted() {
	    $('.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a').click(function(e) {
	        e.stopPropagation();
	    });
    }
});

const request = new Vue({
    el: '#request',
    data: {
		requests: []
    },
    methods: {
    	requestApproved: function(notification){
    		console.log('approved', notification);
    		axios.get('notification/approve', {params: {id: notification.id}}).then((response) => {
	    		
	    	});
    	},
    	requestCancelled: function(notification){
    		console.log('cancelled', notification);
            axios.get('notification/cancel', {params: {id: notification.id}}).then((response) => {
                
            });
    	},
        response: function(notification)
        {
            // response.set(notification);
	    	axios.get('/notification/retrieve/request').then((response) => {
	    		this.requests = response.data;
	    	});
        }
    },
    created() {
    	let user_id = document.head.querySelector('meta[name="user_id"]').content;

    	axios.get('/notification/retrieve/request').then((response) => {
    		this.requests = response.data;
    	});

    	window.Echo.private('request.'+user_id)
			.listen('RequestEvent', (e) => {
				var notify = e;
				this.requests.unshift(e);
			});

        window.Echo.private('request.update.'+user_id)
            .listen('RequestUpdateEvent', e => {
                axios.get('/notification/retrieve/request').then((response) => {
                    this.requests = response.data;
                });
            });

    },
    mounted() {
	    $('.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a').click(function(e) {
	        e.stopPropagation();
	    });
    }
});