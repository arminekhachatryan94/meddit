<template>
<div class="post-container bg-white text-left row">
  <div class="col-md-1 padding-top-15">
    <img src="../assets/posts/chat-bubble.png" width="50">
  </div>
  <div class="col-md-11">
    <div v-if="!this.editing" v-text="this.title" class="title"></div>
    <input v-if="this.editing" v-model="newpost.title" name="title" type="text" class="title" required>
    <div class="container2">
      <div class="text-gray user-date">
        <!-- view body -->
        <a v-if="!this.editing" @click="showBody" :id="'op' + this.id" class="text-gray cursor">[-]</a>
        <a href="#" class="username padding-r-5"><b>{{this.user.username}}</b></a>
        <i :id="'time' + this.id" data-toggle="tooltip">{{this.timeAgo()}}</i>
      </div>
      <div v-if="!this.editing && this.show_body" v-text="this.body" class="body"></div>
      <div class="body">
        <textarea v-if="this.editing" v-model="newpost.body" name="body" class="edit-body" required></textarea>
      </div>
      <div>
        <a v-if="comments.length != 1 " href="#" @click.prevent="showComments()" class="ops">{{this.comments.length}} comments</a>
        <a v-if="comments.length == 1 " href="#" @click.prevent="showComments()" class="ops">{{this.comments.length}} comment</a>
        <a href="#" v-if="!this.editing" @click.prevent="editPost()" class="ops">edit</a>
        <a href="#" v-if="this.editing" @click.prevent="savePost" class="ops">save</a>
        <a href="#" v-if="this.editing" @click.prevent="cancelPost()" class="ops">cancel</a>
        <a href="#" @click.prevent="deletePost" class="ops">delete</a>
      </div>
      <div v-if="show_comments" class="comments">
        <comment v-if="comments.length" v-for="comment in comments"
          :key="comment.id"
          :id="comment.id"
          :body="comment.body"
          :user="comment.user"
          :dateTime="comment.created_at">
        </comment>
        <div v-if="!comments.length">No comments</div>
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
      this.editing = true
    },
    cancelPost: function () {
      this.editing = false
      this.newpost.title = this.title
      this.newpost.body = this.body
    },
    savePost (event) {
      var self = this
      axios.put('http://127.0.0.1:8000/api/posts/' + this.id, {
        user_id: this.user.id,
        title: this.newpost.title,
        body: this.newpost.body
      }).then(function (response) {
        self.$emit('edit', response.data.post)
        self.editing = false
        alert('Post saved')
      }).catch(function (error) {
        console.log(error)
      })
    },
    deletePost (event) {
      var self = this
      axios.delete('http://127.0.0.1:8000/api/posts/' + this.id, {
        params: {
          'user_id': this.user.id
        }
      }).then(function (response) {
        // alert(response.data.post);
        self.$emit('delete', self.id)
        // location.href = '/#/posts'
      }).catch(function (error) {
        console.log(error)
      })
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

.ops {
    color: gray;
    font-size: 10px;
    font-weight: bold;
}

img {
  border-radius: 50%;
}
</style>
