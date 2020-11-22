<template>
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
          <h5 class="modal-title" id="exampleModalLongTitle">Add Your Post</h5>
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
          <form id="post-form">
            <div class="form-group">
              <label for="exampleInputEmail1">Post Name</label>
              <input
                type="text"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
                placeholder=""
                name="postName"
                v-model="post.postName"
                required
              />
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Image</label>
              <input
                type="file"
                @change="GetImage"
                class="form-control"
                id="exampleInputEmail1"
                aria-describedby="emailHelp"
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
              <label for="exampleFormControlTextarea1">Description</label>
              <textarea
                class="form-control"
                name="description"
                id="exampleFormControlTextarea1"
                rows="3"
                v-model="post.description"
                required
              ></textarea>
            </div>
            <button
              type="submit"
              class="btn btn-success"
              @click.prevent="update(post)"
            >
              Save Changes
            </button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
