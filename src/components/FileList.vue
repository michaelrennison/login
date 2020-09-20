<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-6" v-for="file in files" v-bind:key="file.id">
        <file :file="file" />
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
    this.getFiles()
  },

  methods: {
    getFiles() {

      const url = `${this.$root.config.serverUrl}/get_files.php`;

      const postData = {
        token: this.user.token
      }

      axios({
        method: 'post',
        url: url,
        data: postData
      }, {withCredentials: true}).then((resp) => {
        this.files = resp.data.files
      }).catch(err => {
        console.log(err)
      });
    },

    updateFiles(file) {
      this.files.push(file);
    }
  }
}
</script>

<style scoped>

</style>