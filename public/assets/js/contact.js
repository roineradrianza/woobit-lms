
/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    loading: false,
    nav_tab: String,
    carousel: 0,
    alert: false,
    alert_message: '',
    alert_type: '',
    loading: false,
    valid: false,
    validations,
    form: {
      name: '',
      email: '',
      message: ''
    },
    notifications: [],
    carousel: 0,
  },

  computed: {
  },

  created() {
    check_google_user()
  },

  mounted() {
  },

  methods: {

    sendMessage() {
      var app = this

      if (!app.$refs.contact_form.validate()) {
        return false
      }

      app.loading = true
      app.$http.post(api_url + 'contact/send-message', app.form).then( res => {
        app.loading = false
        app.alert_type = res.body.status
        app.alert_message = res.body.message
        app.alert = true
      }, err => {
        app.loading = false
        app.alert_type = 'error'
        app.alert_message = 'Erori neașteptate, încercați din nou'
        app.alert = true
      })
    }
  }
});