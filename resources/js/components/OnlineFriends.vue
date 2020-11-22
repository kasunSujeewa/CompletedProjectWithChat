<template>
  <div class="online-friends d-flex-column">
    <h2 class="d-inline-flex pb-2" style="border-bottom: 1px solid black">
      Online Users
    </h2>

    <div class="p-2" v-for="userOn in onlineUsers" :key="userOn.id">
      <div class="name" @click="createChatList(userOn)">
        <small><i class="fa fa-circle m-1" aria-hidden="true"></i></small>
        {{ userOn.name.charAt(0).toUpperCase() + userOn.name.slice(1) }}
      </div>
    </div>
  </div>
</template>
<script>
import { bus } from "../app";
export default {
  data() {
    return {
      onlineUsers: [],
      chatUser: [],
    };
  },
  mounted() {
    this.getOnlineUsers();
  },
  methods: {
    getOnlineUsers: function () {
      axios
        .get("/onlineUsers")
        .then((response) => {
          this.onlineUsers = response.data.onlineFR;
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
    createChatList(userOn) {
      this.chatUser = userOn;

      axios
        .post("/makeChat", this.chatUser)
        .then((response) => {
          this.$emit("createChats");
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },
  },
};
</script>
<style lang="scss" scoped>
i {
  color: lime;
}
.name {
  cursor: pointer;
}
</style>
