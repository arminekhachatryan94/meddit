<template>
<div class="comment-container bg-white text-left">
  <div>
    <div class="comment-container2">
      <div class="text-gray user-date">
        <!-- view body -->
        <a href="#" class="username padding-r-5"><b>{{this.user.username}}</b></a>
        <i :id="'time-c-' + this.id" data-toggle="tooltip">{{this.timeAgo()}}</i>
      </div>
      <div v-if="!this.editing" v-text="this.body" class="body"></div>
      <div class="body" v-if="this.editing">
        <textarea v-model="newcomment.body" @keydown="clearError()" name="body" class="edit-body" required></textarea>
      </div>
      <div v-if="this.errors.body.length" v-text="this.errors.body" class="text-danger font-size"></div>
      <div>
        <a href="#" v-if="this.$store.state.auth" @click.prevent="replyComment()" class="ops-c">reply</a>
        <a href="#" v-if="!this.editing && this.editPermission()" @click.prevent="editComment()" class="ops-c">edit</a>
        <a href="#" v-if="this.editing && this.editPermission()" @click.prevent="saveComment" class="ops-c">save</a>
        <a href="#" v-if="this.editing && this.editPermission()" @click.prevent="cancelComment()" class="ops-c">cancel</a>
        <a href="#" v-if="this.deletePermission()" @click.prevent="deleteComment" class="ops-c">delete</a>
      </div>
    </div>
  </div>
  <!-- new comment -->
  <div v-if="this.$store.state.auth && this.replying" class="comment-container">
    <div>
      <textarea type="text" v-model="publish_comment.body" class="w-100 h-100"></textarea>
    </div>
    <div>
      <button @click.prevent="postComment()" class="btn btn-primary">Reply</button>
      <a href="#" @click.prevent="cancelReply()">Cancel</a>
    </div>
  </div>
  <!-- all comments -->
  <comment v-for="comment in comments"
    v-if="comments.length"
    :key="comment.id"
    :id="comment.id"
    :body="comment.body"
    :user="comment.user"
    :comments="comment.comments"
    :dateTime="comment.created_at"
    @delete-comment="deleteCommentEvent"
    @edit-comment="editCommentEvent">
    </comment>
</div>
</template>

<script>
import moment from 'moment'
import axios from 'axios'

export default {
  name: 'Comment',
  props: {
    id: Number,
    body: String,
    dateTime: String,
    user: Object,
    comments: Array
  },
  data () {
    return {
      editing: false,
      replying: false,
      newcomment: {
        body: this.body
      },
      errors: {
        body: ''
      },
      publish_comment: {
        body: ''
      }
    }
  },
  methods: {
    timeAgo: function () {
      return moment(this.dateTime).fromNow()
    },
    time: function () {
      document.getElementById('time-c-' + this.id).title = moment(this.dateTime).format('MMMM DD YYYY, h:mma')
    },
    editComment () {
      if (this.$store.state.user.id === this.user.id) {
        this.editing = true
      } else {
        alert('You do not have permission to edit this post')
      }
    },
    saveComment: function () {
      var self = this
      if (this.editPermission()) {
        axios.put('http://127.0.0.1:8000/api/comments/' + this.id, {
          user_id: this.$store.state.user.id,
          body: this.newcomment.body
        }).then(function (response) {
          self.$emit('edit-comment', response.data.comment)
          self.editing = false
          alert('Comment saved')
        }).catch(function (error) {
          var errors = error.response.data.errors
          if (typeof errors.body !== 'undefined') {
            self.errors.body = errors.body[0]
          }
        })
      } else {
        console.log('error')
      }
    },
    cancelComment: function () {
      this.editing = false
      this.newcomment.body = this.body
    },
    deleteComment (event) {
      var self = this
      if (this.deletePermission()) {
        axios.delete('http://127.0.0.1:8000/api/comments/' + this.id, {
          params: {
            'user_id': this.$store.state.user.id
          }
        }).then(function (response) {
          // alert(response.data.post)
          self.$emit('delete-comment', self.id)
          // location.href = '/#/posts'
        }).catch(function (error) {
          console.log(error.response.data.errors)
        })
      } else {
        alert('You do not have permission to delete this comment')
      }
    },
    deleteCommentEvent (id) {
      for (var i = 0; i < this.comments.length; i++) {
        if (this.comments[i].id === id) {
          this.comments.splice(i, 1)
          break
        }
      }
    },
    editCommentEvent (comment) {
      for (var i = 0; i < this.comments.length; i++) {
        if (this.comments[i].id === comment.id) {
          this.comments[i].body = comment.body
        }
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
    clearError () {
      this.errors.body = ''
    },
    replyComment () {
      this.replying = true
    },
    cancelReply () {
      this.replying = false
      this.errors.body = ''
    },
    postComment () {
      axios.post('http://127.0.0.1:8000/api/comments/' + this.id + '/new-comment', {
        body: this.publish_comment.body,
        user_id: this.$store.state.user.id
      }).then((response) => {
        this.comments.unshift(response.data.comment)
        this.publish_comment.body = ''
        this.errors.body = ''
        this.replying = false
      }).catch((error) => {
        console.log(error.response.data)
      })
    }
  },
  mounted () {
    this.time()
  }
}
</script>

<style scoped>
.comment-container {
    border-radius: 5px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    margin-left: 10px;
    padding: 7px;
    padding-top: 5px;
}
.comment-container2 {
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

.body {
    font-size: 12px;
    padding-top: 3px;
}
.edit-body {
  width: 100%;
  height: 100px;
}
.user-date {
    font-size: 10px;
}

.ops-c {
    color: gray;
    font-size: 10px;
    font-weight: bold;
}

img {
  border-radius: 50%;
}

.btn-primary {
  background-color: rgb(32, 120, 209);
  padding: 3px;
  padding-left: 10px;
  padding-right: 10px;
  margin-right: 5px;
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  font-size: 12px;
  font-weight: bold;
}
</style>
