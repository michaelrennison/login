<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-10 card">
        <div class="my-3">
          <div v-if="error" class="alert alert-danger" role="alert">
            {{ error.message }}
          </div>

          <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="email" v-model="email" placeholder="example@mail.com">
            </div>
          </div>
          <div class="form-group row">
            <label for="password" class="col-sm-4 col-form-label">Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="password" v-model="password" placeholder="Password">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm">
              <button :disabled="(email === '' || password ==='')" v-on:click="login" class="btn btn-block btn-primary">Login</button>
            </div>
          </div>
          <router-link to="/register">Register</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Login",
  data: function () {
    return {
      email: '',
      password: '',
      error: false
    }
  },
  methods: {
    login() {
      const url = `${this.$root.config.serverUrl}/login.php`;

      // define the post data for logging in a user with the inputted email and password
      const postData = {
        email: this.email,
        password: this.password
      }

      // make a post request to the login script using the postdata
      axios({
        method: 'post',
        url: url,
        data: postData
      }, {withCredentials: true})
      .then((resp) => {
        // check if the user was successfully logged in
        if(resp.data.error === true) {
          // display the error message
          this.error = resp.data
        } else {
          this.error = false;
          // store the response in local storage
          localStorage.user = JSON.stringify(resp.data);
          // navigate to the welcome screen and send the user data as a prop
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

<style scoped>

</style>