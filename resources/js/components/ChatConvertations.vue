<template>
  <div class="d-flex flex-column">
    <h1 class="d-inline-flex" style="border-bottom: 1px solid black">Chats</h1>
    <div
      class="convertation"
      v-for="(chat, index) in convertations"
      :key="chat.id"
      @click="selectContact(index, chat)"
      :class="{ selected: index == selected }"
    >
      <div class="d-flex flex-row">
        <img
          :src="chat.user.avatar"
          class="mr-3 rounded-circle"
          alt=""
          width="40px"
          height="40px"
        />
        <div class="Chatername align-self-center">{{ chat.user.name }}</div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    user: {},
    convertations: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      selected: 0,
    };
  },
  mounted() {},
  methods: {
    selectContact(index, chat) {
      this.selected = index;
      this.$emit("selected", chat);
    },
  },
};
</script>
<style lang="scss" scoped>
.convertation {
  display: flex;
  border-bottom: 1px solid rgb(80, 77, 77);
  height: 50px;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  padding: 2px;
  &.selected {
    background: #dfdfdf;
  }
}
</style>
