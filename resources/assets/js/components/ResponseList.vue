<template lang="html">
<ul class="dropdown-menu list-group">
  <li class="header">Overtime Response</li>
  <li>
	<ul class="menu">
		<response-content v-for="(response, index) in responses" :response="response"></response-content>

		<li v-show="responses.length === 0">
			<a href="#" class="text-center" style="color: gray">
				No notification
			</a>
		</li>
	</ul>
  </li>
  <li class="footer"><a href="javascript:;" @click="more(responses[responses.length-1], $event)">See more</a></li>
</ul>
</template>

<script>
    export default {
    	props: ['responses'],
    	methods: {
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