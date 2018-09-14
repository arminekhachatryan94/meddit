<template>
<div>
  <div class="text-left margin-left-40 margin-bottom-10 font-style">USER ROLES</div>
  <div class="margin-bottom-5">
    <role :firstname="'First Name'"
      :lastname="'Last Name'"
      :username="'Username'"
      :email="'Email'"
      :role="'Role'"
      class="bold margin-tb-5"></role>

    <role v-for="user in users"
      :id="user.id"
      :firstname="user.first_name"
      :lastname="user.last_name"
      :username="user.username"
      :email="user.email"
      :role="user.role"
      :key="user.id"
      class="margin-tb-5"
      @delete-user="deleteUser"
      @edit-user="editUser"></role>
  </div>
</div>
</template>

<script>
import Role from '../components/Role'
import axios from 'axios'

export default {
  name: 'Users',
  components: { Role },
  data () {
    return {
      users: []
    }
  },
  created () {
    axios.get('http://127.0.0.1:8000/api/' + this.$store.state.user.id + '/users').then((response) => {
      this.users = response.data.users
    }).catch(function (error) {
      console.log(error.response.data)
    })
  },
  methods: {
    deleteUser (id) {
      for (var i = 0; i < this.users.length; i++) {
        if (this.users[i].id === id) {
          this.users.splice(i, 1)
          break
        }
      }
    },
    editUser (user) {
      for (var i = 0; i < this.users.length; i++) {
        if (this.users[i].id === user.id) {
          this.users[i].role = user.role
          break
        }
      }
    }
  }
}
</script>

<style scoped>
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
</style>
