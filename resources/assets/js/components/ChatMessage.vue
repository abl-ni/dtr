<template lang="html">
    <div>
        <p>{{ messaging.message }}</p>
        <small>{{ messaging.user_id }}</small>
    </div>
</template>

<script>
    export default {
        props: ['messaging']
    }
</script>