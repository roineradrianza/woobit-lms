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
      notifications: [],
      states: [],
      country_states: [],
      countries: [],
      validations,
      gender: [
        {
          text: 'Hombre',
          value: 'M'
        },
        {
          text: 'Mujer',
          value: 'F'
        },
        {
          text: 'Prefiero no especificar',
          value: 'N'
        },
      ],
      degrees: [
        'Ortopedia', 'Neurocirugía', 
        'Cirugía de Columna', 'Radiología',
        'Radiología', 'Dolor/Cuidado Paliativos',
        'Reumatología', 'Infectología', 'Otros'
      ],
      resident_levels: [
        'Residente de 1er año', 'Residente de 2do año', 
        'Residente de 3er año', 'Residente de 4to año',
      ],
      form: {
        username: '',
        first_name: '',
        last_name: '',
        avatar: '',
        last_name: '',
        birthdate: '',
        gender: '',
        user_type: '',
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
      defaultItem: {
        username: '',
        first_name: '',
        last_name: '',
        avatar: '',
        last_name: '',
        birthdate: '',
        gender: '',
        user_type: '',
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
      check_google_user()
      this.loadCountries()
      this.initialize()
    },

    mounted () {
    },

    methods: {

      initialize () {
        var app = this
        app.loading = true
        var url = api_url + 'members/get/' + uid
        app.$http.get(url).then( res => {
          if (res.body.length > 0) {
            app.form = Object.assign({}, res.body[0])
            app.form.user_id = uid
            app.form.meta = app.form.meta.length <= 0 ? {} : app.form.meta
          }
          app.loading = false
        }, err => {
          app.loading = false
        })
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
          var url = api_url + 'members/complete-register'
          if (app.form.meta.student_type == 'medicine_teacher') {
            app.form.meta.become_teacher = 1
          }
          app.form.meta.telephone = app.telephone
          app.$http.post(url, app.form).then(res => {
            app.alert = true
            app.alert_type = res.body.status
            app.alert_message = res.body.message
            if (res.body.status == 'success') {
              window.location = domain
            }
            app.save_loading = false
          }, err => {
            app.alert = true
            app.alert_type = 'error'
            app.alert_message = 'Error inesperado, intenta de nuevo' 
            app.save_loading = false       
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

  	}
});