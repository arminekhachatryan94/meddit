<template>
<div class="post-container bg-white text-left row">
  <div class="col-md-1 padding-top-15">
    <img @click="redirectTo()" class="cursor" src="../assets/posts/chat-bubble.png" width="50">
  </div>
  <div class="col-md-11">
    <div v-if="!this.editing" v-text="this.title" class="title"></div>
    <input v-if="this.editing" v-model="newpost.title" @keydown="clearTitleError()" name="title" type="text" class="title" required>
    <div v-if="this.errors.title.length" v-text="this.errors.title" class="text-danger font-size"></div>

    <div class="container2">
      <div class="text-gray user-date">
        <!-- view body -->
        <a v-if="!this.editing" @click="showBody" :id="'op' + this.id" class="text-gray cursor">[-]</a>
        <a href="#" class="username padding-r-5"><b>{{this.user.username}}</b></a>
        <i :id="'time' + this.id" data-toggle="tooltip">{{this.timeAgo()}}</i>
        <u v-if="this.dateTime != this.updatedAt">Edited</u>
      </div>

      <div v-if="!this.editing && this.show_body" v-text="this.body" class="body"></div>
      <div class="body">
        <textarea v-if="this.editing" v-model="newpost.body" @keydown="clearBodyError()" name="body" class="edit-body" required></textarea>
      </div>
      <div v-if="this.errors.body.length" v-text="this.errors.body" class="text-danger font-size"></div>

      <div>
        <a v-if="comments.length != 1" href="#" @click.prevent="showComments()" class="ops">{{this.comments.length}} comments</a>
        <a v-if="comments.length == 1" href="#" @click.prevent="showComments()" class="ops">{{this.comments.length}} comment</a>
        <a href="#" v-if="!this.editing && this.editPermission()" @click.prevent="editPost()" class="ops">edit</a>
        <a href="#" v-if="this.editing && this.editPermission()" @click.prevent="savePost" class="ops">save</a>
        <a href="#" v-if="this.editing && this.editPermission()" @click.prevent="cancelPost()" class="ops">cancel</a>
        <a href="#" v-if="this.deletePermission()" @click.prevent="deletePost" class="ops">delete</a>
      </div>
      <div v-if="show_comments" class="comments">
        <comment v-if="comments.length" v-for="comment in comments"
          :key="comment.id"
          :id="comment.id"
          :body="comment.body"
          :user="comment.user"
          :comments="comment.comments"
          :dateTime="comment.created_at"
          :updatedAt="comment.updated_at"
          @delete-comment="deleteComment"
          @edit-comment="editComment">
        </comment>
        <div v-if="!comments.length">No comments</div>
      </div>

      <!-- new comment -->
      <div v-if="this.$store.state.auth" class="comment-container">
        <div>
          <textarea type="text" v-model="newcomment.body" class="w-100 h-100"></textarea>
        </div>
        <div>
          <button @click="postComment()" class="btn btn-primary">Comment</button>
        </div>
      </div>
    </div>
  </div>
  <!--div class="col-md-11">
    <form method="PUT" @submit.prevent="savePost">
      <div class="form-group">
        <input v-model="newpost.title" name="title" type="text" required>
      </div>
      <div class="form-group">
        <textarea v-model="newpost.body" name="body" required></textarea>
      </div>
      <button type="submit">Save</button>
    </form>
  </div-->
</div>
</template>

<script>
import moment from 'moment'
import axios from 'axios'
import Comment from './Comment'
import User from './User'

