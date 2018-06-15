<template>
  <div id="app">
    <navbar class="z-top"></navbar>
    <!-- if logged in -->
    <main class="col-md-12 row">
      <div class="col-md-9">
        <router-view/>
      </div>
      <div class="col-md-3">
        <profile class="z-top"></profile>
      </div>
    </main>

    <!-- if not logged in -->
  </div>
</template>

<script>
import Navbar from './components/Navbar'
import Profile from './components/Profile'

export default {
  name: 'App',
  components: { Navbar, Profile }
}
</script>

<style scoped>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smooth1ng: antialiased;
  -moz-osx-font-smooth1ng: grayscale;
  text-align: center;
}
main {
  padding-top: 70px;
}
.z-top {
  z-index: 1;
}
</style>
