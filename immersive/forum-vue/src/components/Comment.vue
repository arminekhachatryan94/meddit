<template>
<div class="comment-container bg-white text-left">
  <div v-if="!this.editing">
    <div class="comment-container2">
      <div class="text-gray user-date">
        <!-- view body -->
        <a @click="showBody" :id="'op-c-' + this.id" class="text-gray cursor">[-]</a>
        <a href="#" class="username padding-r-5"><b>{{this.user.username}}</b></a>
        <i :id="'time-c-' + this.id" data-toggle="tooltip">{{this.timeAgo()}}</i>
      </div>
      <div v-if="this.show_body" v-text="this.body" class="body"></div>
      <div>
        <a href="#" @click.prevent="editComment()" class="ops-c">edit</a>
        <a href="#" @click.prevent="deleteComment()" class="ops-c">delete</a>
      </div>
    </div>
  </div>
  <div v-if="this.editing">
    <form method="PUT" @submit.prevent="saveComment">
      <div class="form-group">
        <textarea v-model="newcomment.body" name="body" required></textarea>
      </div>
      <button type="submit">Save</button>
    </form>
  </div>
</div>
</template>

<script>
import moment from 'moment'

export default {
  name: 'Comment',
  props: {
    id: Number,
    body: String,
    dateTime: String,
    user: Object
  },
  data () {
    return {
      editing: false,
      show_body: true,
      newcomment: {
        body: this.body
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
    showBody: function () {
      var op = document.getElementById('op-c' + this.id)
      if (this.show_body) {
        op.innerHTML = '[+]'
        this.show_body = false
      } else {
        op.innerHTML = '[-]'
        this.show_body = true
      }
    },
    editComment: function () {
      if (this.editing) {
        this.editing = false
      } else {
        this.editing = true
        this.newcomment.body = this.body
      }
    },
    saveComment: function () {
      this.editing = false
      alert('Comment saved')
    },
    deleteComment: function () {
      alert('Comment successfully deleted')
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

.title {
    font-size: 15px;
}
.body {
    font-size: 12px;
    padding-top: 3px;
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
</style>