export default {
  name: 'Post',
  props: {
    id: Number,
    title: String,
    body: String,
    dateTime: String,
    updatedAt: String,
    user: User,
    comments: Array
  },
  components: { Comment, User },
  data () {
    return {
      editing: false,
      show_body: true,
      show_comments: false,
      newpost: {
        title: this.title,
        body: this.body
      },
      errors: {
        body: '',
        title: ''
      },
      newcomment: {
        body: ''
      },
      comment_errors: {
        body: ''
      }
    }
  },
  methods: {
    timeAgo: function () {
      return moment(this.dateTime).fromNow()
    },
    time: function () {
      document.getElementById('time' + this.id).title = moment(this.dateTime).format('MMMM DD YYYY, h:mma')
    },
    showBody: function () {
      var op = document.getElementById('op' + this.id)
      if (this.show_body) {
        op.innerHTML = '[+]'
        this.show_body = false
      } else {
        op.innerHTML = '[-]'
        this.show_body = true
      }
    },
    showComments: function () {
      if (this.show_comments) {
        this.show_comments = false
      } else {
        this.show_comments = true
      }
    },
    editPost: function () {
      if (this.$store.state.user.id === this.user.id) {
        this.editing = true
      } else {
        alert('You do not have permission to edit this post')
      }
    },
    cancelPost: function () {
      this.editing = false
      this.newpost.title = this.title
      this.newpost.body = this.body
      this.errors.body = ''
      this.errors.title = ''
    },
    savePost (event) {
      var self = this
      if (this.editPermission()) {
        axios.put('http://127.0.0.1:8000/api/posts/' + this.id, {
          user_id: this.$store.state.user.id,
          title: this.newpost.title,
          body: this.newpost.body
        }).then(function (response) {
          self.$emit('edit', response.data.post)
          self.editing = false
          alert('Post saved')
        }).catch(function (error) {
          var errors = error.response.data.errors
          if (typeof errors.body !== 'undefined') {
            self.errors.body = errors.body[0]
          }
          if (typeof errors.title !== 'undefined') {
            self.errors.title = errors.title[0]
          }
        })
      } else {
        console.log('error')
      }
    },
    deletePost (event) {
      var self = this
      if (this.deletePermission()) {
        axios.delete('http://127.0.0.1:8000/api/posts/' + this.id, {
          params: {
            'user_id': this.$store.state.user.id
          }
        }).then(function (response) {
          // alert(response.data.post);
          self.$emit('delete', self.id)
          // location.href = '/#/posts'
        }).catch(function (error) {
          console.log(error.response.data)
        })
      } else {
        alert('You do not have permission to delete this post')
      }
    },
    editPermission () {
      if (this.$store.state.user.id === this.user.id) {
        return true
      } else {
        return false
      }
    },
    deletePermission () {
      if (this.$store.state.user.id === this.user.id) {
        return true
      } else if (this.$store.state.user.role === 1) {
        return true
      } else {
        return false
      }
    },
    clearBodyError () {
      this.errors.body = ''
    },
    clearTitleError () {
      this.errors.title = ''
    },
    postComment () {
      if (this.newcomment.body.length === 0) {
        this.comment_errors.body = 'Body is required'
      } else {
        axios.post('http://127.0.0.1:8000/api/posts/' + this.id + '/new-comment', {
          body: this.newcomment.body,
          user_id: this.$store.state.user.id
        }).then((response) => {
          this.comments.push(response.data.comment)
          this.show_comments = true
          this.newcomment.body = ''
        }).catch((error) => {
          console.log(error.response.data)
        })
      }
    },
    deleteComment (id) {
      for (var i = 0; i < this.comments.length; i++) {
        if (this.comments[i].id === id) {
          this.comments.splice(i, 1)
          break
        }
      }
    },
    editComment (comment) {
      for (var i = 0; i < this.comments.length; i++) {
        if (this.comments[i].id === comment.id) {
          this.comments[i].body = comment.body
        }
      }
    },
    redirectTo () {
      this.$router.push('/posts/' + this.id)
    }
  },
  mounted () {
    this.time()
  }
}
</script>

<style scoped>
.post-container {
    box-shadow: 2px 2px lightgray;
    border-radius: 5px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    margin-left: 30px;
    padding: 7px;
    padding-top: 5px;
}
.container2 {
    padding-left: 20px;
}
.bg-white {
    background-color: white;
}
.text-gray {
    color: gray;
}
.padding-r-5 {
    padding-right: 5px;
}
.padding-top-15 {
  padding-top: 15px;
}
.cursor {
  cursor: pointer;
}
.comments {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  font-size: 12px;
  padding-top: 10px;
  border-top: 1px solid lightgray;
}
.comment-container {
  width: 100%;
}
.btn-primary {
  background-color: rgb(32, 120, 209);
  padding: 3px;
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  font-size: 12px;
  font-weight: bold;
  width: 100%;
}
.w-100 {
  width: 100%
}
.h-100 {
  height: 100px;
}

.title {
    font-size: 15px;
}
.body {
    font-size: 12px;
    padding-top: 3px;
}
.edit-body {
  width: 100%;
  height: 150px;
}
.user-date {
  font-size: 10px;
}
.font-size {
  font-size: 12px;
}

.ops {
    color: gray;
    font-size: 10px;
    font-weight: bold;
}

img {
  border-radius: 50%;
}
</style>
