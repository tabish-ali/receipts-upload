<template>
  <div>
    <div class="py-4">
      <h3 class="fw-bold">Wallet Settings</h3>
    </div>
    <div class="bg-white p-4">
      <form @submit.prevent="setSettings">
        <div class="form-group">
          <label class="custom-label">Name</label>
          <input
            v-model="settings.name"
            class="form-control"
            type="text"
            placeholder="Enter account holder name"
          />
        </div>
        <div class="form-group mt-4">
          <label class="custom-label">Number</label>
          <input
            v-model="settings.number"
            class="form-control"
            type="text"
            placeholder="Enter account holder number for gcash"
          />
        </div>
        <div class="mt-5">
          <button :disabled="loading" type="submit" class="btn btn-success">
            <button-spinner v-if="loading" />
            <Icon v-else icon="mdi:check-circle-outline" class="icon me-2" />
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ButtonSpinner from '../spinners/ButtonSpinner'

export default {
  props: ['admin'],
  components: { ButtonSpinner },
  data() {
    return {
      loading: false,
      settings: {
        name: '',
        number: '',
      },
    }
  },

  mounted() {
    axios.defaults.headers.common[
      'Authorization'
    ] = `Bearer ${this.admin.api_token}`
  },

  methods: {
    async getSettings() {
      this.loading = true
      axios
        .post('api/get-account-settings', { settings: this.settings })
        .then((response) => {
          this.settings.name = response.settings.name
          this.settings.number = response.settings.number
          this.loading = false
        })
    },

    async setSettings() {
      axios
        .post('api/set-account-settings', { settings: this.settings })
        .then((response) => {
          this.$swal(
            'New account settings saved successfully',
            'Player will be shown these saved details for gcash wallet.',
            'success'
          )
        })
    },
  },
}
</script>
