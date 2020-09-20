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
      this.emailsMatch = this.email === this.confirmEmail;
    },

    validatePasswords() {
      this.passwordsMatch = this.password === this.confirmPassword;
    },

    register() {

      const postData = {
        fname: this.fname,
        lname: this.lname,
        email: this.email,
        password: this.password
      }

      const url = `${this.$root.config.serverUrl}/register.php`;

      axios({
        method: 'post',
        url: url,
        data: postData
      })
      .then((resp) => {
        if(resp.data.error === true) {
          this.error = resp.data;
        } else {
          // Navigate to the login page
          localStorage.user = JSON.stringify(resp.data);
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