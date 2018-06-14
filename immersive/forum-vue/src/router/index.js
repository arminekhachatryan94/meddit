import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/views/Home'
import Posts from '@/views/Posts'

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
    }
  ]
})
