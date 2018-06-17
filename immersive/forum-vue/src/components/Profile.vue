<template>
<div class="profile-container">
    <div class="img">
        <img src="../assets/profile/profile-pic.png" width="90px">
    </div>
    <div class="username">u/{{this.$store.state.user.username}}</div>
    <div class="button">
        <button class="btn btn-primary w-100">NEW POST</button>
    </div>
    <div class="row">
        <div class="col-md-3 text-left settings" @click="settings()">Settings</div>
        <div class="col-md-5"></div>
        <div class="col-md-4 text-right help">&#9432; Help</div>
    </div>
</div>
</template>

<script>
export default {
  name: 'Profile',
  methods: {
    settings: function () {
      var pages = document.getElementsByClassName('page')
      for (var i = 0; i < pages.length; i++) {
        pages[i].style.color = 'black'
        pages[i].style.fontWeight = 'normal'
      }
    }
  }
}
</script>

<style scoped>
.profile-container {
    text-align: left;
    position: fixed;
    margin-top: 30px;
    margin-right: 30px;
    padding: 15px;
    padding-top: 20px;
    border-radius: 5px;
    background: white;
    height: 240px;
    width: 280px;
}
.w-100 {
    width: 100%;
}
.btn-primary {
    background-color: rgb(32, 120, 209);
    padding: 3px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: 12px;
    font-weight: bold;
}
.username {
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: 15px;
}
.settings {
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: 12px;
    color: rgb(161, 161, 161);
    cursor: pointer;
}
.img {
    margin-bottom: 5px;
}
.button {
    margin-top: 25px;
    margin-bottom: 15px;
}
.help {
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: 12px;
    color: rgb(161, 161, 161);
    cursor: pointer;
}

img {
    border-radius: 5px;
}
</style>
