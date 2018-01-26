<template lang="html">
		<li :data-notification-id="response.notifications.id">
		  <a href="javascript:;">
		    <div class="pull-left">
		      <img src="vendor/dist/img/avatar5.png" class="img-circle" alt="User Image">
		    </div>
		    <h4>
		      {{response.notifications.approved_by.name}}
	          <small><i class="fa fa-clock-o"></i> {{ response.time }}</small>
		    </h4>
		    <p>{{response.notifications.message}}</p>
		  </a>
		</li>
</template>

<script>
    export default {
    	props: ['response']
    }
</script>