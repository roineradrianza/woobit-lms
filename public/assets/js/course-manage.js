/*VUE INSTANCE*/
Vue.component("downloadExcel", JsonExcel);
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    tab: null,
    nav_tab: null,
    course_tab: null,
    list_tab: null,
    snackbar: false,
    stepper: 1,
    snackbar_text: '',
    snackbar_timeout: 20000,
    loading: false,
    add_loading: false,
    coupon_loading: false,
    certified_loading: false,
    search_user_loading: false,
    reminder_loading: false,
    my_orders_loading: false,
    coupon_field: false,
    dialog: false,
    dialogUserRemove: false,
    sponsorViewsStatistics: false,
    valid: false,
    searched: false,
    stepper_dialog: true,
    dialogDelete: false,
    modal: false,
    modal_course: true,
    alert: false,
    alert_type: '',
    alert_message: '',
    coupon_code: '',
    course_id: '',
    search_students_pendings: '',
    user_search: '',
    user_selected: {},
    requiredField: [v => !!v || 'Este campo es requerido'],
    rol_selected: 'estudiante',
    notifications: [],
    users_list: [],
    sections: [],
    quizzes: {
      loading: false,
      search: '',
      excel: {
        header: {
          'Nombre completo': 'full_name',
        },
        students: []
      },
      headers: [],
      quizzes: [],
      students: [],
    },
    rol_list: [
      {
        text: 'Estudiante',
        value: 'estudiante'
      },
      {
        text: 'Residente',
        value: 'residente'
      },
      {
        text: 'Oyente',
        value: 'oyente'
      },
    ],
    class_views: {
      loading: false,
      quizzes_loading: false,
      total_views_loading: false,
      total_views_dialog: false,
      total_course_loading: false,
      total_course_zoom: 0,
      total_course_video: 0,
      total_quizzes_done: 0,
      search: '',
      items: [],
      headers: [
        { text: 'Nombre completo', value: 'full_name', align: 'start', filterable: true },
        { text: 'Correo electrónico', value: 'email' },
        { text: 'Zoom', value: 'zoom' },
        { text: 'Video', value: 'video' },
      ],
      excel: {
        total_quizzes_header: {
          'Clase': 'lesson_name',
          'Estudiantes': 'students',
        },
        total_views_headers: {
          'Clase': 'lesson_name',
          'Zoom': 'zoom_views',
          'Video': 'video_views',
        },
      },
      total_views_headers: [
        { text: 'Clase', value: 'lesson_name', align: 'start', filterable: true },
        { text: 'Zoom', value: 'zoom_views' },
        { text: 'Video', value: 'video_views' },
      ],
      quizzes_done_headers: [
        { text: 'Clase', value: 'lesson_name', align: 'start', filterable: true },
        { text: 'Estudiantes', value: 'students' },
      ],
      editedItem: {
        items: [],
        section_id: '',
        section_name: ''
      }
    },
    students_enrolled: {
      loading: false,
      search: '',
      items: [],
      headers: [
        { text: 'Nombre completo', value: 'full_name', align: 'start', filterable: true },
        { text: 'Correo electrónico', value: 'email' },
        { text: 'Provincia / País', value: 'location' },
        { text: 'Teléfono', value: 'meta.telephone' },
        { text: 'Acciones', value: 'actions', align: 'center', sortable: false },
      ]
    },
    gratuated_students: {
      loading: false,
      search: '',
      items: [],
      headers: [
        { text: 'Nombre completo', value: 'full_name', align: 'start', filterable: true },
        { text: 'Correo electrónico', value: 'email' },
        { text: 'Acciones', value: 'actions', align: 'center', sortable: false },
      ]
    },
    listeners: {
      loading: false,
      search: '',
      items: [],
      headers: [
        { text: 'Nombre completo', value: 'full_name', align: 'start', filterable: true },
        { text: 'Correo electrónico', value: 'email' },
        { text: 'Acciones', value: 'actions', align: 'center', sortable: false },
      ]
    },
    students_pendings: {
      loading: false,
      search: '',
      items: [],
      headers: [
        { text: 'Nombre completo', value: 'full_name', align: 'start', filterable: true },
        { text: 'Correo electrónico', value: 'email' },
        { text: 'Recordatorio', value: 'reminder', align: 'center', },
      ]
    },
    instructors_pendings: {
      loading: false,
      search: '',
      items: [],
      headers: [
        { text: 'Nombre completo', value: 'full_name', align: 'start', filterable: true },
        { text: 'Correo electrónico', value: 'email' },
        { text: 'Recordatorio', value: 'reminder', align: 'center', },
      ]
    },
    rating: {
      my_rating: {},
      items: [],
      loading: false,
      form_valid: true,
      form_loading: false,
      myCommentIsPublished: false,
      form_rules: {
        comment: [
          v => !!v || 'Es requerido escribir un comentario',
          v => (v && v.length <= 10) || 'Debe ser un comentario mayor a 10 caracteres',
        ],
      },
      form: {
        comment: '',
        stars: 5,
      },
      defaultForm: {
        comment: '',
        stars: 5
      }
    },
    my_progress: {
      progress: 'N/A',
      quizzes_approved: 0,
      total_quizzes: 0,
      quizzes: [],
      certified: '',
    },
    orders: {
      items: [],
      headers: [
        { text: 'ID', align: 'start', value: 'order_id' },
        { text: 'Fecha', align: 'start', value: 'registered_at' },
        { text: 'Monto', align: 'start', value: 'amount' },
        { text: 'Método de Pago', align: 'start', value: 'payment_method' },
      ],
      editedIndex: -1,
      editedItem: {},
    },
    sponsors: [],
    sponsors_posts_filtered: [],
    sponsors_posts: [],
    sponsor_statistics: {
      loading: false,
      headers: [
        { text: 'Patrocinador', value: 'sponsor_name', align: 'start'},
        { text: 'Clicks totales', value: 'total' },
      ],
      items: [],
    },
    editedIndex: -1,
    editedItem: {},
    defaultItem: {
    },
  },

  computed: {
  },

  watch: {
    dialogUserRemove(val) {
      val || this.closeDelete()
    },
    sponsorViewsStatistics(val) {
      this.getSponsorViewsStatistics() || val
    },
  },

  created() {
    check_google_user()
  },

  mounted() {
    this.course_id = this.$refs.course_container.getAttribute('course_id')
    if (url_params.get('course_tab') != null) {
      this.course_tab = url_params.get('course_tab')
      setTimeout(() => {
        this.$refs.tabs_section.$el.scrollIntoView({ behavior: 'smooth' })
      }, 2000)
    }
    this.initialize()
    this.initializePendingStudents()
    this.initializePendingInstructors()
    this.initializeSections()
    this.initializeSponsors()
    this.initializeSponsorsPosts()
    this.initializeComments()
    this.initializeCourseProgress()
    this.initializeCourseOrders()
  },

  methods: {
    initialize() {
      var app = this
      var url = api_url + 'course-students/get-students/' + app.course_id
      app.students_enrolled.loading = true
      app.$http.get(url).then(res => {
        app.students_enrolled.loading = false
        app.students_enrolled.items = res.body;
        if (app.students_enrolled.items.length > 0) {
          app.initializeStudentsQuizzes()
        }
      }, err => {

      })
      url = api_url + 'course-students/get-students-approved/' + app.course_id
      app.$http.post(url).then(res => {
        app.gratuated_students.loading = false
        app.gratuated_students.items = res.body;
      }, err => {

      })    
      url = api_url + 'course-students/get-users/' + app.course_id
      app.$http.post(url, { rol: 'oyente' }).then(res => {
        app.listeners.loading = false
        app.listeners.items = res.body;
      }, err => {

      })
    },

    initializeSections() {
      var app = this
      var data = { course_id: app.course_id }
      var url = api_url + 'course-sections/get-only-classes'
      app.$http.post(url, data).then(res => {
        app.sections = res.body
      }, err => {

      })
    },

    initializeSponsors() {
      var app = this
      var url = api_url + 'sponsors/get-by-course/' + app.course_id
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          app.sponsors = res.body
        }
      }, err => {

      })
    },

    initializeSponsorsPosts() {
      var app = this
      var url = api_url + 'sponsors-posts/get/' + app.course_id
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          app.sponsors_posts_filtered = _.shuffle(res.body)
          app.sponsors_posts = res.body
        }
      }, err => {

      })
    },

    initializeStudentsQuizzes() {
      var app = this
      var url = api_url + 'lesson-quizzes-reports/get/' + app.course_id
      var excel = app.quizzes.excel
      app.$http.get(url).then(res => {
        if (res.body.hasOwnProperty('quizzes') && res.body.hasOwnProperty('students_quizzes')) {
          var headers = app.quizzes.headers
          headers.push({ text: 'Nombre completo', value: 'full_name' })
          res.body.quizzes.forEach(quiz => {
            var item = {}
            item.text = quiz.lesson_name
            item.value = quiz.lesson_id
            item.align = 'start'
            headers.push(item)
            excel.header[item.text] = parseInt(item.value)
          })
          app.quizzes.items = res.body.quizzes
          app.quizzes.headers = headers
          var students_quizzes = []
          app.students_enrolled.items.forEach((student) => {
            item = { full_name: student.full_name, user_id: student.user_id }
            excel_item = { full_name: item.full_name }
            res.body.students_quizzes.forEach((quiz) => {
              if (quiz.user_id == student.user_id) {
                item[quiz.lesson_id] = quiz.score
                excel_item[quiz.lesson_id] = quiz.score
              }
            });
            app.quizzes.students.push(item)
            excel.students.push(excel_item)
          });
          excel.students = _.orderBy(excel.students, ['full_name'], ['asc'])
        }
      }, err => {

      })
    },

    initializePendingStudents() {
      var app = this
      var url = api_url + 'course-students/get-pending-students/' + app.course_id
      app.students_pendings.loading = true
      app.$http.get(url).then(res => {
        app.students_pendings.loading = false
        app.students_pendings.items = res.body;
      }, err => {

      })
    },

    initializePendingInstructors() {
      var app = this
      var url = api_url + 'course-students/get-pending-instructors/' + app.course_id
      app.instructors_pendings.loading = true
      app.$http.get(url).then(res => {
        app.instructors_pendings.loading = false
        app.instructors_pendings.items = res.body;
      }, err => {

      })
    },

    initializeComments() {
      var app = this
      var url = api_url + 'course-ratings/get/' + app.course_id
      app.rating.loading = true
      app.$http.get(url).then(res => {
        app.rating.items = res.body;
      }, err => {

      })
      var url = api_url + 'course-ratings/get-mine/' + app.course_id
      app.$http.post(url).then(res => {
        if (res.body.length > 0) {
          app.rating.myCommentIsPublished = true
          res.body[0].stars = parseInt(res.body[0].stars)
          app.rating.my_rating = res.body[0]
        }
        app.rating.loading = false
      }, err => {

      })
    },

    initializeCourseProgress() {
      var app = this
      var data = {
        course_id: app.course_id
      }
      var url = api_url + 'course-students/get-student-progress-total'
      app.certified_loading = true
      app.$http.post(url, data).then(res => {
        app.my_progress = res.body
        app.certified_loading = false
      }, err => {
        app.certified_loading = false
      })
    },

    initializeCourseOrders() {
      var app = this
      var url = api_url + 'orders/get-course-orders/' + app.course_id
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

    getSponsorViewsStatistics(section) {
      var app = this
      app.class_views.loading = true
      var url = api_url + 'sponsor-views/get-total/' + app.course_id
      app.$http.get(url).then(res => {
        app.sponsor_statistics.loading = false
        app.sponsor_statistics.items = res.body;
      }, err => {
        app.sponsor_statistics.loading = false
      })
    },

    getSectionTotalViews(section) {
      var app = this
      app.class_views.editedItem.items = []
      app.class_views.editedItem = Object.assign({}, section)
      app.class_views.editedItem.quizzes = []
      app.class_views.total_views_dialog = true
      var url = api_url + 'course-sections/get-total-views/'
      app.class_views.total_views_loading = true
      app.class_views.quizzes_loading = true
      var data = { section_id: section.section_id, course_id: app.course_id }
      app.$http.post(url, data).then(res => {
        app.class_views.total_views_loading = false
        app.class_views.editedItem.items = res.body;
      }, err => {

      })
      url = api_url + 'course-sections/get-total-quizzes-done/'
      app.$http.post(url, data).then(res => {
        app.class_views.quizzes_loading = false
        app.class_views.editedItem.quizzes = res.body;
      }, err => {

      })
    },

    getCourseTotalViews() {
      var app = this
      app.class_views.total_course_loading = true
      var url = api_url + 'courses/get-total-views/'
      var data = { sections: app.sections, course_id: app.course_id }
      app.$http.post(url, data).then(res => {
        app.class_views.total_course_loading = false
        app.class_views.total_course_video = res.body.total_video_views
        app.class_views.total_course_zoom = res.body.total_zoom_views
        app.class_views.total_quizzes_done = res.body.total_quizzes_done
      }, err => {
        app.class_views.total_course_loading = false
      })
    },

    saveSponsorView(sponsor_id) {
      var app = this
      app.$http.post(api_url + 'sponsor-views/create', { sponsor_id: sponsor_id, course_id: app.course_id })
        .then(res => { })
    },

    saveSponsorPostView(sponsor_post_id) {
      var app = this
      app.$http.post(api_url + 'sponsor-post-views/create',
        { sponsor_post_id: sponsor_post_id, course_id: app.course_id })
        .then(res => { console.log(res) })
    },

    getLessonViews(lesson) {
      var app = this
      app.class_views.items = []
      app.class_views.excel.students = []
      app.class_views.loading = true
      var data = {
        course_id: app.course_id,
        lesson_id: lesson.lesson_id
      }
      var url = api_url + 'lessons/get-classes'
      app.$http.post(url, data).then(res => {
        app.class_views.loading = false
        var excel = app.class_views.excel
        if (res.body.length > 0) {
          res.body.forEach((user) => {
            app.class_views.items.push(user)
            var zoom_view = parseInt(user.zoom_view) == 0 ? 'Sí' : 'No'
            var video_view = parseInt(user.video_view) == 0 ? 'Sí' : 'No'
            excel.students.push({ full_name: user.full_name, zoom_view, video_view })
          })
          excel.students = _.orderBy(excel.students, ['full_name'], ['asc'])
        }
      }, err => {
        app.class_views.loading = false
      })
    },

    filterSponsorPosts(sponsor_id) {
      var app = this
      app.saveSponsorView(sponsor_id)
      var filtered = _.filter(app.sponsors_posts, (post) => { return post.sponsor_id == sponsor_id })
      var other_posts = _.filter(app.sponsors_posts, (post) => { return post.sponsor_id != sponsor_id })
      app.sponsors_posts_filtered = filtered
      other_posts.forEach((post) => {
        app.sponsors_posts_filtered.push(post)
      });
    },

    searchUser() {
      var app = this
      var url = api_url + 'members/search-user/' + app.user_search
      app.user_selected = ''
      app.search_user_loading = true
      app.$http.get(url).then(res => {
        app.search_user_loading = false
        app.searched = true
        app.users_list = res.body
      }, err => {

      })
    },

    addUser() {
      var app = this
      app.alert = false
      if (app.checkStudent(app.user_selected)) {
        app.alert = true
        app.alert_message = 'El usuario ya se encuentra añadido al curso'
        app.alert_type = 'warning'
      }
      else {
        app.add_loading = true
        var url = api_url + 'courses/add-student'
        var data = {
          course_id: app.course_id,
          user_id: app.user_selected.user_id,
          user_rol: app.rol_selected
        }
        app.$http.post(url, data).then(res => {
          if (res.body.status == "success") {
            app.initialize()
          }
          app.alert = true
          app.alert_type = res.body.status
          app.alert_message = res.body.message
          app.add_loading = false
        }, err => {
          app.add_loading = false
        })
      }
    },

    checkStudent(user) {
      var app = this
      var students = app.students_enrolled.items.filter((item) => {
        return item.user_id == user.user_id;
      });
      var listeners = app.listeners.items.filter((item) => {
        return item.user_id == user.user_id;
      });
      if (students.length > 0 || listeners.length > 0) {
        return true
      }
      return false
    },

    editItem(item) {
      var app = this
      app.editedIndex = app.students_enrolled.items.indexOf(item)
      app.editedItem = Object.assign({}, item)
      app.dialog = true
    },

    deleteItem(item, rol = "") {
      var app = this
      item.rol = rol
      app.editedIndex = rol == 'oyente' ? app.listeners.items.indexOf(item) : app.students_enrolled.items.indexOf(item)
      app.editedItem = Object.assign({}, item)
      app.dialogUserRemove = true
    },

    remindUsers(item = [], all_students = false) {
      var app = this
      app.snackbar = false
      var students = [item]
      if (all_students) {
        app.reminder_loading = true
        var students = Object.assign({}, app.students_pendings.items)
      }
      var data = {
        course_id: app.course_id,
        students: students
      }
      var url = api_url + 'emails/remind-users-pending/'
      app.$http.post(url, data).then(res => {
        app.reminder_loading = false
        app.snackbar = true
        app.snackbar_text = 'Se envió el correo recordatorio al usuario'
        if (all_students) {
          app.snackbar_text = 'Se envió el correo recordatorio a los usuarios'
        }
        app.snackbar_type = 'primary'
      }, err => {
        app.reminder_loading = false
        app.snackbar = true
        app.snackbar_text = 'Eroare neașteptată, încercați din nou'
        app.snackbar_type = 'error'
      })
    },

    remindUsersCourseProgress(item = [], all_students = false) {
      var app = this
      app.snackbar = false
      var students = [item]
      if (all_students) {
        app.reminder_loading = true
        var students = Object.assign({}, app.students_enrolled.items)
      }
      var data = {
        course_id: app.course_id,
        students: students
      }
      var url = api_url + 'emails/remind-users-course-progress/'
      app.$http.post(url, data).then(res => {
        app.reminder_loading = false
        app.snackbar = true
        app.snackbar_text = 'Se envió el correo recordatorio al usuario'
        if (all_students) {
          app.snackbar_text = 'Se envió el correo recordatorio a los usuarios'
        }
        app.snackbar_type = 'primary'
      }, err => {
        app.reminder_loading = false
        app.snackbar = true
        app.snackbar_text = 'Eroare neașteptată, încercați din nou'
        app.snackbar_type = 'error'
      })
    },

    remindInstructors(item = [], all_instructors = false) {
      var app = this
      app.snackbar = false
      var instructors = [item]
      if (all_instructors) {
        app.reminder_loading = true
        var instructors = Object.assign({}, app.instructors_pendings.items)
      }
      var data = {
        course_id: app.course_id,
        students: instructors
      }
      var url = api_url + 'emails/remind-instructors-pending/'
      app.$http.post(url, data).then(res => {
        app.reminder_loading = false
        app.snackbar = true
        app.snackbar_text = 'Se envió el correo recordatorio al profesor'
        if (all_instructors) {
          app.snackbar_text = 'Se envió el correo recordatorio a los profesores'
        }
        app.snackbar_type = 'primary'
      }, err => {
        app.reminder_loading = false
        app.snackbar = true
        app.snackbar_text = 'Eroare neașteptată, încercați din nou'
        app.snackbar_type = 'error'
      })
    },

    deleteItemConfirm() {
      var app = this
      var id = app.editedItem.user_id;
      var url = api_url + 'course-students/remove-user'
      var data = { course_id: app.course_id, user_id: id }
      console.log(data)
      app.$http.post(url, data).then(res => {
        if (app.editedItem.rol == 'oyente') {
          app.listeners.items.splice(app.editedIndex, 1)
        }
        else {
          app.students_enrolled.items.splice(app.editedIndex, 1)
        }
        app.closeDelete()
      }, err => {
        app.closeDelete()
      })
    },

    closeDelete() {
      this.dialogUserRemove = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    save() {
      var app = this
      var editedIndex = app.editedIndex
      var member = app.editedItem
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

    saveRating() {
      var app = this
      var url = api_url + 'course-ratings/create'
      if (!app.$refs.rating_form.validate()) {
        return false
      }
      else {
        app.rating.form_loading = true
        var data = {
          course_id: app.course_id,
          comment: app.rating.form.comment,
          stars: app.rating.form.stars
        }
        app.$http.post(url, data).then(res => {
          app.rating.form_loading = false
          if (res.body.status == 'success') {
            data.published_at = moment().format('YYYY-MM-DD h:mm:ss')
            data.course_rating_id = res.body.data.course_rating_id
            app.rating.my_rating = data
            app.rating.myCommentIsPublished = true
          }
        }, err => {
          app.rating.form_loading = false
        })
      }
    },

    editMyRating() {
      var app = this
      var url = api_url + 'course-ratings/update'
      app.rating.form_loading = true
      app.rating.form.course_id = app.course_id
      app.$http.post(url, app.rating.form).then(res => {
        app.rating.form_loading = false
        if (res.body.status == 'success') {
          app.rating.my_rating = app.rating.form
          app.rating.myCommentIsPublished = true
        }
      }, err => {
        app.rating.form_loading = false
      })
    },

    deleteRating(item, index) {
      var app = this
      var url = api_url + 'course-ratings/delete'
      app.$http.post(url, { 'course_rating_id': item.course_rating_id }).then(res => {
        if (res.body.status == 'success') {
          app.rating.items.splice(index, 1)
        }
      }, err => {

      })
    },

    deleteMyRating() {
      var app = this
      var url = api_url + 'course-ratings/delete'
      app.$http.post(url, { 'course_rating_id': app.rating.my_rating.course_rating_id }).then(res => {
        if (res.body.status == 'success') {
          app.rating.myCommentIsPublished = false
          app.rating.my_rating = {}
          app.rating.form = Object.assign({}, app.rating.defaultForm)
        }
      }, err => {

      })
    },

    enrollToCourse(course) {
      var app = this
      var url = api_url + 'course-students/enroll-free-course'
      var data = {
        course_id: course,
      }
      app.coupon_loading = true
      app.$http.post(url, data).then(res => {
        app.coupon_loading = false
        app.alert = true
        app.alert_type = res.body.status
        app.alert_message = res.body.message
        if (res.body.status == 'success') {
          location.reload();
        }
      }, err => {
        app.coupon_loading = false
      })
    },

    openTab(tab_element) {
      window.scrollTo(0, this.$refs.tabs_section.$el.scrollWidth)
      this.course_tab = tab_element
    },

    setCookie() {
      var app = this
      let expires = "";
      let date = new Date();
      date.setTime(date.getTime() + 365 * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
      document.cookie = 'modalv1_course_' + app.course_id + "=closed" + expires + "; path=/";
      app.modal_course = false
    },

    validate() {
      this.$refs.form.validate()
    },

    saveFile(url, loading_target) {
      var app = this
      loading_target = loading_target === undefined ? app : loading_target
      var filename = url.substring(url.lastIndexOf("/") + 1).split("?")[0]
      app.$http.get(url, {
        responseType: 'blob',
        progress(e) {
        }
      }).then(res => {
        var a = document.createElement('a');
        a.href = window.URL.createObjectURL(res.body);
        a.download = filename;
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        delete a;
      })
    },

  }
});
