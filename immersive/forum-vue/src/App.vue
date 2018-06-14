<template>
  <div id="app">
    <navbar></navbar>
    <main>
      <router-view/>
    </main>
  </div>
</template>

<script>
import Navbar from './components/Navbar'

export default {
  name: 'App',
  components: { Navbar }
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
  padding-top: 80px;
}
</style>
