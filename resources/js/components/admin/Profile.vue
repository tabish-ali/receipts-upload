<template>
  <div>
    <div class="py-4">
      <h3 class="fw-bold">Profile</h3>
    </div>
    <div class="bg-white p-4">
      <form @submit.prevent="update">
        <div class="form-group mt-4" v-for="attr in account">
          <label class="custom-label">{{ attr.label }}</label>
          <input
            v-model="attr.value"
            :placeholder="attr.placeholder"
            :type="attr.type"
            class="form-control"
          />
        </div>
        <div class="mt-5">
          <button
            :disabled="loading"
            class="btn btn-success d-flex align-items-center"
          >
            <button-spinner v-if="loading" />
            <Icon v-else icon="mdi:check-circle-outline" class="icon me-2" />
            Update
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
      account: {
        username: {
          label: 'Username',
          type: 'text',
          placeholder: 'Enter username',
          value: this.admin.username,
        },
        email: {
          label: 'Email',
          type: 'email',
          placeholder: 'Enter your email address',
          value: this.admin.email,
        },
        password: {
          label: 'Password',
          type: 'password',
          placeholder: 'Enter your new password',
          value: '',
        },
      },
    }
  },
  mounted() {
    axios.defaults.headers.common[
      'Authorization'
    ] = `Bearer ${this.admin.api_token}`
  },

  methods: {
    async update() {
      if (
        this.account.password.value.length >= 8 &&
        this.account.username.value
      ) {
        this.loading = true
        let account = {
          username: this.account.username.value,
          email: this.account.email.value,
          password: this.account.password.value,
        }
        await axios
          .post('api/update-profile', { account: account })
          .then((response) => {
            if (response.status == 200) {
              this.$swal(
                'Profile updated successfully',
                'Make sure to secure or remember your password.',
                'success'
              )
              this.loading = false
            }
          })
          .catch((err) => {
            this.$swal('Error', 'Something went wrong', 'error')
            this.loading = false
          })
      } else {
        this.$swal(
          'Validation Error',
          'Password must be greater than or equal to 8 characters and username must be filled.',
          'warning'
        )
      }
    },
  },
}
</script>
