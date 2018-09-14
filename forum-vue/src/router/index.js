import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home'
import Login from '@/views/Login'
import Register from '@/views/Register'
import Posts from '@/views/Posts'
import SinglePost from '@/views/SinglePost'
import Users from '@/views/Users'
import Settings from '@/views/Settings'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/posts',
      name: 'Posts',
      component: Posts
    },
    {
      path: '/posts/:id',
      name: 'SinglePost',
      component: SinglePost
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/user-roles',
      name: 'Users',
      component: Users
    },
    {
      path: '/settings',
      name: 'Settings',
      component: Settings
    }
  ]
})
