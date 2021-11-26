
/*VUE INSTANCE*/
Vue.use(VueTelInputVuetify, {
  vuetify,
});
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    tab: null,
    nav_tab: null,
    sidebar_tab: url_params.get('tab'),
    birthdate_modal: null,
    image_btns: false,
    image_upload_btn: false,
    profile_container: false,
    courses_container: false,
    orders_container: false,
    grades_container: false,
    children_container: false,
    main_container: true,
    dialogOrderPreview: false,
    loading: false,
    avatar_loading: false,
    edit_profile_loading: false,
    my_courses_loading: false,
    my_orders_loading: false,
    new_courses_loading: false,
    snackbar: false,
    snackbar_timeout: 4000,
    selection: 1,
    snackbar_text: '',
    telephone: '',
    alert: false,
    alert_type: '',
    alert_message: '',
    preview_avatar_image: '',
    notifications: [],
    countries: [],
    country_states: [],
    coming_classes: [],
    my_courses: [],
    new_courses: [],
    orders: {
      items: [],
      headers: [
        { text: 'ID', align: 'start', value: 'order_id' },
        { text: 'Data', align: 'start', value: 'registered_at' },
        { text: 'Suma', align: 'start', value: 'amount' },
        { text: 'Metoda de plată', align: 'start', value: 'payment_method' },
        { text: 'Stat', align: 'start', value: 'status' },
        { text: 'Acțiune', value: 'actions', align: 'center', sortable: false },
      ],
      editedIndex: -1,
      editedItem: {},
      defaultItem: {},
    },
    grades: {
      dialog: false,
      loading: false,
      headers: [
        { text: 'Test', align: 'start', value: 'lesson_name' },
        { text: 'Scor', align: 'start', value: 'score' },
        { text: 'Stare', align: 'center', value: 'approved' },
        { text: 'Acțiune', align: 'center', value: 'action' },
      ],
      course: {},
      items: [],
      editedItem: {

      }
    },
    children: new Children({uid: uid}),
    profile: {
      first_name: '',
      last_name: '',
      email: '',
      birthdate: '',
      gender: '',
      country_selected: '',
      state_selected: '',
      password: '',
      meta: [],
    },
    validations,
    genders: [
      {
        text: 'Omul',
        value: 'M'
      },
      {
        text: 'Femeie',
        value: 'F'
      },
    ],
    password_confirm: ''
  },

  computed: {

    full_name() {
      if (this.profile.hasOwnProperty('first_name') && this.profile.hasOwnProperty('last_name')) {
        return this.profile.first_name + ' ' + this.profile.last_name
      }
    },

    teacher_gender() {
      if (this.profile.gender == 'F') {
        return 'Profesora'
      }
      else {
        return 'Profesor'
      }
    },

    location() {
      return this.profile.meta.country + ', ' + this.profile.meta.state
    },

    AmountInBs() {
      var amount = this.orders.editedItem.meta.tax_day * this.orders.editedItem.total_pay
      var percent = amount * 0.16
      amount = amount + percent
      var formatter = new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'VES',
      });
      return formatter.format(amount)
    },

    GradesAverage() {
      var grades = 0
      var total_grades = 0
      this.grades.items.forEach(item => {
        if (item.score !== null) {
          grades += parseInt(item.score)
          total_grades++
        }
      });
      if (total_grades > 0) {
        var grade_average = Math.round(grades / total_grades)
        return `Promedio de puntuación: ${grade_average}`
      }
      else {
        return ''
      }
    }

  },

  created() {
    check_google_user()
    this.initialize()
    this.loadCountries()
    this.loadMyCourses()
    this.children.load()
    this.loadNewCourses()
    this.loadComingClasses()
    this.loadMyOrders()
  },

  watch: {
    profile_container(val) {
      if (val) {
        if (this.courses_container) {
          this.courses_container = false
        }
        if (this.orders_container) {
          this.orders_container = false
        }
        if (this.grades_container) {
          this.grades_container = false
        }
        if (this.children_container) {
          this.children_container = false
        }
      }
      this.alert = false
      this.getCountryID()
      this.getStateID()
    },

    courses_container(val) {
      if (val) {
        if (this.profile_container) {
          this.profile_container = false
        }
        if (this.orders_container) {
          this.orders_container = false
        }
        if (this.grades_container) {
          this.grades_container = false
        }
        if (this.children_container) {
          this.children_container = false
        }
      }
      this.alert = false
    },

    orders_container(val) {
      if (val) {
        if (this.profile_container) {
          this.profile_container = false
        }
        if (this.courses_container) {
          this.courses_container = false
        }
        if (this.grades_container) {
          this.grades_container = false
        }
        if (this.children_container) {
          this.children_container = false
        }
      }
      this.alert = false
    },

    grades_container(val) {
      if (val) {
        if (this.profile_container) {
          this.profile_container = false
        }
        if (this.courses_container) {
          this.courses_container = false
        }
        if (this.orders_container) {
          this.orders_container = false
        }
        if (this.children_container) {
          this.children_container = false
        }
      }
      this.alert = false
    },

    children_container(val) {
      if (val) {
        if (this.profile_container) {
          this.profile_container = false
        }
        if (this.courses_container) {
          this.courses_container = false
        }
        if (this.orders_container) {
          this.orders_container = false
        }
        if (this.grades_container) {
          this.grades_container = false
        }
      }
      this.alert = false
    }
  },

  mounted() {
  },

  methods: {

    initialize() {
      var app = this
      var url = api_url + 'members/get/' + uid
      if (app.sidebar_tab != null) {
        app[app.sidebar_tab] = true
      }
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          app.profile = res.body[0]
          app.profile.old_avatar = app.profile.avatar
          app.preview_avatar_image = app.profile.avatar
          app.profile.user_id = uid
        }
      }, err => {

      })
    },

    loadMyCourses() {
      var app = this
      var url = api_url + 'courses/get-my-courses/' + uid
      app.my_courses_loading = true
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          app.my_courses = res.body
        }
        app.my_courses_loading = false
      }, err => {
        app.my_courses_loading = false
      })
    },

    loadMyGrades() {
      var app = this
      var url = api_url + 'lesson-quizzes/get-my-grades/' + app.grades.course.course_id
      app.grades.loading = true
      app.grades.items = []
      app.$http.post(url).then(res => {
        if (res.body.length > 0) {
          app.grades.items = res.body
        }
        app.grades.loading = false
      }, err => {
        app.grades.loading = false
      })
    },

    loadMyOrders() {
      var app = this
      var url = api_url + 'orders/get-my-orders/' + uid
      app.my_orders_loading = true
      var clientDateTime = Intl.DateTimeFormat().resolvedOptions()
      app.$http.post(url, { timezone: clientDateTime.timeZone }).then(res => {
        if (res.body.length > 0) {
          app.orders.items = res.body
        }
        app.my_orders_loading = false
      }, err => {
        app.my_orders_loading = false
      })
    },

    loadNewCourses() {
      var app = this
      var url = api_url + 'courses/get-new-courses'
      app.new_courses_loading = true
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          app.new_courses = res.body
        }
        app.new_courses_loading = false
      }, err => {
        app.new_courses_loading = false
      })
    },

    loadComingClasses() {
      var app = this
      var url = api_url + 'courses/get-coming-live-classes'
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          app.coming_classes = res.body
        }
      }, err => {
      })
    },

    saveProfile() {
      var app = this
      app.active = false
      app.edit_profile_loading = true
      var url = api_url + 'members/update-profile'
      app.$http.post(url, app.profile).then(res => {
        app.alert = true
        app.alert_type = res.body.status
        app.alert_message = res.body.message
        app.edit_profile_loading = false
      }, err => {

      })
    },

    loadCountries() {
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
      var country = this.profile.country_selected
      var results = states.filter((state) => {
        return state.id_country == country
      });
      return this.country_states = results
    },

    getCountryName() {
      var app = this;
      var countries = app.countries
      var country_selected = app.profile.country_selected
      var results = countries.filter((country) => {
        return country.id == country_selected
      });
      return app.profile.meta.country = results[0].name;
    },

    getStateName() {
      var app = this;
      var states = app.states
      var state_selected = app.profile.state_selected
      var results = states.filter((state) => {
        return state.id == state_selected
      });
      return app.profile.meta.state = results[0].name;
    },

    getCountryID() {
      var app = this;
      var countries = app.countries
      var country_selected = app.profile.meta.country
      var results = countries.filter((country) => {
        return country.name == country_selected
      });
      return app.profile.country_selected = results[0].id
    },

    getStateID() {
      var app = this;
      app.filterStates()
      var states = app.states
      var state_selected = app.profile.meta.state
      var results = states.filter((state) => {
        return state.name == state_selected
      });
      return app.profile.state_selected = results[0].id;
    },

    getInput(text, data) {
      this.telephone = data.number.international
    },

    previewOrderItem(item) {
      this.orders.editedIndex = this.orders.items.indexOf(item)
      this.orders.editedItem = Object.assign({}, item)
      this.dialogOrderPreview = true
    },

    getOrderStatus(status) {
      switch (parseInt(status)) {
        case 0:
          return { color: 'warning', name: 'Prelucrare' }
          break;

        case 1:
          return { color: 'success', name: 'Aprobat' }
          break;

        case 2:
          return { color: 'error', name: 'Respinsă' }
          break;
      }
    },

    getLocation() {
      this.getCountryName();
      this.getStateName();
    },

    prevImage(e) {
      var app = this
      const image = e.target.files[0]
      const reader = new FileReader()
      reader.readAsDataURL(image)
      reader.onload = e => {
        app.profile.avatar = image
        app.preview_avatar_image = e.target.result
        app.image_btns = true
      };
    },

    undoImagePreview() {
      var app = this
      app.preview_avatar_image = app.old_avatar
      app.image_btns = false
      app.image_upload_btn = false
    },

    updateAvatarImage() {
      var app = this
      let data = new FormData()
      app.avatar_loading = true
      data.append('avatar', app.profile.avatar)
      data.append('old_avatar', app.profile.old_avatar)
      var url = api_url + 'members/update-avatar'
      app.$http.post(url, data).then(res => {
        app.avatar_loading = false
        app.snackbar = true
        app.snackbar_text = res.body.message
        if (res.body.status == 'success') {
          app.profile.avatar = res.body.data.avatar
          app.profile.old_avatar = res.body.data.avatar
          app.preview_avatar_image = res.body.data.avatar
          app.image_upload_btn = false
          app.image_btns = false
        }
      }, err => {
        app.snackbar = true
        app.snackbar_text = 'Eroare neașteptată, încercați din nou'
        app.avatar_loading = false
      })
    },

    checkPasswords() {
      var app = this
      if (app.profile.password_confirm != app.profile.password) {
        return false
      }
      return true
    },

  }
});