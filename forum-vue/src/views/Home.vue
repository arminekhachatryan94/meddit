<template>
  <div class="vertical-center">
    <p class="text-orange font-50">Welcome to MEAT Labs</p>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.text-orange {
  color: orange
}
.font-50 {
  font-size: 50px;
}
.vertical-center {
  height: 75vh;
  position: relative;
}
.vertical-center p {
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
