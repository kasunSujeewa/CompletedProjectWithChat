<template>
  <div class="messageInput">
    <input
      type="text"
      name="message"
      v-model="message"
      id=""
      cols="8"
      rows="1"
      @keydown.enter="send"
      placeholder="Type Here.."
    />
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: "",
    };
  },
  methods: {
    send() {
      if (this.message == "") {
        return;
      }
      this.$emit("send", this.message);
      this.message = "";
    },
  },
};
</script>
<style lang="scss" scoped>
.messageInput input {
  width: 96%;
  margin: 10px;
  resize: none;
  border-radius: 3px;
  border: 1px solid lightgray;
  padding: 6px;
}
</style>



