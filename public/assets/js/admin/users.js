Vue.use(VueTelInputVuetify, {
  vuetify,
});
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {
      search: '',
      loading: false,
      table_loading: false,
      drawer: true,
      dialog: false,
      valid: false,
      dialogDelete: false,
      birthdateDialog: false,
      birthdate_modal: false,
      modal: false,
      selectedItem: 8,
      states: [],
      country_states: [],
      countries: [],
      validations,
      gender: [
        {
          text: 'Bărbat',
          value: 'M'
        },
        {
          text: 'Femeie',
          value: 'F'
        },
      ],
      headers: [
        { text: 'Nume și prenume', align: 'start', value: 'full_name' },
        { text: 'Tipul de utilizator', value: 'user_type' },
        { text: 'Adresa de e-mail', value: 'email' },
        { text: 'Acțiuni', value: 'actions', align:'center', sortable: false },
      ],
      members: [],
      user_types: ['administrator', 'membru'],
      editedIndex: -1,
      editedItem: {},
      defaultItem: {
        username: '',
        first_name: '',
        avatar: '',
        last_name: '',
        birthdate: '',
        gender: '',
        user_type: '',
        email: '',
        country: '',
        city: '',
        password: '',
        password_confirm: '',
        meta: {},
      },
    },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Înregistrare utilizator' : 'Editare utilizator'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      check_google_user()
      this.editedItem = this.defaultItem
      this.loadCountries()
      this.initialize()
    },

    mounted () {
    },

    methods: {
      initialize () {
        var url = api_url + 'members/get'
        this.table_loading = true
        this.$http.get(url).then(res => {
          this.table_loading = false
          res.body.forEach(user => {
            user.full_name = user.first_name + ' ' + user.last_name
          });
          this.members = res.body;
        }, err => {

        })
      },

      editItem (item) {
        this.editedIndex = this.members.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.getCountryID()
        this.filterStates()
        this.getStateID()
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.members.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        var id = this.editedItem.user_id;
        var url = api_url + 'members/delete'
        this.$http.post(url, {user_id: id}).then(res => {
            this.members.splice(this.editedIndex, 1)
            this.closeDelete()
          }, err => {
          this.closeDelete()
        })
      }, 

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        var app = this
        var editedIndex = app.editedIndex
        var member = app.editedItem
        member.full_name = member.first_name + ' ' + member.last_name
        if (app.editedIndex > -1) {
          var url = api_url + 'members/update'
          app.$http.post(url, member).then(res => {
            if (res.body.status == "success") {
              Object.assign(app.members[editedIndex], member)              
            }
            app.close()
          }, err => {

          })
        } else {
          var url = api_url + 'members/create'
          app.$http.post(url, member).then(res => {
            member.date = current_date
            if (res.body.status == 'success') {
              member.user_id = res.body.data.user_id
              app.members.push(member)
            }
            app.close()
          }, err => {
            app.close()
          })
        }
      },


     validate () {
        this.$refs.form.validate()
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

      filterStates () {
        var states = this.states
        var country = this.editedItem.country_selected
        var results = states.filter( (state) => { 
          return state.id_country == country
        });
        return this.country_states = results
      },

      getCountryName () {
        var app = this;
        var countries = app.countries
        var country_selected = app.editedItem.country_selected
        var results = countries.filter( (country) => { 
          return country.id == country_selected
        });
        return app.editedItem.meta.country = results[0].name;
      },

      getStateName () {
        var app = this;
        var states = app.states
        var state_selected = app.editedItem.state_selected
        var results = states.filter( (state) => { 
          return state.id == state_selected
        });
        return app.editedItem.meta.state = results[0].name;
      },

      getCountryID () {
        var app = this;
        var countries = app.countries
        var country_selected = app.editedItem.meta.country
        var results = countries.filter( (country) => { 
          return country.name == country_selected
        });
        return app.editedItem.country_selected = results[0].id
      },

      getStateID () {
        var app = this;
        var states = app.states
        var state_selected = app.editedItem.meta.state
        var results = states.filter( (state) => { 
          return state.name == state_selected
        });
        return app.editedItem.state_selected = results[0].id;
      },

      getInput (text, data) {
        this.telephone = data.number.international
      },

      getLocation() {
        this.getCountryName();
        this.getStateName();
      },

  	}
});