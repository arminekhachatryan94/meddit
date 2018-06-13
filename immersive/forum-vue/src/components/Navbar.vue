<template>
<nav class="row fixed col-md-12">
    <span class="col-md-6 text-left">
        <router-link :to="{ name: 'Home' }">iChat</router-link>
    </span>
    <span class="col-md-6 text-right">
        <a>Hi</a>
    </span>
</nav>
</template>

<script>
export default {
  name: 'Navbar'
}
</script>

<style scoped>
nav {
    background-color: bisque;
    color: orange;
    position: fixed;
}
</style>
