<template>
  <div>
    <div class="col-2">
      <div class="accordion" id="accordionExample" style="position: fixed">
        <div class="card">
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button
                class="btn btn-link"
                type="button"
                data-toggle="collapse"
                data-target="#collapseOne"
                aria-expanded="true"
                aria-controls="collapseOne"
              >
                Find Friend
              </button>
            </h2>
          </div>

          <div
            id="collapseOne"
            class="collapse"
            aria-labelledby="headingOne"
            data-parent="#accordionExample"
          >
            <div
              class="card-body"
              v-for="addfriend in Addfriends"
              :key="addfriend.id"
            >
              <div v-if="!friendID.includes(addfriend.id)">
                <div
                  class="d-flex justify-content-between"
                  v-if="requestedID.includes(addfriend.id)"
                >
                  <div class="mr-1">
                    <img
                      class="m-2"
                      :src="addfriend.avatar"
                      alt=""
                      width="30px"
                      height="30px"
                      style="border-radius: 50%"
                    />
                  </div>
                  <div class="mr-1 align-self-center">
                    <h5>{{ addfriend.name }}</h5>
                  </div>
                  <div class="mr-1 align-self-center">
                    <a
                      class="addrequest"
                      style="text-decoration: none"
                      @click="delreq(addfriend)"
                      >cancel request</a
                    >
                  </div>
                </div>

                <div
                  class="d-flex justify-content-between"
                  v-else-if="!requestResID.includes(addfriend.id)"
                >
                  <div class="mr-1">
                    <img
                      class="m-2"
                      :src="addfriend.avatar"
                      alt=""
                      width="30px"
                      height="30px"
                      style="border-radius: 50%"
                    />
                  </div>
                  <div class="mr-1 align-self-center">
                    <h5>{{ addfriend.name }}</h5>
                  </div>
                  <div class="mr-1 align-self-center">
                    <a
                      class="addrequest"
                      style="text-decoration: none"
                      @click="sendreq(addfriend)"
                      >Add Friend</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button
                class="btn btn-link"
                type="button"
                data-toggle="collapse"
                data-target="#collapseTwo"
                aria-expanded="true"
                aria-controls="collapseOne"
              >
                Friend Requests
              </button>
              <small
                ><span class="badge badge-danger">{{
                  friendrq.length
                }}</span></small
              >
            </h2>
          </div>

          <div
            id="collapseTwo"
            class="collapse"
            aria-labelledby="headingOne"
            data-parent="#accordionExample"
          >
            <div
              class="card-body"
              v-for="friendRQ in friendrq"
              :key="friendRQ.id"
            >
              <div class="d-flex justify-content-between">
                <div class="mr-1">
                  <img
                    class="m-2"
                    :src="friendRQ.user.avatar"
                    alt=""
                    width="30px"
                    height="30px"
                    style="border-radius: 50%"
                  />
                </div>
                <div class="mr-1 align-self-center">
                  <h5>{{ friendRQ.user.name }}</h5>
                </div>
                <div class="mr-1 align-self-center">
                  <a
                    class="addrequest"
                    style="text-decoration: none"
                    @click="confirmFriend(friendRQ)"
                    >confirm</a
                  >
                  <a
                    class="addrequest"
                    style="text-decoration: none"
                    @click="removeRQ(friendRQ)"
                    >remove</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button
                class="btn btn-link"
                type="button"
                data-toggle="collapse"
                data-target="#collapseThree"
                aria-expanded="true"
                aria-controls="collapseOne"
              >
                Friends
              </button>
            </h2>
          </div>

          <div
            id="collapseThree"
            class="collapse"
            aria-labelledby="headingOne"
            data-parent="#accordionExample"
          >
            <div
              class="card-body"
              v-for="friendS in friendsUser"
              :key="friendS.user.id"
            >
              <div class="d-flex justify-content-between">
                <div class="mr-1">
                  <img
                    class="m-2"
                    :src="friendS.user.avatar"
                    alt=""
                    width="30px"
                    height="30px"
                    style="border-radius: 50%"
                  />
                </div>
                <div class="mr-1 align-self-center">
                  <h5>{{ friendS.user.name }}</h5>
                </div>
                <div class="mr-1 align-self-center">
                  <a
                    class="addrequest"
                    style="text-decoration: none"
                    @click="removeFR(friendS)"
                    >remove</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { bus } from "../app";
export default {
  props: ["user3"],
  data() {
    return {
      Addfriends: [],
      sendrrq: {
        friend_id: "",
      },
      confirmDetails: {
        friend_id: "",
      },
      delID: "",
      requestedID: [],
      requestResID: [],
      friendrq: [],
      friendsUser: [],
      friendID: [],
      delFriend: {
        friend_id: "",
      },
    };
  },
  mounted() {
    this.getFriends();
  },
  methods: {
    getFriends: function () {
      axios.get("/friends").then((response) => {
        this.Addfriends = response.data.users;
        this.requestedID = response.data.requestedID;
        this.requestResID = response.data.requestResID;
        this.friendID = response.data.friendsID;

        this.friendsUser = response.data.friends;

        this.friendrq = response.data.friendRequestReceive;
      });
    },
    sendreq(addfriend) {
      this.sendrrq.friend_id = addfriend.id;
      axios
        .post("/sendFriendRequest", this.sendrrq)
        .then((response) => {
          this.getFriends();
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    delreq(addfriend) {
      this.delID = addfriend.id;
      axios
        .delete("/delFriendRqsend/" + this.delID)
        .then((response) => {
          this.getFriends();
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    confirmFriend(friendRQ) {
      this.confirmDetails.friend_id = friendRQ.user_id;
      axios
        .post("/addfriend", this.confirmDetails)
        .then((response) => {
          this.getFriends();
          bus.$emit("postUpload", "uploaded");
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    removeRQ(friendRQ) {
      axios
        .delete("/delFriendRq/" + friendRQ.id)
        .then((response) => {
          this.getFriends();
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    removeFR(friendS) {
      this.delFriend.friend_id = friendS.user_id;
      console.log(this.delFriend);
      axios.post("/delFriend", this.delFriend).then((response) => {
        this.getFriends();
        bus.$emit("postUpload", "uploaded");
      });
    },
  },
  created() {
    Echo.channel("chat").listen("DemoEvent", (e) => {
      this.getFriends();
      bus.$emit("postUpload", "uploaded");
    });
    Echo.private(`friend-Request.${this.user3.id}`).listen(
      "friendRequest",
      (e) => {
        this.getFriends();
        bus.$emit("postUpload", "uploaded");
      }
    );
  },
};
</script>
<style lang="scss" scoped>
a {
  cursor: pointer;
}
</style>
