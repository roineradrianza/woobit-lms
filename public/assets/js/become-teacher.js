
/*VUE INSTANCE*/
Vue.use(VueTelInputVuetify, {
  vuetify,
});
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    loading: false,
    list_loading: false,
    nav_tab: String,
    alert: false,
    alert_type: '',
    alert_message: '',
    validations,
    interest: '',
    student_interest: '',
    min: 5,
    max: 17,
    range: [5, 17],
    application_form: true,
    forms: {
      step1: true,
      step2: true,
      step3: true,
      step4: true,
      step5: true
    },
    modals: {
      experience: {
        work: {
          start: false,
          end: false
        },
        volunteer: {
          start: false,
          end: false
        },
        project: {
          start: false,
          end: false
        },
        book: {
          published: false,
        }
      },
    },
    employment_types: [
      {
        text: 'Normă întreagă',
        value: 1,
      },
      {
        text: 'Jumătate de normă',
        value: 2,
      },
      {
        text: 'Liber profesionist',
        value: 3,
      },
      {
        text: 'Contract temporar',
        value: 4,
      },
      {
        text: 'Contractul de stagiu',
        value: 5,
      },
      {
        text: 'Contract de formare profesională',
        value: 6,
      },
    ],
    form: {
      application_id: Number,
      first_name: '',
      last_name: '',
      id_file: new File([], ''),
      video_file: new File([], ''),
      status: Number,
      meta: {
        teacher_address: '',
        teacher_email: '',
        teacher_telephone: '',
        id_url: '',
        video_url: '',
        certificates: [],
        experience: {
          projects: [],
          volunteer: [],
          work: [],
          books: [],
        },
        courses: [],
        interests: [],
        linkedin: '',
        instagram: '',
        facebook: '',
        paypal: '',
        dni: '',
        pesonal_video: '',
        availability: [],
        students_interests: [],
        min_students_age: 5,
        max_students_age: 17
      }
    },
    search: '',
    notifications: [],
  },

  watch: {
    range() {
      this.form.meta.min_students_age = this.range[0]
      this.form.meta.max_students_age = this.range[1]
    }
  },

  computed: {
  },

  created() {
    this.form.first_name = basic_info.first_name
    this.form.last_name = basic_info.last_name
    this.form.meta.teacher_email = basic_info.email
    this.form.meta.teacher_telephone = basic_info.telephone
    this.initialize()
    check_google_user()
  },

  mounted() {

  },

  methods: {

    initialize() {
      var app = this
      var url = api_url + 'applications/get/' + uid
      app.list_loading = true

      app.$http.get(url).then(res => {
        app.list_loading = false
        if (res.body.length > 0) {
          app.form = res.body[0]
          app.form.video_file = new File([], ''),
          app.form.id_file = new File([], '')
          app.range[0] = parseInt(app.form.meta.min_students_age)
          app.range[1] = parseInt(app.form.meta.max_students_age)
        }
      }, err => {
        app.list_loading = false
      }) 
    },

    save() {
      var app = this
      var form = new FormData
      var method = app.form.application_id == undefined ? 'create' : app.form.application_id > 0 ? 'update' : 'create'
      var url = api_url + `applications/${method}`

      form.append('first_name', app.form.first_name)
      form.append('last_name', app.form.last_name)
      form.append('id_file', app.form.id_file)
      form.append('video_file', app.form.video_file)
      form.append('meta', JSON.stringify(app.form.meta))

      app.loading = true

      app.$http.post(url, form).then(res => {
        if (res.body.status == 'success') {
          app.form.status = 0
          method == 'create' ? app.form.application_id = res.body.data.application_id : ''
          app.response(res.body.status, res.body.message)
        }
      }, err => {
        app.response('error')
      })

    },

    addDegree() {
      this.form.meta.certificates.push(
        {
          year: '',
          institution: '',
          degree: '',
        }
      )
    },

    addCourse() {
      this.form.meta.courses.push(
        {
          title: '',
          description: '',
        }
      )
    },

    addWork() {
      this.form.meta.experience.work.push(
        {
          company: '',
          position: '',
          location: '',
          employment_type: 1,
          currently_active: 0,
          start_date: '',
          end_date: '',
          description: ''
        }
      )
    },

    addVolunteer() {
      this.form.meta.experience.volunteer.push(
        {
          company: '',
          position: '',
          charitable_cause: '',
          currently_active: 0,
          start_date: '',
          end_date: '',
          description: ''
        }
      )
    },

    addProject() {
      this.form.meta.experience.projects.push(
        {
          name: '',
          currently_active: 0,
          url: '',
          start_date: '',
          end_date: '',
          description: '',
        }
      )
    },

    addBook() {
      this.form.meta.experience.books.push(
        {
          title: '',
          publisher: '',
          published_date: '',
          url: '',
          description: ''
        }
      )
    },

    removeItem(item, index) {
      item.splice(index, 1)
    },

    getInput(text, data) {
      this.form.meta.teacher_telephone = data.number.international
    },

    response(type = '', message = '') {
      this.loading = false
      this.alert = true
      this.alert_type = type
      this.alert_message = type == 'error' ? message == '' ? 'A apărut o eroare neașteptată, vă rugăm să încercați din nou.' : message : message
  }

  }
});