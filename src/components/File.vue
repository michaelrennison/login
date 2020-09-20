<template>
  <tr>
    <td>{{ file.name }}</td>
    <td>
      <a class="btn btn-primary" :href="`${this.$root.config.serverUrl}/${file.source}`" target="_blank">view</a>
    </td>
  </tr>
</template>

<script>
export default {
  name: "File",
  props: [
      "file"
  ]
}
</script>

<style scoped>

</style>