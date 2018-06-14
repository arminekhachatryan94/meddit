<template>
<nav>
    <div class="top-nav row fixed col-md-12">
        <span class="col-md-6 text-left">
            <router-link :to="{ name: 'Home' }" class="page text-black" id="home" v-on:click.native="onClick('home')">HOME</router-link>
            <div class="symbol">&#183;</div>
            <router-link :to="{ name: 'Posts' }" class="page text-black" id="posts" @click.native="onClick('posts')">POSTS</router-link>
            <div class="symbol">&#183;</div>
            <router-link :to="{ name: '' }" class="page text-black" id="myposts" @click.native="onClick('myposts')">MY POSTS</router-link>
            <div class="symbol">&#183;</div>
            <router-link :to="{ name: '' }" class="page text-black" id="userroles" @click.native="onClick('userroles')">USER ROLES</router-link>
        </span>
        <span class="col-md-6 text-right">
            <router-link :to="{ name: '' }" class="page text-black" id="settings" @click.native="onClick('settings')">SETTINGS</router-link>
            <div class="symbol">&#183;</div>
            <router-link :to="{ name: '' }">LOG OUT</router-link>
        </span>
    </div>
    <div class="bottom-nav text-left">
        <img src="../assets/reddit-logo.png" width="28px">
        <span class="font-meddit center-in">meddit</span>
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
        ['#/myposts', 'myposts'],
        ['#/user-roles', 'userroles'],
        ['#/settings', 'settings']
      ]
    }
  },
  methods: {
    onClick: function (page) {
      var pages = document.getElementsByClassName('page')
      for (var i = 0; i < pages.length; i++) {
        pages[i].style.color = "black"
      }
      document.getElementById(page).style.color = "orange"
    }
  },
  mounted() {
    var hash = window.location.hash
    var page;
    for (var i = 0; i < this.pages.length; i++) {
        if (this.pages[i][0] == hash) {
            page = this.pages[i][1];
            break;
        }
    }
    document.getElementById(page).style.color = "orange"

  }
}
</script>

<style scoped>
nav {
    position: fixed;
    padding: 5px;
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
.symbol {
    display: inline;
}
.font-meddit {
    font-size: 23px;
}
.text-black {
    color: black;
}
</style>
