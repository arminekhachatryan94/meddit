<template>
<div>
    <div>POSTS</div>
    <br>
    <post v-for="post in posts"
        :key="post.id"
        :id="post.id"
        :title="post.title"
        :body="post.body"
        :dateTime="post.created_at"
        :user="post.user"
        class="margin-bottom-10 padding-20">
    </post>
</div>
</template>

<script>
import Post from '../components/Post'
import axios from 'axios'

export default {
  name: 'Posts',
  data: function () {
    return {
      posts: []
    }
  },
  components: { Post },
  created () {
    axios.get('http://127.0.0.1:8000/api/posts').then((response) => {
      this.posts = response.data.posts
    }).catch(function (error) {
      console.log(error)
    })
  }
}
</script>

<style scoped>
.margin-bottom-10 {
    margin-bottom: 10px;
}
</style>
