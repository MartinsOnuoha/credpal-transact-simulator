<template>
  <div class="login">
    <Card customClass="black-border pa" height="300px" width="400px">
      <template>
        <h2>Welcome Back</h2>
        <small style="color: #CCC">Enter your registered details</small>
        <form @submit.prevent="login">
          <div class="form-group">
            <input required v-model="form.email" placeholder="Enter your email address" type="text" class="form-control" name="email" autocomplete>
          </div>
          <div class="form-group">
            <input required v-model="form.password" placeholder="Enter your password" type="password" class="form-control" name="password" autocomplete>
          </div>

          <div class="form-group action">
            <button type="submit" class="btn btn--black">Login</button>
            <router-link class="link" :to="{ name: 'register-page' }"><small>Don't have an account?</small></router-link>
          </div>
        </form>
      </template>
    </Card>
  </div>
</template>

<script>
import Card from '../Components/Card.vue'
import { Notify } from "notiflix";

export default {
  components: { Card },
  name: 'login-page',
  data() {
    return {
      form: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    login() {
      this.$store.dispatch('loginUser', this.form)
        .then((res) => {
          console.log(res)
          if (res.error) {
            Notify.Failure(res.msg)
            return false
          }
          Notify.Success('Logged in Successfully')
          this.$router.push({ name: 'dashboard-page' })
        })
    }
  }
}
</script>

<style lang="scss">
  .login {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    .card {
      margin-top: 4rem;
      padding: 60px;
    }
  }
  .link {
    color: #171717ac;
    margin-top: 10px;
  }
</style>
