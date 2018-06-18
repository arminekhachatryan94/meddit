<template>
<div>
  <div class="text-left margin-left-40 margin-bottom-10 font-style">SETTINGS</div>
  <div class="margin-bottom-5 settings-container">
    <div class="form-group">
        <div>Change Username</div>
        <div class="form-group">
            Username:<input type="text" v-model="username" required>
        </div>
        <div v-text="errors.username" class="text-danger"></div>
        <div>
            Password:<input type="password" v-model="password" required>
        </div>
        <div v-text="errors.password" class="text-danger"></div>
        <button class="btn btn-primary" @click="saveUsername()">Save Username</button>
    </div>
    <br>
    <div class="form-group">
        <div>Change Biography</div>
        <div class="form-group">
            Biography:<input type="text" v-model="biography" required>
        </div>
        <div v-text="errors.biography" class="text-danger"></div>
        <div>
            Password:<input type="password" v-model="password" required>
        </div>
        <div v-text="errors.password" class="text-danger"></div>
        <button class="btn btn-primary" @click="saveBiography()">Save Biography</button>
    </div>
  </div>
</div>
</template>

<script>
import Role from '../components/Role'
import User from '../components/User'
import axios from 'axios'

export default {
  name: 'Settings',
  data () {
    return {
      user: User,
      password: '',
      username: '',
      biography: '',
      errors: {
        username: '',
        biography: '',
        password: ''
      }
    }
  },
  created () {
    axios.get('http://127.0.0.1:8000/api/' + this.$store.state.user.id + '/settings').then((response) => {
      this.user = response.data.user
      this.username = response.data.user.username
      this.biography = response.data.user.biography
    }).catch(function (error) {
      console.log(error)
    })
  },
  methods: {
    saveUsername () {
      var self = this
      if( this.username.length == 0 ){
        this.errors.username = 'Username is required.'
      }
      if( this.password.length == 0 ){
        this.errors.password = 'Password is required.'
      }
      if( this.password.length != 0 && this.user.username.length != 0 ){
        axios.put('http://127.0.0.1:8000/api/' + this.$store.state.user.id + '/settings/username', {
          username: this.username,
          password: this.password
        }).then(function (response) {
          alert(response.data.message)
          self.errors.username = ''
          self.errors.password = ''
          self.password = ''
          self.user.username = self.username
        }).catch(function (error) {
          var errors = error.response.data.errors
          if( typeof errors.username !== 'undefined' ){
            self.errors.username = errors.username[0]
          }
          if( typeof errors.password !== 'undefined' ){
            self.errors.password = errors.password[0]
          }
        })
      }
    },
    saveBiography () {
      var self = this
      if( this.biography.length == 0 ){
        this.errors.biography = 'Biography is required.'
      }
      if( this.password.length == 0 ){
        this.errors.password = 'Password is required.'
      }
      if( this.password.length != 0 && this.biography.length != 0 ){
        axios.put('http://127.0.0.1:8000/api/' + this.$store.state.user.id + '/settings/biography', {
          biography: this.biography,
          password: this.password
        }).then(function (response) {
          alert(response.data.message)
          self.errors.biography = ''
          self.errors.password = ''
          self.password = ''
          self.user.biography = self.biography
        }).catch(function (error) {
          var errors = error.response.data.errors
          console.log(errors)
          if( typeof errors.biography !== 'undefined' ){
            self.errors.biography = errors.biography[0]
          }
          if( typeof errors.password !== 'undefined' ){
            self.errors.password = errors.password[0]
          }
        })
      }
    }
  }
}
</script>

<style scoped>
.settings-container {
    box-shadow: 2px 2px lightgray;
    border-radius: 5px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    margin-left: 30px;
    padding: 7px;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: white;
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
.bold {
  font-weight: bold;
}
.margin-tb-5 {
  margin-top: 5px;
  margin-bottom: 5px;
}

.btn-primary {
  background-color: rgb(32, 120, 209);
  padding: 3px;
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  font-size: 12px;
  font-weight: bold;
  width: 25%;
}
</style>