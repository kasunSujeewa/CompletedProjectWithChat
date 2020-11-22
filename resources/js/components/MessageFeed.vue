<template>
  <div class="feed" ref="feed">
    <ul v-if="selectedChat">
      <li
        v-for="message in messages"
        :key="message.id"
        :class="`message${
          message.to == selectedChat.user_id ? ' sent' : ' received'
        }`"
      >
        <div class="text">{{ message.bodyText }}</div>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  props: {
    selectedChat: {
      default: null,
    },
    messages: {
      type: Array,
      default: [],
    },
  },

  methods: {
    scrollToBottom() {
      setTimeout(() => {
        this.$refs.feed.scrollTop =
          this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
      }, 50);
    },
  },
  watch: {
    contact(selectedChat) {
      this.scrollToBottom();
    },
    messages(messages) {
      this.scrollToBottom();
    },
  },
};
</script>
<style lang="scss" scoped>
.feed {
  background: #f0f0f0;
  height: 100%;
  max-height: 470px;
  overflow: scroll;

  ul {
    list-style-type: none;
    padding: 5px;

    li {
      &.message {
        margin: 10px 0;
        width: 100%;

        .text {
          max-width: 200px;
          border-radius: 5px;
          padding: 12px;
          display: inline-block;
        }

        &.received {
          text-align: right;

          .text {
            background: #b2b2b2;
          }
        }

        &.sent {
          text-align: left;

          .text {
            background: #81c4f9;
          }
        }
      }
    }
  }
}
</style>
