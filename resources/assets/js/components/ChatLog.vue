<template lang="html">
    <div class="chat-logs">
    	<chat-message v-for="message in messages" :messaging="message"></chat-message>
        
    </div>
</template>

<script>
    export default {
    	props: ['messages'],
    	created() {
    		//console.log(this.messages);
    	}
    }
</script>