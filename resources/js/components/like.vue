<template>
  <div>
    <div v-if="likeID.includes(admin.id) || dislikeID.includes(admin.id)">
      <div v-if="likeID.includes(admin.id)">
        <a class="m-2">
          <i class="fa fa-thumbs-up" aria-hidden="true" @click="delLike()"
            >Like</i
          >
        </a>
        <a class="m-2">
          <i
            class="fa fa-thumbs-down btn-light"
            aria-hidden="true"
            @click="Updateunlike()"
            >UnLike</i
          >
        </a>
      </div>
      <div v-else>
        <a class="m-2">
          <i
            class="fa fa-thumbs-up btn-light"
            aria-hidden="true"
            @click="upLike()"
            >Like</i
          >
        </a>
        <a class="m-2">
          <i class="fa fa-thumbs-down" aria-hidden="true" @click="delLike()"
            >UnLike</i
          >
        </a>
      </div>
    </div>
    <div v-else>
      <a class="m-2">
        <i
          class="fa fa-thumbs-up btn-light"
          aria-hidden="true"
          @click="ItsLike()"
          >Like</i
        >
      </a>
      <a class="m-2">
        <i
          class="fa fa-thumbs-down btn-light"
          aria-hidden="true"
          @click="unlike()"
          >UnLike</i
        >
      </a>
    </div>
  </div>
</template>
<script>
export default {
  props: ["id", "admin", "getPost"],
  data() {
    return {
      likeID: [],
      dislikeID: [],
      reactIt: {
        status: "",
      },
      situation: [],
    };
  },
  mounted() {
    this.getLike();
  },

  computed: {},
  methods: {
    getLike: function () {
      axios.get("/Like/" + this.id).then((response) => {
        this.likeID = response.data.like;
        this.dislikeID = response.data.dislike;
      });
    },
    ItsLike() {
      this.reactIt.status = true;
      axios
        .post("/addLike/" + this.id, this.reactIt)
        .then((response) => {
          //console.log("liked");

          this.likeID = response.data.like;
          this.dislikeID = response.data.dislike;
          this.situation = response.data.message;
          this.$emit("reacted", this.situation);
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    unlike() {
      this.reactIt.status = false;
      axios
        .post("/addLike/" + this.id, this.reactIt)
        .then((response) => {
          //console.log("unliked");
          this.getLike();
          this.situation = response.data.message;
          this.$emit("reacted", this.situation);
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    delLike() {
      axios
        .delete("/delLike/" + this.id)
        .then((response) => {
          // console.log("deleted");
          this.likeID = response.data.like;
          this.dislikeID = response.data.dislike;
          this.situation = response.data.message;
          this.$emit("reacted", this.situation);
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    Updateunlike() {
      this.reactIt.status = false;
      axios
        .post("/upLike/" + this.id, this.reactIt)
        .then((response) => {
          // console.log("unliked");
          this.getLike();
          this.situation = response.data.message;
          this.$emit("reacted", this.situation);
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    upLike() {
      this.reactIt.status = true;
      axios
        .post("/upLike/" + this.id, this.reactIt)
        .then((response) => {
          // console.log("liked");
          this.getLike();
          this.situation = response.data.message;
          this.$emit("reacted", this.situation);
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
  },
  created() {
    Echo.channel("chat").listen("DemoEvent", (e) => {
      this.getLike();
      this.$emit("reacted");
    });
  },
};
</script>
<style lang="scss" scoped>
i {
  cursor: pointer;
}
</style>
