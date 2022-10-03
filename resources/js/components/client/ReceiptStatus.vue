<template>
  <div>
    <div>
      <h1 class="fw-bold">Check Your Receipt Status</h1>
    </div>
    <div class="p-4 bg-white rounded shadow-sm">
      <form @submit.prevent="searchReceipt">
        <div class="form-group">
          <label class="custom-label">Enter ID</label>
          <input
            v-model="receiptId"
            class="form-control"
            type="number"
            placeholder="Enter 6 digit receipt number"
          />
        </div>
        <div class="form-group mt-5">
          <button
            :disabled="loading"
            type="submit"
            class="btn btn-primary d-flex align-items-center"
          >
            <button-spinner v-if="loading" />
            <Icon
              v-else
              icon="mdi:clipboard-text-search-outline"
              class="icon me-2"
            />
            Check
          </button>
        </div>
      </form>
    </div>
    <div class="mt-5" v-if="receipt.receipt_id">
      <div>
        <label class="custom-label">Receipt Number</label>
        <span class="text-dark fw-bold">{{ receipt.receipt_id }}</span>
      </div>
      <div class="mt-2">
        <label class="custom-label">Username</label>
        <span class="text-uppercase fw-bold text-dark">{{
          receipt.username
        }}</span>
      </div>
      <div class="mt-2">
        <label class="custom-label">Date Submitted</label>
        <span>{{ receipt.created_at }}</span>
      </div>
      <div class="mt-2">
        <label class="custom-label">Status</label>
        <span
          :class="{
            'border-warning border bg-warning': receipt.status === 'pending',
            'border-danger border bg-danger text-light': receipt.status === 'rejected',
            'border-success border bg-success text-light': receipt.status === 'verified',
          }"
          class="text-uppercase p-1 rounded fw-bold"
          >{{ receipt.status }}</span
        >
      </div>
    </div>
    <div class="erorr mt-2">
      <span class="text-danger fw-bold">{{ error }}</span>
    </div>
    <div class="mt-5 fw-bold">
      <span>Receipt not found?</span>
      <a type="button" href="/">Submit New Receipt</a>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ButtonSpinner from '../spinners/ButtonSpinner'

export default {
  components: { ButtonSpinner },
  data() {
    return {
      loading: false,
      receiptId: '',
      receipt: { receipt_id: '', username: '', date: '', status: '' },
      error: '',
    }
  },

  mounted() {},

  methods: {
    async searchReceipt() {
      this.loading = true
      await axios
        .post('/serach-receipt', { receipt_id: this.receiptId })
        .then((response) => {
          if (response.data.receipt == null) {
            this.receipt.receipt_id = ''
            this.error =
              'No receipt found against that number. Please try again.'
          } else {
            this.receipt = response.data.receipt
            this.error = ''
          }
          this.loading = false
        })
        .catch((err) => {
          this.loading = false
        })
    },
  },
}
</script>
