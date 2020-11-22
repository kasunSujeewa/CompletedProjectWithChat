<template>
  <div>
    <div class="card my-4">
      <h5 class="card-header">Leave a Comment:</h5>
      <div class="card-body">
        <div class="form-group">
          <textarea
            class="form-control"
            name="newOne"
            v-model="newOne"
            rows="1"
          ></textarea>
        </div>
        <button
          type="submit"
          class="btn btn-primary"
          @click="commentPost(newOne)"
        >
          Submit
        </button>
      </div>
    </div>

    <!-- Single Comment -->
    <div class="media mb-4" v-for="comment in comments" :key="comment.id">
      <img
        class="d-flex mr-3 rounded-circle"
        :src="avatar + comment.user.avatar"
        width="50px"
        height="50px"
        alt=""
      />
      <div class="media-body">
        <h5 class="mt-0">{{ comment.user.name }}</h5>
        {{ comment.comment }}
      </div>
      <button
        class="btn btn-link"
        v-if="admin.id == comment.user.id || admin.id == post.user"
        @click="delcomment(comment.id)"
      >
        Delete
      </button>
    </div>
  </div>
</template>
<script>
export default {
  props: ["post", "admin"],
  data() {
    return {
      comments: [],
      newComment: {
        comment: "",
      },
      newOne: "",
      commentID: "",
      avatar: "../",
      commentStatus: [],
    };
  },
  mounted() {
    this.getComment();
  },
  methods: {
    getComment: function () {
      axios
        .get("/comment/" + this.post.id)
        .then((response) => {
          this.comments = response.data.comment;
          this.newOne = "";
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    commentPost(newOne) {
      this.newComment.comment = newOne;
      console.log(this.post);
      axios
        .post("/comment/" + this.post.id, this.newComment)
        .then((response) => {
          this.getComment();
          this.commentStatus = response.data.message;

          this.$emit("NewcommentUpdate", this.commentStatus);
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    delcomment(commentID) {
      axios
        .delete("/comment/" + commentID)
        .then((response) => {
          this.getComment();
          this.commentStatus = response.data.message;

          this.$emit("NewcommentUpdate", this.commentStatus);
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
  },
};
</script>
