Vue.use(VueTelInputVuetify, {
  vuetify,
});
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#full-learning-container',
    data: {      
      tab: null,
      nav_tab: null,
      loading: false,
      save_loading: false,
      birthdate_modal: false,
      valid: false,
      alert: false,
      alert_type: '',
      alert_message: '',
      telephone: '',
      states: [],
      country_states: [],
      countries: [],
      validations,
      gender: [
        {
          text: 'Omul',
          value: 'M'
        },
        {
          text: 'Femeie',
          value: 'F'
        },
      ],
      form: {
      },
      defaultItem: {
        username: '',
        first_name: '',
        last_name: '',
        avatar: '',
        last_name: '',
        birthdate: '',
        gender: '',
        email: '',
        country_selected: '',
        state_selected: '',
        password: '',
        password_confirm: '',
        meta: {
          student_type: 'student',
          become_teacher: 0
        },
      },
      valid: true,
    },

    computed: {
    },

    created () {
      this.init()
      this.form = this.defaultItem
      this.loadCountries()
    },

    mounted () {
    },

    methods: {

      init () {
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

      validate () {
        return this.$refs.form.validate()
      },

      loadCountries () {
        this.$http.get(domain + '/countries.min.json').then(res => {
          this.countries = res.body.countries
        }, err => {

        })
        this.$http.get(domain + '/states.min.json').then(res => {
          this.states = res.body.states
        }, err => {

        })
      },

      updateSigninStatus(isSignedIn) {
        if (isSignedIn) {
          this.makeGoogleApiCall()
        }
      },

      makeGoogleApiCall() {
        var app = this
        app.save_loading = true
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
              window.location = res.body.data
            }
            app.save_loading = false
          }, err => {
            app.save_loading = false
          })
        });
      },

      googleSignIn () {
        var app = this
        gapi.auth2.getAuthInstance().signIn().then(res => {
          app.updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get())
        });
      },

      filterStates() {
        var states = this.states
        var country = this.form.country_selected
        var results = states.filter( (state) => { 
          return state.id_country == country
        });
        return this.country_states = results
      },

      getCountryName() {
        var app = this;
        var countries = app.countries
        var country_selected = app.form.country_selected
        var results = countries.filter( (country) => { 
          return country.id == country_selected
        });
        return app.form.meta.country = results[0].name;
      },

      getStateName() {
        var app = this;
        var states = app.states
        var state_selected = app.form.state_selected
        var results = states.filter( (state) => { 
          return state.id == state_selected
        });
        return app.form.meta.state = results[0].name;
      },

      getLocation() {
        this.getCountryName();
        this.getStateName();
      },

      getInput (text, data) {
        this.telephone = data.number.international
      },

      save () {
        var app = this
        app.alert = false
        app.validate()
        if (!app.validate()) {
          app.valid = false
        }
        else {
          app.save_loading = true
          var url = api_url + 'members/register'
          app.form.meta.telephone = app.telephone
          app.$http.post(url, app.form).then(res => {
            app.save_loading = false
            app.alert = true
            app.alert_type = res.body.status
            app.alert_message = res.body.message
            if (res.body.status == 'success') {
              window.location = domain + '/profile'
            }
          }, err => {
            app.save_loading = false
            app.alert = true
            app.alert_type = 'error'
            app.alert_message = 'Eroare neașteptată, încercați din nou'.        
          })
        }
      },

      checkPasswords() {
        var app = this
        if(app.form.password_confirm != app.form.password) {
          return false
        }
        return true
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