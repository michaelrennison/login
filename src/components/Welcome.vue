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
    this.user = this.$route.params.user
  },

  methods: {
    logout() {
      const url = `${this.$root.config.serverUrl}/logout.php`;

      const postData = {
        token: this.user.token
      }

      axios({
        method: 'post',
        url: url,
        data: postData
      }, {withCredentials: true}).then(() => {
          localStorage.removeItem('user');
          this.$router.push('./login')
      }).catch(() => {

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