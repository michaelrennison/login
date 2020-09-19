<template>
  <div v-if="isLoggedIn">
    <h1>You are logged in!</h1>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "Welcome",
  props: [
      "user"
  ],
  data: function () {
    return {
      isLoggedIn: false
    }
  },
  mounted() {
    this.checkLogin();
    // Check if the user is logged in
  },

  methods: {

    checkLogin() {
      const url = `${this.$root.config.serverUrl}/auth.php`;

      axios.get(url, {withCredentials: true}).then((resp) => {
        console.log(resp);
        // If auth returns false then the user is not logged in
        if(resp.data === false) {
          // navigate to the login page
          this.$router.push('./login');
        }
      }).catch(err => {
        console.log(err);
      })
    }
  }
}
</script>

<style scoped>

</style>