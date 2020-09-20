<template>
  <div v-if="user">
    <button class="btn btn-danger" v-on:click="logout">Logout</button>
    <h1>Hi {{ user.fname }} {{ user.lname }}!</h1>

    <file-upload @updateFiles="updateFiles" :user="user"/>

    <file-list ref="list" :user="user"/>
  </div>
</template>

<script>
import axios from "axios";
import FileUpload from "@/components/FileUpload";
import FileList from "@/components/FileList";

export default {
  name: "Welcome",
  components: {FileList, FileUpload},
  data: function () {
    return {
      user: false
    }
  },
  mounted() {
    // get the user from the route props
    this.user = this.$route.params.user
  },

  methods: {
    logout() {
      const url = `${this.$root.config.serverUrl}/logout.php`;

      // define the users token as the post data
      const postData = {
        token: this.user.token
      }

      // make a post request to the server using the post data
      axios({
        method: 'post',
        url: url,
        data: postData
      }, {withCredentials: true}).then(() => {
          // remove the user from the local storage
          localStorage.removeItem('user');
          // navigate back to the login screen
          this.$router.push('./login')
      }).catch((err) => {
        this.$root.error = err;
      });
    },
    updateFiles(file) {
      this.$refs.list.updateFiles(file)
    }
  }
}
</script>

<style scoped>

</style>