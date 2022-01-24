
/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    search: '',
    tab: null,
    nav_tab: null,
    loading: false,
    my_courses_loading: false,
    my_orders_loading: false,
    courses_loading: false,
    existsChildCourses: false,
    snackbar: false,
    snackbar_timeout: 4000,
    snackbar_text: '',
    alert: false,
    alert_type: '',
    alert_message: '',
    notifications: [],
    courses: [],
    children: new Children({uid: uid}),
  },

  computed: {
  },

  created() {
    check_google_user()
    this.children.load()
    this.loadLatestCourses()
  },

  watch: {
  },

  mounted() {
  },

  methods: {
    filterLatestCourses(child_id) {
      var app = this
      var children = app.children
      var courses = children.children_courses.filter( (e, i) => e.user_id == child_id)

      courses.length != null && !app.existsChildCourses ? app.existsChildCourses = true : ''

      return courses.length != null ? courses.slice(0, 3) : []
    },

    loadLatestCourses() {
      var app = this
      var url = api_url + 'courses/get'
      app.courses_loading = true
      
      app.$http.get(url).then( res => {
        app.courses_loading = false
        app.courses = res.body
      }, err => {

      })
    }
  }
});