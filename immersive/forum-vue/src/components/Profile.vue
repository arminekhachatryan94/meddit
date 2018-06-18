<template>
<div class="profile-container">
    <div class="img">
        <img src="../assets/profile/profile-pic.png" width="90px">
    </div>
    <div class="username">u/{{this.$store.state.user.username}}</div>
    <div class="button">
        <button @click="showNewPost()" class="btn btn-primary w-100">NEW POST</button>
    </div>

    <!-- new post -->
    <div v-if="this.showpost" class="text-center">
        <div class="form-group">
            <div><span>Title</span></div>
            <div><input @keydown="clearTitleError()" v-model="newpost.title"></div>
            <div v-if="this.errors.title.length" v-text="this.errors.title" class="text-danger error-font"></div>
        </div>
        <div class="form-group">
            <div><span>Body</span></div>
            <div><input @keydown="clearBodyError()" v-model="newpost.body"></div>
            <div v-if="this.errors.body.length" v-text="this.errors.body" class="text-danger error-font"></div>
        </div>
        <div class="text-center">
            <button @click="createPost()" class="btn btn-primary">Post</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 text-left settings" @click="settings()">Settings</div>
        <div class="col-md-5"></div>
        <div class="col-md-4 text-right help">&#9432; Help</div>
    </div>
</div>
</template>

<script>
import axios from 'axios'
import EventBus from './event-bus';

export default {
  name: 'Profile',
  data () {
    return {
      newpost: {
        title: '',
        body: ''
      },
      showpost: false,
      errors: {
        title: '',
        body: ''
      }
    }
  },
  methods: {
    settings: function () {
      var pages = document.getElementsByClassName('page')
      for (var i = 0; i < pages.length; i++) {
        pages[i].style.color = 'black'
        pages[i].style.fontWeight = 'normal'
      }
      this.$router.push('/settings');
    },
    showNewPost: function () {
      if (this.showpost) {
        this.showpost = false
      } else {
        this.showpost = true
      }
    },
    createPost: function (event) {
      var self = this
      this.errors.title = ''
      this.errors.body = ''
      if (this.newpost.title.length == 0) {
        this.errors.title = 'Title is required.'
      }
      if (this.newpost.body.length == 0) {
        this.errors.body = 'Body is required.'
      }
      if (!this.errors.body.length && !this.errors.title.length) {
        axios.post('http://127.0.0.1:8000/api/new-post', {
          title: this.newpost.title,
          body: this.newpost.body,
          user_id: this.$store.state.user.id
        })
        .then((response) => {
          self.newpost.title = ''
          self.newpost.body = ''
          EventBus.$emit('new', response.data.post);
        })
        .catch((error) => {
          console.log(error.response.data);
        });
      }
    },
    clearBodyError () {
      this.errors.body = ''
    },
    clearTitleError () {
      this.errors.title = ''
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
    width: 280px;
}
.w-100 {
    width: 100%;
}
.w-80 {
    width: 50%;
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
.error-font {
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: 12px;
}

img {
    border-radius: 5px;
}
</style>
