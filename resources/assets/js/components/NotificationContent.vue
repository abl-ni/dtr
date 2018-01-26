<template lang="html">
		<li :data-notification-id="request.notifications.id">
		  <a href="javascript:;">
		    <div class="pull-left">
		      <img src="vendor/dist/img/avatar5.png" class="img-circle" alt="User Image">
		    </div>
		    <h4>
		      {{request.notifications.requested_by.name}}
	          <small><i class="fa fa-clock-o"></i> {{ request.time }}</small>
		    </h4>
		    <p>{{request.notifications.message}}</p>
		    <div class="pull-right">
		      <span class="btn btn-success btn-xs" @click="accept(request.notifications.id)">Accept</span>
		      <span class="btn btn-danger btn-xs" @click="cancel(request.notifications.id)">Cancel</span>
		    </div>
		  </a>
		</li>
</template>

<script>
    export default {
    	props: ['request'],
    	methods: {
	    	cancel: function(id){
	    		//var notification = id;

	    		//notification.fadeOut();

	    		this.$emit('cancelRequest', {
	    			id: id
	    		});

	    		this.$emit('remove');
	    	},
    		accept : function(id) {
    			//var notification = id;

	    		//notification.fadeOut();

    			this.$emit('acceptRequest', {
	    			id: id
	    		});

	    		this.$emit('remove');
    		}
    	}
    }
</script>