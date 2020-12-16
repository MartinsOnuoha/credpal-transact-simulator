<template>
  <div class="dashboard row">
    <div class="fullwidth">
      <div class="row">
        <h2 class="text text-light">Welcome, {{ user.fullname }}</h2>
      </div>

      <div class="content row">
        <div class="column">
          <div class="row actions between">
            <button class="btn btn--success fullwidth">Deposit</button>
            <button @click="isTransferring = true" class="btn fullwidth btn--black">Transfer</button>
          </div>

          <Card height="250px" style="margin-bottom: 5px" class="row" v-if="isTransferring">
            <div class="column fullwidth">
              <span class="text">Transfer Money</span>
              <form @submit.prevent="transferMoney" class="fullwidth">
                <div class="form-group">
                  <input v-model="transfer.recipient" placeholder="Receipient Account" required type="text" class="form-control" autocomplete>
                </div>
                <div class="form-group">
                  <input v-model="transfer.amount" placeholder="Amount" required type="text" class="form-control" autocomplete>
                  <small v-if="exceedsAmount" style="color: red">Your transfer limit is {{ wallet.max_transfer }}</small>
                </div>
                <div class="form-group">
                  <small class="text">Want to Schedule Transfer?</small>
                  <input v-model="transfer.date" placeholder="schedule transfer" type="date">
                </div>
                <div class="form-group">
                  <button class="btn btn--black" type="submit">Send</button>
                </div>
              </form>
            </div>
          </Card>

          <Card class="row">
            <div class="side-image"></div>
            <div class="column money" v-if="wallet">
              <span class="text">Wallet Balance</span>
              <span class="text">
                <h1>{{ wallet.current_balance }}.00</h1>
              </span>
            </div>
          </Card>


          <h3 class="mt-3 text-light">Referral Code</h3>
          <div>
            <input disabled :placeholder="userData.ref_code.code" name="" id="" type="text" :value="userData.ref_code.code"> <button class="btn btn--black">Copy</button>
          </div>
        </div>

        <div class="column justify-center align-center fullwidth">
          <img width="300" src="/help.svg" alt="">

          <div class="history" v-if="userData.hasValidId">
            <Card height="30px" v-for="(x, i) in history" :key="i">
              <div class="row between">
                <span>Amount: <strong>{{ x.amount }}</strong></span>
                <small>Receiver: {{ x.recipient }}</small>
              </div>
            </Card>
          </div>

          <h3 v-if="!userData.hasValidId" class="text-light">
            Add A Valid ID Card to transfer up to 200,000
          </h3>
          <button v-if="!userData.hasValidId" class="btn btn--success" @click="showIdForm = true">Add ID Card</button>

          <form @submit.prevent="addIdCard" v-if="showIdForm" class="halfwidth">
            <div class="form-group">
              <input v-model="form.id_number" placeholder="Enter your ID Card Number" required type="text" class="form-control" autocomplete>
            </div>
            <div class="form-group">
              <input v-model="form.id_name" placeholder="Enter your ID Card Name" required type="text" class="form-control" autocomplete>
            </div>
            <div class="form-group">
              <button class="btn btn--black" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { Notify } from "notiflix";

export default {
  name: 'dashboard',
  components: {
    Card: () => import('../Components/Card')
  },
  data() {
    return {
      history: JSON.parse(localStorage.getItem('history')) || [],
      showIdForm: false,
      isTransferring: false,
      exceedsAmount: false,
      form: {
        id_number: '',
        id_name: '',
        token: localStorage.getItem('token')
      },
      transfer: {
        recipient: '',
        amount: '',
      }
    }
  },
  computed: {
    ...mapState({
      user: state => state.user,
      token: state => state.token,
      wallet: state => state.wallet,
      userData: state => state.userData
    })
  },
  watch: {
    'transfer.amount': function(val) {
      if (val > this.wallet.max_transfer) {
        this.exceedsAmount = true;
        this.transfer.amount = this.wallet.max_transfer;
        Notify.Failure(`You reached your transfer limit of ${this.wallet.max_transfer}`)
      } else {
        this.exceedsAmount = false;
      }
    }
  },
  methods: {
    getWallet() {
      Promise.all([
        this.$store.dispatch('getWallet', this.token),
        this.$store.dispatch('getUserData', this.token)
      ])
    },
    addIdCard() {
      this.$store.dispatch('addIdCard', this.form)
        .then(() => {
          Notify.Success('ID Card added successfully')
          this.$store.dispatch('getUserData', this.token)
          window.location.reload()
        })
    },
    transferMoney() {
      this.history.push({ amount: this.transfer.amount, recipient: this.transfer.recipient, type: 'transfer' })
      localStorage.setItem('history', JSON.stringify(this.history))
      this.$store.dispatch('transfer', this.transfer)
        .then(() => {
          this.getWallet()
          Notify.Success('Transfer has been scheduled')
        })

    }
  },
  created() {
    this.getWallet()
  }
}
</script>

<style lang="scss" scoped>
  .dashboard {
    margin-top: 10px;
    margin: 40px;
    .side-image {
      height: 50px;
      width: 50px;
      margin-top: 10px;
      border-radius: 50%;
      background-position: center;
      background-image: url('https://visme.co/blog/wp-content/uploads/2017/08/40-Creative-Logo-Designs-to-Inspire-You-SlingShot.gif');
    }
    .actions {
      margin-bottom: 10px;
      button {
        margin: 4px;
      }
    }
    .money {
      margin-left: 30px;
    }
    .history {
      .card {
        margin-top: 10px
      }
    }
    small {
      font-size: 10px;
    }
  }
</style>
