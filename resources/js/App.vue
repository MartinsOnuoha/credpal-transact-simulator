<template>
  <div class="app">
    <Navbar></Navbar>
    <router-view></router-view>
  </div>
</template>
<script>

export default {
  components: {
    Navbar: () => import('./Components/Navbar.vue')
  },
  data() {
    return {
      message: "Hello World",
    };
  },
};
</script>

<style lang="scss">
@import url('./Sass/app.scss');
</style>
