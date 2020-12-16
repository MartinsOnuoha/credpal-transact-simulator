<template>
  <div class="login">
    <Card customClass="black-border pa" height="450px" width="400px">
      <template>
        <h2>Join Us</h2>
        <small style="color: #CCC">Fill the form below to join</small>
        <form @submit.prevent="registerAccount">
          <div class="form-group">
            <input v-model="form.fullname" placeholder="Enter your fullname" required type="text" class="form-control" name="fullname" autocomplete>
          </div>
          <div class="form-group">
            <input v-model="form.email" placeholder="Enter your email address" required type="email" class="form-control" name="email" autocomplete>
          </div>
          <div class="form-group">
            <input v-model="form.password" placeholder="Enter your password" required type="password" class="form-control" name="passowrd" autocomplete>
          </div>
          <div class="form-group">
            <input v-model="form.password_confirmation" placeholder="Confirm your password" required type="password" class="form-control" name="passowrd" autocomplete>
          </div>
          <div class="form-group">
            <input v-model="form.ref_code" placeholder="Referral Code (optional)" type="text" class="form-control" name="ref_code">
          </div>

          <div class="form-group action">
            <button :disabled=isSubmitting type="submit" class="btn btn--black">Continue</button>
            <router-link class="link" :to="{ name: 'login-page' }"><small>Already have an account?</small></router-link>
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
  data() {
    return {
      form: {
        fullname: '',
        email: '',
        password: '',
        password_confirmation: '',
        ref_code: ''
      },
      isSubmitting: false,
    }
  },
  name: 'login-page',
  methods: {
    registerAccount() {
      const { email, fullname, password, password_confirmation } = this.form;

      if (email && fullname && password && password_confirmation) {
        this.isSubmitting = true;
        this.$store.dispatch('registerUser', this.form)
          .then((res) => {
            if (res.data) {
              Notify.Success('Registration Successful')
              this.$router.push({ name: 'dashboard-page' })
            } else {
              Notify.Failure('Registration failed: Account may already exist')
            }
          })
          .catch((e) => {
            throw e
          })
          .finally(() => {
            this.isSubmitting = false
          })

      }
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
