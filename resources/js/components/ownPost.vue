<template>
  <div>
    <div v-for="post in posts" :key="post.id" class="m-3">
      <div v-if="post.image">
        <h1 class="mt-4">{{ post.postName }}</h1>

        <!-- Author -->
        <p class="lead">
          by
          <a href="#">{{ post.user.name }}</a>
        </p>
        <div class="justify-content-end" v-if="post.user.id == user2.id">
          <div class="dropdown">
            <button
              class="btn btn-link dropdown-toggle"
              type="button"
              id="gedf-drop1"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="fa fa-ellipsis-h"></i>
            </button>
            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="gedf-drop1"
            >
              <div class="h6 dropdown-header">Configuration</div>
              <button
                data-toggle="modal"
                data-target="#Edit_post"
                id="submit"
                class="dropdown-item"
                @click="newModel(post)"
              >
                Edit
              </button>
              <button
                class="dropdown-item"
                data-toggle="modal"
                data-target="#Delete_post"
                @click="removeIt(post)"
              >
                Delete
              </button>
              <a class="dropdown-item" href="#">Report</a>
            </div>
          </div>
        </div>

        <hr />

        <!-- Date/Time -->
        <p>{{ post.created_at }}</p>

        <hr />

        <!-- Preview Image -->
        <img
          class="img-fluid rounded"
          :src="newPath + avatar + post.image"
          alt=""
        />

        <hr />

        <!-- Post Content -->
        <p class="lead">{{ post.description }}</p>

        <hr />
        <small
          ><span
            ><i class="fa fa-thumbs-o-up" aria-hidden="true"></i
            >{{ post.likes.length }}</span
          >
          <span
            ><i class="fa fa-thumbs-o-down" aria-hidden="true"></i
            >{{ post.dislikes.length }}</span
          >
          <span
            ><i class="fa fa-comments" aria-hidden="true"></i
            >{{ post.comment.length }}</span
          >
        </small>
        <like @reacted="updateCount" :id="post.id" :admin="user2"></like>

        <comment
          @NewcommentUpdate="newComment"
          :post="post"
          :admin="user2"
        ></comment>
      </div>
      <div v-else>
        <h1 class="mt-4">{{ post.postName }}</h1>

        <!-- Author -->
        <p class="lead">
          by
          <a href="#">{{ post.user.name }}</a>
        </p>
        <div class="justify-content-end" v-if="post.user.id == user2.id">
          <div class="dropdown">
            <button
              class="btn btn-link dropdown-toggle"
              type="button"
              id="gedf-drop1"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="fa fa-ellipsis-h"></i>
            </button>
            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="gedf-drop1"
            >
              <div class="h6 dropdown-header">Configuration</div>
              <button
                data-toggle="modal"
                data-target="#Edit_post"
                id="submit"
                class="dropdown-item"
                @click="newModel(post)"
              >
                Edit
              </button>
              <button
                class="dropdown-item"
                data-toggle="modal"
                data-target="#Delete_post"
                @click="removeIt(post)"
              >
                Delete
              </button>
              <a class="dropdown-item" href="#">Report</a>
            </div>
          </div>
        </div>
        <hr />

        <!-- Date/Time -->
        <p>{{ post.created_at }}</p>

        <hr />

        <!-- Preview Image -->

        <!-- Post Content -->
        <p class="lead">{{ post.description }}</p>

        <hr />
        <small
          ><span
            ><i class="fa fa-thumbs-o-up" aria-hidden="true"></i
            >{{ post.likes.length }}</span
          >
          <span
            ><i class="fa fa-thumbs-o-down" aria-hidden="true"></i
            >{{ post.dislikes.length }}</span
          >
          <span
            ><i class="fa fa-comments" aria-hidden="true"></i
            >{{ post.comment.length }}</span
          >
        </small>
        <like @reacted="updateCount" :id="post.id" :admin="user2"></like>

        <comment
          @NewcommentUpdate="newComment"
          :post="post"
          :admin="user2"
        ></comment>
      </div>
      <div
        class="modal fade"
        id="Edit_post"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLongTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">
                Add Your Post
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>Post Name</label>
                <input
                  type="text"
                  class="form-control"
                  placeholder=""
                  name="postName"
                  v-model="updatingData.postName"
                  required
                />
              </div>
              <div class="form-group">
                <label>Image</label>
                <input
                  type="file"
                  @change="GetImage"
                  class="form-control"
                  placeholder=""
                  name="image"
                  accept="image/*"
                />
                <div class="form-group">
                  <img
                    class="from-control m-4"
                    :src="avatar1"
                    alt="Image"
                    width="300px"
                    height="200px"
                  />
                </div>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea
                  class="form-control"
                  name="description"
                  rows="3"
                  v-model="updatingData.description"
                  required
                ></textarea>
              </div>
              <button
                type="submit"
                class="btn btn-success"
                @click.prevent="update(updatingData)"
              >
                Save Changes
              </button>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Like from "./like";
import comment from "./CommentForProfile";
import { bus } from "../app";
export default {
  props: ["user", "user2"],
  components: {
    Like,
    comment,
  },
  data() {
    return {
      posts: [],
      updatingData: {
        id: "",
        user_id: "",
        postName: "",
        description: "",
        image: "",
      },
      avatar: "storage/",
      newPath: "../",
      image: "",
      avatar1: "",
      postEdit: [],
      idPost: "",
    };
  },
  mounted() {
    this.getPosts();
  },
  methods: {
    getPosts: function () {
      axios
        .get("/ownposts/" + this.user.id)
        .then((response) => {
          this.posts = response.data.ownPost;
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    newModel(post) {
      this.updatingData = post;
      $("#Edit_post").modal("show");
      console.log(this.updatingData);
      this.idPost = this.updatingData.id;
    },
    GetImage(e) {
      this.image = e.target.files[0];

      let reader = new FileReader();
      reader.readAsDataURL(this.image);
      reader.onload = (e) => {
        this.avatar1 = e.target.result;
      };
    },
    update(updatingData) {
      if (this.image) {
        let form = new FormData();
        form.append("image", this.image);
        form.append("post_name", updatingData.postName);
        form.append("description", updatingData.description);
        this.file = form;
      } else {
        let form = new FormData();
        form.append("post_name", updatingData.postName);
        form.append("description", updatingData.description);

        this.file = form;
      }

      axios
        .post("/postUpdate/" + this.idPost, this.file)
        .then((response) => {
          $("#Edit_post").modal("hide");
          this.$swal("Post Updated!!", "Completely Edited", "success");
          this.getPosts();
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },

    removeIt(post) {
      console.log(post);
      this.$swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          axios
            .delete("/delpost/" + post.id)
            .then(() => {
              this.$swal("Deleted!", "Your file has been deleted.", "success");
              this.getPosts();
            })
            .catch(() => {
              this.$swal("Failed!", "There was something wronge.", "warning");
            });
        }
      });
    },
    updateCount(situation) {
      this.getPosts();
    },
    newComment(commentStatus) {
      this.getPosts();
    },
  },
  created() {
    bus.$on("postUpload", (data) => {
      this.getPosts();
    });
  },
};
</script>
<style  scoped>
</style>
