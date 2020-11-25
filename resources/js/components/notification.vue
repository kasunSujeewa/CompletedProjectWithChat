<template>
  <div class="notification dropdown">
    <button
      class="btn btn-secondary dropdown-toggle"
      type="button"
      id="dropdownMenuButton"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      Notifications <i class="fa fa-bell" aria-hidden="true"></i
      ><span class="badge badge-danger"
        >{{ ownerNot.unread_notifications.length }}
      </span>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a href="" @click="MarkAsRead" class="dropdown-item">markAsread All</a>
      <a
        v-for="notification in ownerNot.unread_notifications"
        :key="notification.id"
        class="dropdown-item"
        href="#"
        style="background-color: skyblue; border-bottom: 1px solid black"
        >{{ notification.data.body }}</a
      >
    </div>
  </div>
</template>
<script>
export default {
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      ownerNot: [],
    };
  },
  methods: {
    getNotifications: function () {
      axios.get("/Usersnotifications/" + this.user.id).then((response) => {
        this.ownerNot = response.data;
      });
    },
    MarkAsRead() {
      axios
        .delete("/markAsreadNotifications/" + this.user.id)
        .then((response) => {
          this.getNotifications();
        });
    },
  },

  mounted() {
    this.getNotifications();
    Echo.private(`CommentAdd.${this.user.id}`).listen(
      "NotificationDemo",
      (e) => {
        this.getNotifications();
      }
    );
    Echo.private(`friend-Request.${this.user.id}`).listen(
      "friendRequest",
      (e) => {
        this.getNotifications();
      }
    );
    Echo.private(`React-post.${this.user.id}`).listen(
      "ReactHandleNotification",
      (e) => {
        this.getNotifications();
      }
    );
  },
};
</script>
<style lang="scss" scoped>
</style>

