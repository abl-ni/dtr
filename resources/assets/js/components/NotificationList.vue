<template lang="html">
<ul class="dropdown-menu list-group">
    <li class="header">Overtime Request</li>
    <li>
        <ul class="menu">
            <notification-content v-for="(request, index) in requests" :request="request" v-on:acceptRequest="accept" v-on:cancelRequest="cancel" v-on:remove="remove(index)"></notification-content>

            <li v-show="requests.length === 0">
            	<a href="javascript:;" class="text-center" style="color: gray">
            		No request
            	</a>
            </li>
        </ul>
    </li>
    <li class="footer"><a href="javascript:;" @click="more(requests[requests.length-1], $event)">See more</a></li>
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
    		},
            more: function(data, e) {
                e.stopPropagation();
                var offset = data.notifications.id;

                this.$emit('pagination', {
                    id: offset
                });
            }
    	}
    }
</script>