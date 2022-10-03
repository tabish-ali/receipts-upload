<template>
  <div class="d-flex justify-content-center flex-column align-items-center">
    <div class="py-1 d-flex justify-content-center text-center">
      <h3 class="fw-bold text-uppercase text-dark">Please enter the details</h3>
    </div>
    <div class="mt-2 fw-bold text-success py-2 d-flex align-items-center">
      <img src="/assets/logos/gcash.png" class="me-2" alt="-" />
      <span class="text-capitalize">Account Name: {{ settings.name }}</span>
      &nbsp;|&nbsp;
      <span>Phone Number:&nbsp;</span>
      <span ref="numberField"> {{ settings.number }}</span>
      <small
        @click="copyNumber"
        type="button"
        class="text-uppercase text-dark p-1 rounded"
        >Copy</small
      >
    </div>
    <div
      class="border rounded border-warning border-4 p-4 form-div align-items-center shadow-sm"
    >
      <form @submit.prevent="upload" class="w-100">
        <div class="form-group">
          <label class="custom-label">
            <Icon icon="mdi:account-circle-outline" class="label-icon" />
            Username <b class="text-danger">*</b>
          </label>
          <input
            required
            v-model="info.username"
            type="text"
            placeholder="Enter username used in main site."
            class="form-control"
          />
        </div>
        <div class="form-group mt-3">
          <label class="custom-label">
            <Icon icon="mdi:card-text-outline" class="label-icon" />
            Full Name <b class="text-danger">*</b>
          </label>
          <input
            required
            v-model="info.fullName"
            type="text"
            placeholder="Enter your full name"
            class="form-control"
          />
        </div>
        <div class="form-group mt-3">
          <label class="custom-label">
            <Icon icon="mdi:email-fast-outline" class="label-icon" />
            Email <b class="text-danger">*</b>
          </label>
          <input
            required
            v-model="info.email"
            type="email"
            placeholder="Enter valid email that is used in main site."
            class="form-control"
          />
        </div>
        <div class="form-group mt-3">
          <label class="custom-label">
            <Icon icon="mdi:email-fast-outline" class="label-icon" />Phone
            <b class="text-danger">*</b>
          </label>
          <input
            required
            v-model="info.phone"
            type="text"
            placeholder="Enter your phone number"
            class="form-control"
          />
        </div>
        <div class="form-group mt-3">
          <label class="custom-label">
            <Icon icon="mdi:receipt-text-outline" class="label-icon" />Receipt
            <b class="text-danger">*</b>
          </label>
          <input
            required
            @change="onChange"
            type="file"
            placeholder="Upload valid receipt."
            class="form-control"
          />
          <small class="text-info fw-bold"
            >File must be within 2MB size (jpg, jpeg and png are allowed)</small
          >
        </div>
        <div class="form-group mt-3">
          <button
            :disabled="loading"
            type="submit"
            class="btn-block w-100 justify-content-center btn btn-success d-flex align-items-center"
          >
            <Icon
              v-if="!loading"
              class="button-icon"
              icon="mdi:check-circle-outline"
            />
            <button-spinner v-if="loading" />
            Submit
          </button>
        </div>
        <div v-if="message.text" class="mt-3">
          <small
            class="fw-bold"
            :class="message.cls"
            v-for="msg in message.text"
            >{{ msg }}</small
          >
        </div>
      </form>
      <div>
        <span>Already submitted a receipt,</span>
        <a href="/check-receipt-status">check status here</a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ButtonSpinner from '../spinners/ButtonSpinner.vue'

export default {
  props: ['settings'],

  components: { ButtonSpinner },

  mounted() {},

  data() {
    return {
      info: {
        fullName: '',
        username: '',
        email: '',
        phone: '',
        file: '',
      },
      message: {
        text: [],
        cls: '',
      },
      loading: false,
    }
  },
  methods: {
    onChange(e) {
      this.info.file = e.target.files[0]
    },

    copyNumber() {
      /* Get the text field */
      let copyText = this.$refs.numberField

      var textArea = document.createElement('textarea')
      textArea.value = copyText.textContent
      document.body.appendChild(textArea)
      textArea.select()
      document.execCommand('Copy')
      textArea.remove()

      this.$swal(
        'Copied successfully.',
        'success'
      )
    },

    async upload() {
      this.loading = true
      if (
        this.info.username &&
        this.info.fullName &&
        this.info.email &&
        this.info.phone &&
        this.info.file
      ) {
        const config = {
          headers: {
            'content-type': 'multipart/form-data',
          },
        }

        let data = new FormData()
        data.append('file', this.info.file)
        data.append('info', JSON.stringify(this.info))

        axios
          .post('/receipt-upload', data, config)
          .then((response) => {
            this.loading = false
            if (response.data.message === 'success') {
              let message = `Data and receipt uploaded successfully. Receipt id = ${response.data.recepit_id}`
              this.message.text.push(message)
              this.message.cls = 'text-success'
              this.info.file = null
              this.info.username = ''
              this.info.fullName = ''
              this.info.phone = ''
              this.info.email = ''
            } else if (response.data.message == 'failed') {
              let message = `Something went wrong.`
              this.message.text.push(message)
              this.message.cls = 'text-danger'
            } else if (response.status === 422) {
              this.message.text.push('file error.')
            } else if (response.status === 413) {
              this.message.text.push('file is too big.')
            }
          })
          .catch((e) => {
            e.response.data.errors.file.forEach((msg) => {
              this.message.text.push(msg)
            })
            this.loading = false
            this.message.cls = 'text-danger'
          })
      } else {
        this.message.text.push('Please complete all required fields.')
      }
    },
  },
}
</script>
