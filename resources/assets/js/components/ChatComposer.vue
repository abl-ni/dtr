<template lang="html">
    <div class="chat-composer">
        <input type="text" placeholder="Typing..." v-model="messageText" v-on:keyup.enter="sendMessage">
        <button class="btn btn-primary" @click="sendMessage">Send</button>
    </div>
</template>

<script>
    export default {
	    data() {
	 		return{
	 			messageText: ''
	 		}   
	    },
	    methods: {
	    	sendMessage: function(){
	    		this.$emit('messagesent', {
	    			message: this.messageText,
	    			user: 'John Doe',
	    		});

	    		this.messageText = '';
	    	}
	    }
    }
</script>