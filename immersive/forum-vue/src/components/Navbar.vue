<template>
<nav>
    <div class="top-nav row fixed col-md-12">
        <span class="col-md-6 text-left">
          <router-link v-if="!this.$store.state.auth" :to="{ name: 'Home' }" class="page text-black" id="home" v-on:click.native="onClick('home')">HOME</router-link>
          <div v-if="!this.$store.state.auth" class="symbol">&#183;</div>

          <router-link :to="{ name: 'Posts' }" class="page text-black" id="posts" @click.native="onClick('posts')">POSTS</router-link>
          
          <div v-if="this.$store.state.user.role" class="symbol">&#183;</div>
          <router-link v-if="this.$store.state.user.role" :to="{ name: 'Users' }" class="page text-black" id="userroles" @click.native="onClick('userroles')">USER ROLES</router-link>
        </span>
        
        <span v-if="!this.$store.state.auth" class="col-md-6 text-right">
          <router-link :to="{ name: 'Login' }" class="page text-black" id="login" @click.native="onClick('login')">LOGIN</router-link>
          <div class="symbol">&#183;</div>
          
          <router-link :to="{ name: 'Register' }" class="page text-black" id="register" @click.native="onClick('register')">REGISTER</router-link>
        </span>
    </div>
    <div class="bottom-nav text-left row">
      <div class="col-md-10 text-left">
        <img src="../assets/navbar/reddit-logo.png" width="28px">
        <span class="font-meddit center-in">meddit</span>
      </div>
      <div v-if="this.$store.state.auth" class="col-md-2 text-right bottom-right-nav text-gray">
        <div class="inline-block text-dark-blue">{{this.$store.state.user.username}}</div>
        <div class="inline-block text-gray bold">|</div>
        <a href="#" @click.prevent="logout" class="text-dark-blue logout">logout</a>
      </div>
    </div>
</nav>
</template>

<script>
export default {
  name: 'Navbar',
  data () {
    return {
      pages: [
        ['#/', 'home'],
        ['#/posts', 'posts'],
        ['#/user-roles', 'userroles'],
        ['#/settings', 'settings'],
        ['#/login', 'login'],
        ['#/register', 'register'],
      ]
    }
  },
  methods: {
    onClick: function (page) {
      var pages = document.getElementsByClassName('page')
      for (var i = 0; i < pages.length; i++) {
        pages[i].style.color = 'black'
        pages[i].style.fontWeight = 'normal'
      }
      var style = document.getElementById(page).style
      style.color = 'orange'
      style.fontWeight = 'bold'
    },
    logout () {
      this.$session.destroy()
      this.$store.commit('logout')
    }/*,
    home: function () {
      this.onClick('home')
      this.$router.replace('/')
    }*/
  },
  mounted () {
    var hash = window.location.hash
    var page
    for (var i = 0; i < this.pages.length; i++) {
      if (this.pages[i][0] == hash) {
        page = this.pages[i][1]
        break
      }
    }
    var style = document.getElementById(page).style
    style.color = 'orange'
    style.fontWeight = 'bold'
  }
}
</script>

<style scoped>
.inline-block {
  display: inline-block;
}
.bold {
  font-weight: bold;
}
nav {
  position: fixed;
  width: 100%;
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  color: black;
}
.top-nav {
  background-color: rgb(240, 240, 240);
  font-size: 10px;
  border-bottom: 1px solid black;
}
.bottom-nav {
  background-color: rgb(207, 227, 247);
  border-bottom: 1px rgb(99, 153, 206) solid;
  padding: 2px;
}
.bottom-right-nav{
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  font-size: 12px;
  margin-top: 23.2px;
  background-color: rgb(239, 247, 255);
  border-top-left-radius: 5px;
}
.symbol {
  display: inline;
}
.font-meddit {
  font-size: 23px;
}
.text-black {
  color: black;
}
.text-gray {
  color: gray;
}
.text-dark-blue {
  color: rgb(56, 101, 151)
}
.logout {
  padding-right: 10px;
}
</style>
