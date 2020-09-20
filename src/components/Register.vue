<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-10 card">
        <div v-if="error" class="alert alert-danger mt-3" role="alert">
          {{ error.message }}
        </div>
        <div class="my-3">
          <div class="form-group row">
            <label for="fname" class="col-sm-4 col-form-label">First Name</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="fname" v-model="fname" placeholder="Firstname">
            </div>
          </div>
          <div class="form-group row">
            <label for="lname" class="col-sm-4 col-form-label">Last Name</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="lname" v-model="lname" placeholder="Lastname">
            </div>
          </div>

          <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="email" v-model="email" placeholder="email@example.com">
            </div>
          </div>
          <div class="form-group row">
            <label for="confirmEmail" class="col-sm-4 col-form-label">Confirm Email</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="confirmEmail" v-model="confirmEmail" v-on:keyup="validateEmails" placeholder="email@example.com">
            </div>
          </div>
          <div class="form-group row">
            <label for="password" class="col-sm-4 col-form-label">Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control"  id="password" v-model="password" placeholder="Password">
            </div>
          </div>
          <div class="form-group row">
            <label for="confirmPassword" class="col-sm-4 col-form-label">Confirm Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control"  id="confirmPassword" v-model="confirmPassword" v-on:keyup="validatePasswords" placeholder="Password">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm">
              <button v-on:click="register" class="btn btn-block btn-primary" :disabled="!emailsMatch || !passwordsMatch">Register</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from 'axios';

export default {
  name: "Register",
  data: function () {
    return {
      fname: '',
      lname: '',
      email: '',
      confirmEmail: '',
      password: '',
      confirmPassword: '',
      emailsMatch: false,
      passwordsMatch: false,
      error: false
    }
  },
  methods: {
    validateEmails() {
      // check if the email field is equal to the confirm email field
      this.emailsMatch = this.email === this.confirmEmail;
    },

    validatePasswords() {
      // check if the password field is equal to the confirm password field
      this.passwordsMatch = this.password === this.confirmPassword;
    },

    register() {

      // define the post data as the inputted email, password firstname and lastname
      const postData = {
        fname: this.fname,
        lname: this.lname,
        email: this.email,
        password: this.password
      }

      const url = `${this.$root.config.serverUrl}/register.php`;

      // make a post request to the register script on the server
      axios({
        method: 'post',
        url: url,
        data: postData
      })
      .then((resp) => {
        // check if the user was succesfully able to register
        if(resp.data.error === true) {
          // display the error message to the user
          this.error = resp.data;
        } else {
          // Save the user data to the local storage
          localStorage.user = JSON.stringify(resp.data);
          // Navigate to the login page and send the user data as a prop
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