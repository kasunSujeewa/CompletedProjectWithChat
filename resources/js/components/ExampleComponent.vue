<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">
            <ul v-for="user in users" :key="user.id">
              <li>{{ user.name }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.loadUsers();
  },
  methods: {
    loadUsers: function () {
      axios
        .get("/usersdata")
        .then((response) => {
          this.users = response.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>
