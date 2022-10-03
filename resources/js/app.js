/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap")

window.Vue = require("vue").default
import { Icon } from "@iconify/vue2"
import axios from "axios"
import Vue from 'vue'
import VueSweetalert2 from 'vue-sweetalert2'

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css'

Vue.use(VueSweetalert2)
Vue.component("Icon", Icon)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('pagination', require('laravel-vue-pagination'))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
)
Vue.component(
    "receipt-upload",
    require("./components/client/ReceiptUpload.vue").default
)

Vue.component(
    "receipts",
    require("./components/admin/Receipts.vue").default
)

Vue.component(
    "check-receipt-status",
    require("./components/client/ReceiptStatus.vue").default
)

Vue.component(
    "receipt-details",
    require("./components/admin/ReceiptDetails.vue").default
)

Vue.component(
    "settings",
    require("./components/admin/Settings.vue").default
)

Vue.component(
    "profile",
    require("./components/admin/Profile.vue").default
)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
})
