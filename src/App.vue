<template>
  <div id="app">
    <div v-if="$root.error" class="alert alert-danger mt-3" role="alert">
      {{ error.message }}
    </div>
    <div v-else class="container">
      <div class="row justify-content-center">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>

import axios from "axios";

export default {
  name: 'App',
  mounted() {
    // Check if the user is logged in
    if(localStorage.user) {
      this.user = JSON.parse(localStorage.user);
      this.checkLogin();
    } else {
      this.$router.push('./login')
    }
  },

  data: function () {
    return {
      user: ''
    }
  },

  methods: {
    checkLogin() {
      const url = `${this.$root.config.serverUrl}/auth.php`;

      const postData = {
        token: this.user.token
      }
      axios({
        method: 'post',
        url: url,
        data: postData
      }, {withCredentials: true})
      .then((resp) => {
        console.log(resp);
        // If auth returns false then the user is not logged in
        if(resp.data === false) {
          // navigate to the login page
          this.$router.push('./login');
        } else {
          this.$router.push({
            name: 'welcome',
            params: {
              user: resp.data
            }
          })
        }
      }).catch(err => {
        this.$root.error = err;
      })
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
