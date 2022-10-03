<template>
  <div>
    <div>
      <stats :admin="admin" />
    </div>
    <div class="d-flex flex-sm-row flex-column py-4">
      <h3 class="fw-bold w-100">Receipts Uploaded by Players</h3>
      <input
        @keyup="startSearch"
        @keydown="doneSearch"
        @focus="filter"
        v-model="searchText"
        class="w-100 form-control"
        autocomplete="false"
        type="text"
        placeholder="Search receipts by username or receipt id ..."
      />
    </div>
    <div class="table-responsive">
      <table class="table fw-bold">
        <thead class="text-uppercase">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Receipt No</th>
            <th scope="col">Username</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(receipt, index) in receipts.data">
            <th scope="row">{{ index + 1 }}</th>
            <td>{{ receipt.receipt_id }}</td>
            <td>
              <span class="text-uppercase">{{ receipt.username }}</span>
            </td>
            <td>
              <small
                :class="{
                  'bg-warning text-dark': receipt.status === 'pending',
                  'bg-success text-light': receipt.status === 'verified',
                  'bg-danger text-light': receipt.status === 'rejected',
                }"
                class="text-uppercase p-1 rounded"
                >{{ receipt.status }}</small
              >
            </td>
            <td>
              <a :href="'/receipt-details/' + receipt.id">View</a>
              <a
                type="button"
                @click="deleteReceipt(receipt)"
                class="ms-2 text-danger"
                >Delete</a
              >
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination
      size="small"
      @pagination-change-page="getReceipts"
      class="mt-5"
      :limit="Number(3)"
      :data="receipts"
    >
      <template #current-nav>
        <span>&lt; </span>
      </template>
      <template #prev-nav>
        <Icon class="icon" icon="mdi:arrow-left-thin-circle-outline" />
      </template>
      <template #next-nav>
        <Icon class="icon" icon="mdi:arrow-right-thin-circle-outline" />
      </template>
    </pagination>
  </div>
</template>

<script>
import axios from 'axios'
import Stats from './Stats'
export default {
  components: { Stats },
  props: ['admin'],
  data() {
    return {
      receipts: {},
      loading: false,
      searchText: '',
      doneTypingInterval: 1000,
      typingTimer: null,
    }
  },

  mounted() {
    axios.defaults.headers.common[
      'Authorization'
    ] = `Bearer ${this.admin.api_token}`
    this.getReceipts()
  },

  methods: {
    //on keyup, start the countdown
    startSearch() {
      //timer identifier
      clearTimeout(this.typingTimer)
      this.typingTimer = setTimeout(() => {
        this.filter()
      }, this.doneTypingInterval)
    },

    //on keydown, clear the countdown
    doneSearch() {
      clearTimeout(this.typingTimer)
    },

    async filter(page = 1) {
      if (this.searchText.length > 2) {
        await axios
          .get('api/search-receipts', {
            params: {
              search_text: this.searchText,
              page: page,
            },
          })
          .then((response) => {
            this.receipts = response.data.receipts
          })
      } else {
        this.getReceipts()
      }
    },

    async deleteReceipt(receipt) {
      await this.$swal({
        title: `Do you want delete this receipt?`,
        text: `Once deleted you will not be able to recover the details and receipt preview.`,
        showCancelButton: true,
        confirmButtonText: `Delete`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          axios
            .post('api/delete-receipt', { receipt_id: receipt.id })
            .then((response) => {
              if (response.data.message === 'success')
                this.$swal('Receipt is deleted successfully.', 'success')
            })
          this.getReceipts()
        }
      })
    },

    async getReceipts(page = 1) {
      await axios
        .get('api/get-receipts', { params: { page: page } })
        .then((response) => {
          this.receipts = response.data.receipts
        })
    },
  },
}
</script>
