<template>
  <div id="app-container">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  mounted() {
    console.log('Arsip Digital USBR - Aplikasi dimulai')
  }
}
</script>

<style scoped>
#app-container {
  min-height: 100vh;
}
</style>