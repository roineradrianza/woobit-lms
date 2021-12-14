
/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    redirect_url: url_params.get('redirect_url'),
    tab: null,
    nav_tab: null,
    dialog: false,
    loading: false,
    reset_loading: false,
    alert: false,
    alert_type: false,
    alert_message: '',
    email: '',
    email_reset: '',
    password: '',
  },

  computed: {
  },

  created() {
    this.init()
  },

  mounted() {
  },

  methods: {

    init() {
      var app = this
      gapi.load('client:auth2', () => {
        gapi.client.init({
          apiKey: google_api_key,
          client_id: google_client_key,
          discoveryDocs: ["https://people.googleapis.com/$discovery/rest?version=v1"],
          scope: 'https://www.googleapis.com/auth/userinfo.profile',
        })
          .then(() => {
            // Handle the initial sign-in state.
            app.updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get())
          });
      });
    },

    updateSigninStatus(isSignedIn) {
      if (isSignedIn) {
        this.makeGoogleApiCall()
      }
    },

    makeGoogleApiCall() {
      var app = this
      app.loading = true
      app.alert = false
      gapi.client.people.people.get({
        'resourceName': 'people/me',
        'personFields': 'names,birthdays,photos,genders,emailAddresses,phoneNumbers,locations,addresses',
      }).then(res => {
        var r = res.result
        var user = {}
        user.gid = r.names[0].metadata.source.id
        user.first_name = r.names[0].givenName
        user.last_name = r.names[0].familyName
        user.email = r.emailAddresses[0].value
        user.gender = r.hasOwnProperty('genders') ? app.formatGender(r.genders[0].value) : 'N'
        user.avatar = r.hasOwnProperty('photos') ? r.photos[0].url : null
        var url = api_url + 'members/sign-in'
        app.$http.post(url, user).then(res => {
          app.alert = true
          app.alert_message = res.body.message
          app.alert_type = res.body.status
          if (res.body.status == 'success') {
            if (app.redirect_url != null) {
              window.location = app.redirect_url
            }
            else {
              window.location = res.body.data
            }
          }
        }, err => {
          app.loading = false
          app.alert = true
          app.alert_message = 'A apărut o eroare neașteptată, vă rugăm să încercați din nou.'
          app.alert_type = 'error'
        })
        app.loading = false
      });
    },

    googleSignIn() {
      var app = this
      gapi.auth2.getAuthInstance().signIn().then(res => {
        app.updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get())
      });
    },

    fbLogin() {
      var app = this
      var user = {}
      var url = api_url + 'members/sign-in'
      if (FB.getUserID() != '') {
        FB.api('/me?locale=ro_RO&fields=id, gender, name,email, first_name, last_name, picture.width(600)', (r) => {
          app.loading = true
          user = r
          user.facebook_id = user.id; // get FB UID
          user.avatar = user.picture.data.url; // get avatar
          app.$http.post(url, user).then(res => {
            app.alert = true
            app.alert_message = res.body.message
            app.alert_type = res.body.status
            app.loading = false
            if (res.body.status == 'success') {
              if (app.redirect_url != null) {
                window.location = app.redirect_url
              }
              else {
                window.location = res.body.data
              }
            }
          }, err => {
            app.loading = false
            app.alert = true
            app.alert_message = 'A apărut o eroare neașteptată, vă rugăm să încercați din nou.'
            app.alert_type = 'error'
          })
          // you can store this data into your database             
        });
      }
      else {
        FB.login((response) => {

          if (response.authResponse) {

            FB.api('/me?locale=ro_RO&fields=id, gender, name,email, first_name, last_name, picture.width(600)', (r) => {
              app.loading = true
              user = r
              user.facebook_id = user.id; // get FB UID
              user.avatar = user.picture.data.url; // get avatar
              app.$http.post(url, user).then(res => {
                app.alert = true
                app.alert_message = res.body.message
                app.alert_type = res.body.status
                if (res.body.status == 'success') {
              app.loading = false
                  if (app.redirect_url != null) {
                    window.location = app.redirect_url
                  }
                  else {
                    window.location = res.body.data
                  }
                }
              }, err => {
                app.loading = false
                app.alert = true
                app.alert_message = 'A apărut o eroare neașteptată, vă rugăm să încercați din nou.'
                app.alert_type = 'error'
              })
              // you can store this data into your database             
            });

          } else {
            //user hit cancel button
            console.log('User cancelled login or did not fully authorize.')
          }
        });
      }
    },

    signIn() {
      var app = this
      app.loading = true
      app.alert = false
      var url = api_url + 'members/sign-in'
      var user = { 'email': app.email, 'password': app.password }
      app.$http.post(url, user).then(res => {
        app.alert = true
        app.alert_message = res.body.message
        app.alert_type = res.body.status
        if (res.body.status == 'success') {
          if (app.redirect_url != null) {
            window.location = app.redirect_url
          }
          else {
            window.location = res.body.data
          }
        }
      }, err => {
        app.loading = false
        app.alert = true
        app.alert_message = 'A apărut o eroare neașteptată, vă rugăm să încercați din nou.'
        app.alert_type = 'error'
      })
      app.loading = false
    },

    resetPassword() {
      var url = api_url + 'password/request-reset'
      var app = this
      var email = app.email_reset
      app.reset_loading = true
      app.alert = false
      app.$http.post(url, { email: email }).then(res => {
        app.reset_loading = false
        app.alert_message = res.body.message
        app.alert_type = res.body.status
        app.alert = true
        app.dialog = false
      }, err => {
        app.reset_loading = false

      })
    },

    formatGender(g) {
      if (g == 'male') {
        return 'M'
      }
      else if (g == 'female') {
        return 'M'
      }
    },

  }

});