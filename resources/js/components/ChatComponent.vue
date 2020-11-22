<template>
  <div class="chat-app">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-4">
          <convertations
            :user="user"
            @selected="startConvertation"
            :convertations="convertations"
          ></convertations>
        </div>
        <div class="col-4">
          <messageComponent
            :messages="messages"
            :selectedChat="selectedChat"
          ></messageComponent>
        </div>
        <div class="col-2">
          <onlineFriends @createChats="newChatAdd"></onlineFriends>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import onlineFriends from "./OnlineFriends";
import convertations from "./ChatConvertations";
import messageComponent from "./messageComponent";
import { bus } from "../app";
export default {
  components: {
    onlineFriends,
    convertations,
    messageComponent,
  },
  props: {
    user: {
      required: true,
    },
  },
  data() {
    return {
      messages: [],
      convertations: [],
      selectedChat: null,
    };
  },
  mounted() {
    this.getChats();
    Echo.private(`messages.${this.user.id}`).listen("Chatting", (e) => {
      this.hanleIncoming(e.message);
    });
  },
  methods: {
    startConvertation(chat) {
      this.selectedChat = chat;
      axios.get("/messages/" + chat.sessionKey).then((response) => {
        this.messages = response.data;
      });
    },
    getChats: function () {
      axios.get("/getChats/" + this.user.id).then((response) => {
        this.convertations = response.data.convertations;
      });
    },
    newChatAdd() {
      this.getChats();
    },
    hanleIncoming(message) {
      if (this.selectedChat && message.from == this.selectedChat.user2_id) {
        this.messages.push(message);
        return;
      }
    },
  },
  created() {},
};
</script>
