<template lang="html">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-bell-o"></i>
      <span class="label label-danger count" v-show="count != 0">{{ count }}</span>
    </a>
</template>

<script>
    export default {
    	props: ['count']
    }
</script>