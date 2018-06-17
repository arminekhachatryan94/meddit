<template>
<div class="w-50">
    <div class="text-left margin-left-40 margin-bottom-10 font-style">LOGIN</div>
    <div class="margin-bottom-5 margin-left-40 login-container row">
        <div class="col-md-3">
            <br>
            <img src="../assets/auth/reddit.png" width="70px">
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <div class="font-style font-12">Email</div>
                <input v-model="credentials.email" @keydown="clearEmail()" type="email" class="font-style" required>
                <div v-if="this.errors.email.length" v-text="this.errors.email" class="text-danger font-style font-12"></div>
            </div>
            <div class="form-group">
                <div class="font-style font-12">Password</div>
                <input v-model="credentials.password" @keydown="clearPassword()" type="password" class="font-style" required>
                <div v-if="this.errors.password.length" v-text="this.errors.password" class="text-danger font-style font-12"></div>
            </div>
            <div class="margin-bottom-10">
                <button class="font-style btn btn-primary" @click="onLogin()">LOGIN</button>
            </div>
            <div v-if="this.errors.other.length" v-text="this.errors.other" class="text-danger font-style font-12"></div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Login',
  data: function () {
    return {
      credentials: {
        email: '',
        password: ''
      },
      errors: {
        email: '',
        password: '',
        other: ''
      }
    }
  },
  methods: {
    onLogin () {
      var self = this
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      if (this.credentials.email.length == 0) {
        this.errors.email = 'Email is required.'
      }
      if (this.credentials.password.length == 0) {
        this.errors.password = 'Password is required.'
      }
      if ( this.errors.email.length == 0 && !re.test(this.credentials.email)) {
        this.errors.email = 'Invalid email format.'
      }
      if (!this.errors.email.length && !this.errors.password.length) {
        axios.post('http://127.0.0.1:8000/api/login', {
          email: this.credentials.email,
          password: this.credentials.password
        }).then(function (response) {
          self.$session.start()
          // this.$session.flash.set('loggedin', 'Successfully logged in! Enjoy iChat.')
          self.$session.set('auth', true)
          self.$session.set('user', response.data.user[0])
          self.$store.commit('login', response.data.user[0])
          self.$router.push('/posts');
        }).catch(function (error) {
          if (typeof error.response.data.errors.invalid !== 'undefined') {
            self.errors.other = error.response.data.errors.invalid
          } 
        })
      }
    },
    clearEmail () {
      this.errors.email = ''
      this.errors.other = ''
    },
    clearPassword () {
      this.errors.password = ''
      this.errors.other = ''
    }
  }
}
</script>

<style scoped>
.margin-bottom-5 {
  margin-bottom: 10px;
}
.margin-left-40 {
  margin-left: 30px;
}
.margin-bottom-10 {
  margin-bottom: 10px;
}
.font-style {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  font-size: 15px;
}
.font-12 {
    font-size: 12px;
}
.w-50 {
    width: 50%;
}
.login-container {
    background-color: white;
    padding: 40px;
    box-shadow: 2px 2px lightgray;
    border-radius: 5px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
}
.btn-primary {
    background-color: rgb(32, 120, 209);
    padding: 3px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: 12px;
    font-weight: bold;
    width: 50%;
}
img {
    border-radius: 50%;
}
</style>
