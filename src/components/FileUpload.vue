<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-10 card">
        <div class="my-3">
          <div class="form-group row">
            <label for="fileName" class="col-sm-4 col-form-label">Filename</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="fileName" v-model="fileName" placeholder="Filename">
            </div>
          </div>
          <div class="form-group text-left row px-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="uploadButtonAddon">Upload</span>
              </div>
              <div class="custom-file">
                <input type="file" @change="previewFile" :v-model="file" class="custom-file-input" id="uploadButton"
                       aria-describedby="uploadButtonAddon">
                <label class="custom-file-label" for="uploadButton">{{ file.name ? file.name : 'Chose File...' }}</label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm">
              <button v-on:click="upload" class="btn btn-block btn-primary">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "FileUpload",
  props: [
      "user"
  ],
  data: function () {
    return {
      fileName: '',
      file: ''
    }
  },
  methods: {
    upload() {
      // create the form data as a new formData object
      let formData = new FormData();
      formData.append("name", this.fileName);
      formData.append("file", this.file);
      formData.append("token", this.user.token)

      const url = `${this.$root.config.serverUrl}/upload.php`;

      // create a post request to the server script for handling an upload
      axios.post(url, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        },
        withCredentials: true
      }).then(resp => {
        // tell the parent to update it's file list
        this.$emit('updateFiles', resp.data);
        // clear the data in the form
        this.clearForm();
      }).catch(err => {
        this.$root.error = err;
        this.clearForm();
      })
    },
    previewFile(event) {
      // get the file details so the name can be displayed before the upload
      this.file = event.target.files[0];
    },

    clearForm() {
      // clear the file details
      this.file = '';
      this.fileName = '';
    }
  }
}
</script>

<style scoped>

</style>