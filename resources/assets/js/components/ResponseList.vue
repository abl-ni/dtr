<template lang="html">
	<ul class="menu">
		<response-content v-for="(response, index) in responses" :response="response"></response-content>

		<li v-show="responses.length === 0">
			<a href="#" class="text-center" style="color: gray">
				No notification
			</a>
		</li>
	</ul>
</template>

<script>
    export default {
    	props: ['responses'],
    }
</script>