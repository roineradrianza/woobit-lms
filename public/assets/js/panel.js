
/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    search: '',
    tab: null,
    nav_tab: null,
    loading: false,
    avatar_loading: false,
    edit_profile_loading: false,
    my_courses_loading: false,
    my_orders_loading: false,
    new_courses_loading: false,
    snackbar: false,
    snackbar_timeout: 4000,
    snackbar_text: '',
    alert: false,
    alert_type: '',
    alert_message: '',
    notifications: [],
    my_courses: [],
    children: new Children({uid: uid}),
  },

  computed: {
  },

  created() {
    check_google_user()
    this.children.load()
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
      return courses.length != null ? courses.slice(0, 3) : []
    }
  }
});