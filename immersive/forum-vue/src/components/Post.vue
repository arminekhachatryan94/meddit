<template>
<div class="post-container bg-white text-left">
    <div v-text="this.title" class="title"></div>
    <div class="container2">
        <div class="text-gray user-date">
            <!-- view body -->
            <a href="#" class="text-gray">[-]</a>
            <a href="#" class="username padding-r-5"><b>{{this.user.username}}</b></a>
            <i :id="'time' + this.id" data-toggle="tooltip">{{this.timeAgo()}}</i>
        </div>
        <div v-text="this.body" class="body"></div>
        <div>
            <a href="comments" class="ops">comments</a>
            <a href="#" class="ops">edit</a>
            <a href="#" class="ops">delete</a>
        </div>
    </div>
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
      editing: false
    }
  },
  methods: {
    timeAgo: function () {
      return moment(this.dateTime).fromNow()
    },
    time: function () {
      document.getElementById('time' + this.id).title = moment(this.dateTime).format('MMMM DD YYYY, h:mma')
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
