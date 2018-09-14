<template>
<div>
    <div class="text-left margin-left-40 margin-bottom-10 font-style">POSTS</div>
    <post
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

export default {
  name: 'SinglePost',
  data: function () {
    return {
      post: Post
    }
  },
  components: { Post },
  methods: {
    deletePost (id) {
      if (this.post.id === id) {
        this.$router.push('/posts')
      }
    },
    editPost (post) {
      if (this.id === post.id) {
        this.post.title = post.title
        this.post.body = post.body
        this.post.updated_at = post.updated_at
      }
    }
  },
  created () {
    axios.get('http://127.0.0.1:8000/api/posts/' + this.$route.params.id).then((response) => {
      console.log(response.data)
      this.post = response.data.post
    }).catch(function (error) {
      console.log(error)
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
