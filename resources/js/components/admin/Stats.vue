<template>
  <div class="d-flex justify-content-between flex-sm-row flex-column">
    <div
      class="bg-info border border-dark border-2 p-4 w-100 me-sm-1 me-0 rounded shadow-sm text-dark"
    >
      <h5 class="fw-bold">Total Amount</h5>
      <h6 class="fw-bold">
        {{
          stats.total_amount.toLocaleString(undefined, {
            minimumFractionDigits: 1,
          })
        }}
      </h6>
    </div>
    <div
      class="bg-primary border border-dark border-2 w-100 p-4 me-sm-1 me-0 rounded shadow-sm mt-sm-0 mt-2 text-white"
    >
      <h5 class="fw-bold">Total Receipts</h5>
      <h6 class="fw-bold">{{ stats.total }}</h6>
    </div>
    <div
      class="bg-warning border border-dark border-2 w-100 p-4 me-sm-1 me-0 rounded shadow-sm mt-sm-0 mt-2 text-dark"
    >
      <h5 class="fw-bold">Pending Receipts</h5>
      <h6 class="fw-bold">{{ stats.pending }}</h6>
    </div>
    <div
      class="bg-success border border-dark border-2 w-100 p-4 me-sm-1 me-0 rounded shadow-sm mt-sm-0 mt-2 text-white"
    >
      <h5 class="fw-bold">Verified Receipts</h5>
      <h6 class="fw-bold">{{ stats.verified }}</h6>
    </div>
    <div
      class="bg-danger border border-dark border-2 w-100 p-4 me-sm-1 me-0 rounded shadow-sm mt-sm-0 mt-2 text-white"
    >
      <h5 class="fw-bold">Rejected Receipts</h5>
      <h6 class="fw-bold">{{ stats.rejected }}</h6>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: ['admin'],
  data() {
    return {
      stats: {},
    }
  },
  mounted() {
    axios.defaults.headers.common[
      'Authorization'
    ] = `Bearer ${this.admin.api_token}`
    this.getStats()
  },
  methods: {
    async getStats() {
      axios.get('api/get-stats').then((response) => {
        this.stats = response.data.stats
      })
    },
  },
}
</script>
