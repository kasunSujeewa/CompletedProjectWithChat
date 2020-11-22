<template>
  <div class="convertations">
    <h1>{{ selectedChat ? selectedChat.user.name : "Select Chat" }}</h1>
    <MessageShow
      :selectedChat="selectedChat"
      :messages="messages"
    ></MessageShow>
    <messageInput @send="sendMessage"></messageInput>
  </div>
</template>
<script>
import MessageShow from "./MessageFeed";
import messageInput from "./MessageInput";
import { bus } from "../app";
export default {
  components: {
    messageInput,
    MessageShow,
  },
  props: {
    selectedChat: {
      default: null,
    },
    messages: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      sendingMessage: {
        text: "",
        specificKey: "",
        user: "",
      },
      key: "",
    };
  },
  methods: {
    sendMessage(text) {
      this.sendingMessage.text = text;
      this.sendingMessage.specificKey = this.selectedChat.sessionKey;
      this.sendingMessage.user = this.selectedChat.user2_id;
      axios.post("/messageSend", this.sendingMessage).then((response) => {
        this.messages.push(response.data);
      });
    },
  },
  created() {},
};
</script>
<style lang="scss" scoped>
.convertations {
  flex: 5;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  max-height: 500px;

  h1 {
    margin: 0;
    border-bottom: 1px solid black;
  }
}
</style>
