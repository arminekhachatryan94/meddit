<template>
<div class="w-50">
    <div class="text-left margin-left-40 margin-bottom-10 font-style">REGISTER</div>
    <div class="margin-bottom-5 margin-left-40 login-container row">
        <div class="col-md-3">
            <br>
            <img src="../assets/auth/reddit.png" width="70px">
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <div class="font-style font-12">First Name</div>
                <input v-model="credentials.first_name" @keydown="clearFirstName()" type="text" class="font-style" required>
                <div v-if="this.errors.first_name.length" v-text="this.errors.first_name" class="text-danger font-style font-12"></div>
            </div>
            <div class="form-group">
                <div class="font-style font-12">Last Name</div>
                <input v-model="credentials.last_name" @keydown="clearLastName()" type="text" class="font-style" required>
                <div v-if="this.errors.last_name.length" v-text="this.errors.last_name" class="text-danger font-style font-12"></div>
            </div>
            <div class="form-group">
                <div class="font-style font-12">Email</div>
                <input v-model="credentials.email" @keydown="clearEmail()" type="email" class="font-style" required>
                <div v-if="this.errors.email.length" v-text="this.errors.email" class="text-danger font-style font-12"></div>
            </div>
            <div class="form-group">
                <div class="font-style font-12">Username</div>
                <input v-model="credentials.username" @keydown="clearUsername()" type="text" class="font-style" required>
                <div v-if="this.errors.username.length" v-text="this.errors.username" class="text-danger font-style font-12"></div>
            </div>
            <div class="form-group">
                <div class="font-style font-12">Password</div>
                <input v-model="credentials.password" @keydown="clearPassword()" type="password" class="font-style" required>
                <div v-if="this.errors.password.length" v-text="this.errors.password" class="text-danger font-style font-12"></div>
            </div>
            <div class="form-group">
                <div class="font-style font-12">Confirm Password</div>
                <input v-model="credentials.password_confirmation" @keydown="clearPasswordConfirm()" type="password" class="font-style" required>
                <div v-if="this.errors.password_confirmation.length" v-text="this.errors.password_confirmation" class="text-danger font-style font-12"></div>
            </div>
            <div class="margin-bottom-10">
                <button class="font-style btn btn-primary" @click="onRegister()">REGISTER</button>
            </div>
            <div v-if="this.errors.other.length" v-text="this.errors.other" class="text-danger font-style font-12"></div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Register',
  data: function () {
    return {
      credentials: {
        first_name: '',
        last_name: '',
        email: '',
        username: '',
        password: '',
        password_confirmation: ''
      },
      errors: {
        first_name: '',
        last_name: '',
        email: '',
        username: '',
        password: '',
        password_confirmation: '',
        other: ''
      }
    }
  },
  methods: {
    onRegister () {
      this.clearAllErrors()
      var size = 0; // size of errors
      var self = this
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      if (this.credentials.first_name.length == 0) {
        this.errors.first_name = 'First name is required.'
        size++
      }
      if (this.credentials.last_name.length == 0) {
        this.errors.last_name = 'Last name is required.'
        size++
      }
      if (this.credentials.username.length == 0) {
        this.errors.username = 'Username is required.'
        size++
      }
      if (this.credentials.email.length == 0) {
        this.errors.email = 'Email is required.'
        size++
      }
      if (this.credentials.password.length == 0) {
        this.errors.password = 'Password is required.'
        size++
      }
      if (this.credentials.password_confirmation.length == 0) {
        this.errors.password_confirmation = 'Password confirmation is required.'
        size++
      }
      if (size == 0 && !re.test(this.credentials.email)) {
        this.errors.email = 'Invalid email format.'
        size++
      }
      if (size == 0) {
        axios.post('http://127.0.0.1:8000/api/register', {
          first_name: this.credentials.first_name,
          last_name: this.credentials.last_name,
          username: this.credentials.username,
          email: this.credentials.email,
          password: this.credentials.password,
          password_confirmation: this.credentials.password_confirmation
        }).then(function (response) {
          self.$session.start()
          // this.$session.flash.set('loggedin', 'Successfully logged in! Enjoy iChat.')
          self.$session.set('auth', true)
          self.$session.set('user', response.data.user)
          self.$store.commit('login', response.data.user)
          self.$router.push('/posts');
        }).catch( (error) => {
          var errors = error.response.data.errors
          if (typeof errors.first_name !== 'undefined') {
            self.errors.first_name = errors.first_name[0]
          }
          if (typeof errors.last_name !== 'undefined') {
            self.errors.last_name = errors.last_name[0]
          }
          if (typeof errors.email !== 'undefined') {
            self.errors.email = errors.email[0]
          }
          if (typeof errors.username !== 'undefined') {
            self.errors.username = errors.username[0]
          }
          if (typeof errors.password !== 'undefined') {
            self.errors.password = errors.password[0]
          }
        })
      }
    },
    clearFirstName () {
      this.errors.first_name = ''
      this.errors.other = ''
    },
    clearLastName () {
      this.errors.last_name = ''
      this.errors.other = ''
    },
    clearEmail () {
      this.errors.email = ''
      this.errors.other = ''
    },
    clearUsername () {
      this.errors.username = ''
      this.errors.other = ''
    },
    clearPassword () {
      this.errors.password = ''
      this.errors.other = ''
    },
    clearPasswordConfirm () {
      this.errors.password_confirmation = ''
      this.errors.other = ''
    },
    clearAllErrors () {
      this.errors.first_name = ''
      this.errors.last_name = ''
      this.errors.email = ''
      this.errors.username = ''
      this.errors.password = ''
      this.errors.password_confirmation = ''
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
