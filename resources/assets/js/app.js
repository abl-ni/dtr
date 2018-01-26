
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
Vue.component('chat-message', require('./components/ChatMessage.vue'));
Vue.component('chat-log', require('./components/ChatLog.vue'));
Vue.component('chat-composer', require('./components/ChatComposer.vue'));
Vue.component('notification-counter', require('./components/NotificationCounter.vue'));
Vue.component('notification-content', require('./components/NotificationContent.vue'));
Vue.component('notification-list', require('./components/NotificationList.vue'));

const app = new Vue({
    el: '#app',
    data: {
		thread: [
			{
				message: 'Hey!',
				user: 'John Doe'
			},
			{
				message: 'Hello!',
				user: 'Jane Doe'
			}
		]
    },
    methods: {
    	addMessage: function(message){
    		console.log(message);
    	}
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
    		// axios.get('notification/approve', {id: notification.id}).then((response) => {
	    		
	    	// });
    	},
    	requestCancelled: function(notification){
    		console.log('cancelled', notification);
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
    },
    mounted() {
	    $('.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a').click(function(e) {
	        e.stopPropagation();
	    });
    }
});