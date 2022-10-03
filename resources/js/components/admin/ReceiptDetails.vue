<template>
  <div class="d-flex flex-column">
    <div class="py-2">
      <a type="button" href="/dashboard" class="btn btn-primary inline">
        <Icon class="icon me-2" icon="mdi:arrow-left" />
        Back
      </a>
    </div>
    <div
      class="d-flex flex-sm-row flex-column justify-content-between border border-warning bg-white rounded"
    >
      <div class="w-100">
        <div class="border-bottom w-100 px-4 py-2">
          <label class="custom-label">
            <Icon class="icon me-2" icon="mdi:receipt-text-outline" />
            Receipt No</label
          >
          <span class="ms-4">{{ receipt.receipt_id }}</span>
        </div>
        <div class="border-bottom w-100 px-4 py-2">
          <label class="custom-label">
            <Icon class="icon me-2" icon="mdi:account-circle-outline" />
            Username</label
          >
          <span class="ms-4">{{ receipt.username }}</span>
        </div>
        <div class="border-bottom w-100 px-4 py-2">
          <label class="custom-label">
            <Icon class="icon me-2" icon="mdi:card-account-details-outline" />
            Full Name</label
          >
          <span class="ms-4">{{ receipt.full_name }}</span>
        </div>
        <div class="border-bottom w-100 px-4 py-2">
          <label class="custom-label">
            <Icon class="icon me-2" icon="mdi:cellphone" />
            Phone</label
          >
          <span class="ms-4">{{ receipt.phone }}</span>
        </div>
        <div class="border-bottom w-100 px-4 py-2">
          <label class="custom-label">
            <Icon class="icon me-2" icon="mdi:account-circle-outline" />
            Email</label
          >
          <span class="ms-4">{{ receipt.email }}</span>
        </div>
        <div class="border-bottom w-100 px-4 py-2">
          <label class="custom-label">
            <Icon class="icon me-2" icon="mdi:calendar-range" />
            Date</label
          >
          <span class="ms-4">{{ receipt.created_at }}</span>
        </div>
        <div class="border-bottom w-100 px-4 py-2">
          <label class="custom-label">
            <Icon class="icon me-2" icon="mdi:list-status" />
            Status</label
          >
          <span
            :class="{
              'text-success border-success': receipt.status === 'verified',
              'text-warning border-warning': receipt.status === 'pending',
              'text-danger border-danger': receipt.status === 'rejected',
            }"
            class="ms-4 text-uppercase fw-bold border rounded p-1"
            >{{ receipt.status }}</span
          >
        </div>
        <div class="w-100 px-4 py-2" v-if="receipt.status === 'pending'">
          <label class="custom-label">Action</label>
          <div class="d-flex">
            <button
              @click="setStatus('verified')"
              class="btn btn-success d-flex align-items-center"
            >
              <Icon icon="mdi:check-all" class="icon me-2" />
              Verify
            </button>
            <button @click="setStatus('rejected')" class="btn btn-danger ms-4">
              <Icon icon="mdi:close-circle-outline" class="icon me-2" />
              Reject
            </button>
          </div>
        </div>
        <div
          class="w-100 px-4 py-2"
          v-if="receipt.status === 'verified' || receipt.status === 'rejected'"
        >
          <label class="custom-label text-capitalize">
            <Icon class="icon me-2" icon="mdi:update" />
            {{ receipt.status }} At</label
          >
          <span class="ms-4 text-uppercase">{{ receipt.updated_at }}</span>
        </div>
      </div>
      <div class="px-4 py-2 border mt-sm-0 mt-5">
        <img class="receipt-preview" :src="getPreview()" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ButtonSpinner from '../spinners/ButtonSpinner'

export default {
  props: ['receipt', 'admin'],
  components: { ButtonSpinner },
  data() {
    return {}
  },

  mounted() {
    axios.defaults.headers.common[
      'Authorization'
    ] = `Bearer ${this.admin.api_token}`
  },

  methods: {
    async setStatus(status) {
      const statusText = status === 'verified' ? 'Verify' : 'Reject'
      await this.$swal({
        title: `Do you want ${statusText} this receipt?`,
        text: `Once ${status}, you will not be able to change it's status again.`,
        showCancelButton: true,
        confirmButtonText: `${statusText}`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          setTimeout(() => {
            this.$swal('Please wait, receipt is being verified.')
          }, 1000)

          axios
            .post('/api/set-receipt-status', {
              id: this.receipt.id,
              status: status,
            })
            .then((response) => {
              if (response.data.message === 'success') {
                this.$swal(
                  'Receipt verfied succesfully.',
                  'Page will refresh in a moment.',
                  'success'
                )
                setTimeout(() => {
                  location.reload()
                }, 1000)
              }
            })
        } else if (result.isDenied) {
        }
      })
    },

    getPreview() {
      return '/storage/uploads/' + this.receipt.receipt
    },
  },
}
</script>

<style>
.receipt-preview {
  width: 100%;
  height: auto;
  border-radius: 5px;
}
</style>
