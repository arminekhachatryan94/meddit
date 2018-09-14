<template>
<div class="role-container bg-white text-left row">
    <div class="col-md-2" v-text="this.firstname"></div>
    <div class="col-md-2" v-text="this.lastname"></div>
    <div class="col-md-2" v-text="this.email"></div>
    <div class="col-md-2" v-text="this.username"></div>
    <div v-if="this.role != 0 && this.role != 1" class="col-md-1">Role</div>
    <select v-model="newrole" v-if="this.role == 1" class="col-md-1">
        <option value="1" selected>Admin</option>
        <option value="0">User</option>
    </select>
    <select v-model="newrole" v-if="this.role == 0" class="col-md-1">
        <option value="0" selected>User</option>
        <option value="1">Admin</option>
    </select>
    <div class="col-md-1 text-center">
        <button v-if="this.role == 0 || this.role == 1" class="btn btn-primary" @click="saveUser()">Save</button>
    </div>
    <div class="col-md-2 text-center">
        <button v-if="this.role == 0 || this.role == 1" class="btn btn-danger" @click="deleteUser">Delete</button>
    </div>
</div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Role',
  props: {
    id: Number,
    firstname: String,
    lastname: String,
    email: String,
    role: Boolean,
    username: String
  },
  data () {
    return {
      newrole: this.role
    }
  },
  methods: {
    deleteUser (event) {
      var self = this
      axios.delete('http://127.0.0.1:8000/api/' + this.$store.state.user.id + '/users', {
        params: {
          'user_id': this.id
        }
      }).then(function (response) {
        alert('User was successfully deleted.')
        // alert(response.data.post);
        self.$emit('delete-user', self.id)
        // location.href = '/#/posts'
      }).catch(function (error) {
        console.log(error.response.data)
      })
    },
    saveUser () {
      console.log(this.newrole)
      var self = this
      axios.put('http://127.0.0.1:8000/api/' + this.$store.state.user.id + '/users', {
        user_id: this.id,
        role: this.newrole
      }).then(function (response) {
        console.log(response.data)
        var user = {
          role: self.newrole,
          id: self.id
        }
        self.$emit('edit-user', user)
        alert('User was successfully saved')
      }).catch(function (error) {
        console.log(error.response.data)
      })
    }
  }
}
</script>

<style scoped>
.role-container {
    box-shadow: 2px 2px lightgray;
    border-radius: 5px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    margin-left: 30px;
    padding: 7px;
    padding-top: 5px;
}
.btn-primary {
    background-color: rgb(32, 120, 209);
    padding: 3px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: 12px;
    font-weight: bold;
    width: 50px;
}
.btn-danger {
    padding: 3px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: 12px;
    font-weight: bold;
    width: 70px;
}
</style>
