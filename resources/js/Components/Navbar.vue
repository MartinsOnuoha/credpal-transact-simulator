<template>
  <nav class="navBar shadow-1">
    <div class="navBar__logo">
    </div>
    <ul v-if="!user" class="navBar__link">
      <li><router-link :to="{ name: 'login-page' }">Login</router-link></li>
      <li><router-link :to="{ name: 'register-page' }">Register</router-link> </li>
    </ul>
    <ul v-else class="navBar__link cursor">
      <li @click="logOut">Logout</li>
    </ul>
  </nav>
</template>

<script>
import { mapState } from 'vuex';
import '../Sass/navbar.scss';

export default {
  name: 'nav-bar',
  computed: {
    ...mapState({
      user: state =>  state.user,
    })
  },
  methods: {
    logOut() {
      this.$store.commit('CLEAR_AUTH')
      this.$router.replace({ name: 'index' });
    }
  }
}
</script>
