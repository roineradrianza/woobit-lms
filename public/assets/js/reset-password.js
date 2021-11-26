let params = new URLSearchParams(location.search);
const resetCode = params.get('code');
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {
      valid: false,
      tab: null,
      nav_tab: null,
      loading: false,
      alert: false,
      alert_message: '',
      alert_type: '',
      password: '',
      password_confirm: '',
      valid_text: '',
      validations
    },

    computed: {
    },

    created () {
    },

    mounted () {
    },

    methods: {

      resetPassword () {
        var url = api_url + 'password/reset/' + resetCode
        var app = this
        app.alert = false
        if(app.password != app.password_confirm) {
          app.alert_message = 'Las contraseñas deben ser iguales'
          app.alert_type = 'warning'
          app.alert = true          
          return false
        }
        app.loading = true
        app.alert = false
        app.$http.post(url, {password: app.password}).then(res => {
          app.loading = false
          app.alert_message = res.body.message
          app.alert_type = res.body.status
          app.alert = true
          if (res.body.status == 'success') {
            window.open(window.location.origin + '/login', '_blank');
          }
        }, err => {
          app.loading = false
        })
      }
  	}
});