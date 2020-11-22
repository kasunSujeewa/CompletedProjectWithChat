<template>
  <div>
    <div class="container ml-2" style="">
      <h1 style="font-family: 'Tenali Ramakrishna', sans-serif">
        <img
          :src="newPath + user.avatar"
          width="70px"
          height="70px"
          alt="kasun"
          style="border-radius: 50%"
        />
        {{ user.name }}
      </h1>

      <ul
        class="list-group"
        style="max-width: 250px; font-family: 'Electrolize', sans-serif"
        v-if="owner"
      >
        <li>
          <span class="font-weight-bold">High School :</span>{{ owner.school }}
        </li>
        <li><span class="font-weight-bold">Birthday :</span>{{ owner.dob }}</li>
        <li>
          <span class="font-weight-bold">Faculty :</span>{{ owner.faculty }}
        </li>
        <li>
          <span class="font-weight-bold">Department :</span
          >{{ owner.department }}
        </li>
        <li><span class="font-weight-bold">About :</span>{{ owner.about }}</li>
      </ul>

      <ul
        class="list-group"
        style="max-width: 250px; font-family: 'Electrolize', sans-serif"
        v-else
      >
        <li><span class="font-weight-bold">High School :</span></li>
        <li><span class="font-weight-bold">Birthday :</span></li>
        <li><span class="font-weight-bold">Faculty :</span></li>
        <li><span class="font-weight-bold">Department :</span></li>
        <li><span class="font-weight-bold">About :</span></li>
      </ul>
      <button
        data-toggle="modal"
        data-target="#Update_details"
        class="btn btn-link"
        v-if="user.id == user2.id"
      >
        Update Your Details
      </button>

      <!-- Profile Update Model -->
      <div
        class="modal fade"
        id="Update_details"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLongTitle"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">
                Update Your Profile
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
              <form id="Update-detail-form" @submit.prevent="submitdetail()">
                <input type="hidden" v-model="owner.user_id" />
                <div class="form-group">
                  <label for="exampleInputEmail1">High School</label>
                  <input
                    type="text"
                    class="form-control"
                    id="school"
                    aria-describedby="emailHelp"
                    placeholder=""
                    name="school"
                    v-model="owner.school"
                  />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Date of birth</label>
                  <input
                    type="date"
                    class="form-control"
                    id="dob"
                    aria-describedby="emailHelp"
                    placeholder=""
                    name="dob"
                    v-model="owner.dob"
                  />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Faculty</label>
                  <select name="faculty" id="faculty" v-model="owner.faculty">
                    <option value="Applied">Applied</option>
                    <option value="Management">Management</option>
                    <option value="Geo">Geo</option>
                    <option value="Social">Social</option>
                    <option value="Agriculture">Agriculture</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Department</label>
                  <input
                    type="text"
                    class="form-control"
                    id="department"
                    aria-describedby="emailHelp"
                    placeholder=""
                    name="department"
                    v-model="owner.department"
                  />
                </div>

                <div class="form-group">
                  <label for="exampleFormControlTextarea1">About</label>
                  <textarea
                    class="form-control"
                    name="about"
                    id="about"
                    rows="3"
                    v-model="owner.about"
                  ></textarea>
                </div>
                <button type="submit" value="Bieden!" class="btn btn-primary">
                  Save Updates
                </button>
              </form>
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
export default {
  props: ["user", "user2"],

  data() {
    return {
      owner: [],
      newPath: "../",
      user1: [],
    };
  },
  mounted() {
    this.getDetails();
  },
  methods: {
    getDetails: function () {
      axios
        .get("/profileData/" + this.user.slug)
        .then((response) => {
          this.owner = response.data.profile;
          this.user1 = response.data.user;

          //console.log(response.data.profile);
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    submitdetail() {
      var id = this.owner.user_id;
      var faculty = this.owner.faculty;
      var school = this.owner.school;

      var about = this.owner.about;

      var department = this.owner.department;
      var dob = this.owner.dob;
      axios
        .post("/profileUp/" + this.owner.user_id, {
          id: id,
          faculty: faculty,
          school: school,
          about: about,
          department: department,
          dob: dob,
        })
        .then((response) => {
          $("#Update_details").modal("hide");
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
  },
};
</script>
