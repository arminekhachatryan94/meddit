<template>
<div>
    <div class="text-left margin-left-40 margin-bottom-10 font-style">POSTS</div>
    <post v-for="post in posts"
        :key="post.id"
        :id="post.id"
        :title="post.title"
        :body="post.body"
        :dateTime="post.created_at"
        :updatedAt="post.updated_at"
        :user="post.user"
        :comments="post.comments"
        class="margin-bottom-5"
        @delete="deletePost"
        @edit="editPost">
    </post>
</div>
</template>

<script>
import Post from '../components/Post'
import axios from 'axios'
import EventBus from '../components/event-bus'

export default {
  name: 'Posts',
  data: function () {
    return {
      posts: Array
    }
  },
  components: { Post },
  methods: {
    deletePost (id) {
      for (var i = 0; i < this.posts.length; i++) {
        if (this.posts[i].id === id) {
          this.posts.splice(i, 1)
          break
        }
      }
    },
    editPost (post) {
      for (var i = 0; i < this.posts.length; i++) {
        if (this.posts[i].id === post.id) {
          this.posts[i].title = post.title
          this.posts[i].body = post.body
          this.posts[i].updated_at = post.updated_at
        }
      }
    }
  },
  created () {
    axios.get('http://127.0.0.1:8000/api/posts').then((response) => {
      this.posts = response.data.posts
    }).catch(function (error) {
      console.log(error)
    })
  },
  mounted () {
    let self = this
    EventBus.$on('new', function (post) {
      self.posts.unshift(post)
    })
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
</style>
