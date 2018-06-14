<template>
<div class="post-container bg-white text-left">
    <div v-if="!this.editing">
        <div v-text="this.title" class="title"></div>
        <div class="container2">
            <div class="text-gray user-date">
                <!-- view body -->
                <a @click="showBody" :id="'op' + this.id" class="text-gray">[-]</a>
                <a href="#" class="username padding-r-5"><b>{{this.user.username}}</b></a>
                <i :id="'time' + this.id" data-toggle="tooltip">{{this.timeAgo()}}</i>
            </div>
            <div v-if="this.show_body" v-text="this.body" class="body"></div>
            <div>
                <a href="#" @click.prevent="showComments()" class="ops">comments</a>
                <a href="#" @click.prevent="editPost()" class="ops">edit</a>
                <a href="#" @click.prevent="deletePost()" class="ops">delete</a>
            </div>
            <div v-if="show_comments">
            </div>
        </div>
    </div>
    <div v-if="this.editing">
        <form method="PUT" @submit.prevent="savePost">
            <div class="form-group">
                <input v-model="newpost.title" name="title" type="text" required>
            </div>
            <div class="form-group">
                <textarea v-model="newpost.body" name="body" required></textarea>
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
    <div v-text="newpost.title"></div>
    <div v-text="newpost.body"></div>
</div>
</template>

<script>
import moment from 'moment'

export default {
  name: 'Post',
  props: {
    id: Number,
    title: String,
    body: String,
    dateTime: String,
    user: Object,
    comments: Array
  },
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
      if (this.editing) {
        this.editing = false
      } else {
        this.editing = true
        this.newpost.title = this.title
        this.newpost.body = this.body
      }
    },
    savePost: function () {
      this.editing = false
      alert('Post saved')
    },
    deletePost: function () {
        alert('Post successfully deleted')
    }
  },
  mounted () {
    this.time()
  }
}
</script>

<style scoped>
.post-container {
    /* box-shadow: 2px 2px lightgray; */
    border-radius: 5px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    margin-left: 40px;
    margin-right: 40px;
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

.ops {
    color: gray;
    font-size: 10px;
    font-weight: bold;
}
</style>
