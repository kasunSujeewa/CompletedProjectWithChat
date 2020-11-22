<template>
  <div>
    <div
      class="d-flex justify-content-start bg-dark text-white rounded-pill p-3 shadow"
    >
      <img
        class="m-2"
        :src="newPath + user.avatar"
        alt=""
        width="30px"
        height="30px"
        style="border-radius: 50%"
      />
      <h5 class="p-1 align-self-center" style="margin-right: 300px">
        {{ user.name }}
      </h5>
      <button
        class="btn btn-sm text-white"
        data-toggle="modal"
        data-target="#add_post"
      >
        <i class="fa fa-share-alt-square" aria-hidden="true"></i> Share Your Own
        Post
      </button>
      <hr />
    </div>
    <!-- Model For Post -->
    <div
      class="modal fade"
      id="add_post"
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
              <label for="exampleInputEmail1">Post Name</label>
              <input
                type="text"
                class="form-control"
                placeholder=""
                name="postName"
                v-model="newPost.name"
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
                  :src="avatar"
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
                v-model="newPost.description"
                required
              ></textarea>
            </div>
            <button
              type="submit"
              class="btn btn-primary"
              @click.prevent="upload"
            >
              Post
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
</template>
<script>
import { bus } from "../app";
export default {
  watch: {},
  created() {},
  props: ["user"],
  data() {
    return {
      avatar: "",
      newPost: [],
      file: [],
      image: "",
      newPath: "../",
      // NewUploadPost: [],
    };
  },
  methods: {
    GetImage(e) {
      this.image = e.target.files[0];

      let reader = new FileReader();
      reader.readAsDataURL(this.image);
      reader.onload = (e) => {
        this.avatar = e.target.result;
      };
    },
    upload(e) {
      if (this.image) {
        let form = new FormData();
        form.append("image", this.image);
        form.append("post_name", this.newPost.name);
        form.append("description", this.newPost.description);
        this.file = form;
      } else {
        let form = new FormData();
        form.append("post_name", this.newPost.name);
        form.append("description", this.newPost.description);
        form.append("image", null);
        this.file = form;
      }

      axios
        .post("/postUpload", this.file)
        .then((response) => {
          $("#add_post").modal("hide");
          // this.NewUploadPost = response.data.Newpost;
          //this.$emit("newUpload", this.NewUploadPost);
          this.$swal(
            "posted!",
            "Your Post Has been Successfully Posted.",
            "success"
          );
          bus.$emit("postUpload", "uploaded");
          $("#add_post").val(null).trigger("change");
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
  },
};
</script>
