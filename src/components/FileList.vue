<template>
  <div class="container-fluid mt-3" v-if="files.length > 0">
    <div class="row justify-content-center">
      <div class="col-10 card">
        <table class="table table-striped mt-3">
          <tbody>
          <file v-for="file in files" v-bind:key="file.id" :file="file" />
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import File from "@/components/File";
import axios from "axios";

export default {
  name: "FileList",
  components: {File},
  props: [
      "user"
  ],
  data: function () {
    return {
      files: []
    }
  },

  mounted() {
    // get the files belonging to this user
    this.getFiles()
  },

  methods: {
    getFiles() {

      const url = `${this.$root.config.serverUrl}/get_files.php`;

      // create postData to send the server the users token
      const postData = {
        token: this.user.token
      }

      // create a post request to the server
      axios({
        method: 'post',
        url: url,
        data: postData
      }, {withCredentials: true}).then((resp) => {
        // save the returned files to the file list
        this.files = resp.data.files
      }).catch(err => {
        this.$root.error = err;
      });
    },

    updateFiles(file) {
      // Check if the file array is defined, if not create it as a new array with the file in it
      if(typeof this.files === 'undefined') {
        this.files = [file];
      } else {
        this.files.push(file);
      }
    }
  }
}
</script>

<style scoped>

</style>