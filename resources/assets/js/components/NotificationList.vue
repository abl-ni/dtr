<template lang="html">
	<ul class="menu">
		<notification-content v-for="(request, index) in requests" :request="request" v-on:acceptRequest="accept" v-on:cancelRequest="cancel" v-on:remove="remove(index)"></notification-content>

		<li v-show="requests.length === 0">
			<a href="#" class="text-center" style="color: gray">
				No request
			</a>
		</li>
	</ul>
</template>

<script>
    export default {
    	props: ['requests'],
    	methods: {
    		accept: function(notification) {
    			this.$emit('approved', {
	    			id: notification.id
	    		});
    		},
    		cancel: function(notification) {
    			this.$emit('cancelled', {
	    			id: notification.id
	    		});
    		},
    		remove: function(index) {
    			this.requests.splice(index, 1);
    		}
    	}
    }
</script>