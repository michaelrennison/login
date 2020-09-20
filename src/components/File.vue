<template>
  <div>
    <a :href="file.source" target="_blank">{{ file.name }}</a>
  </div>
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