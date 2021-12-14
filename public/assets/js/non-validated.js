
/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    loading: false,
    nav_tab: String,
    notifications: [],
    alert: false,
    alert_message: '',
    alert_type: '',
  },

  computed: {
  },

  created() {
    check_google_user()
  },

  mounted() {
  },

  methods: {

    requestVerification() {
      var app = this
      var url = api_url + 'member-verification/request'

      app.loading = true
      app.$http.get(url).then( res => {
        app.loading = false
        app.alert = true
        app.alert_message = res.body.message
        app.alert_type = res.body.status
      }, err => {
        app.loading = false
        app.alert = true
        app.alert_message = 'A apărut o eroare neașteptată, vă rugăm să încercați din nou.'
        app.alert_type = 'error'
      })
    }

  }
});