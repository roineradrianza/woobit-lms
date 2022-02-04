let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    notifications: [],
    tab: null,
    nav_tab: null,
    course_id: null,
    course_status: null,
    course_status_loading: false,
    rating: null,
  },

  computed: {
  },

  watch: {
  },

  created() {
    check_google_user()
  },

  mounted() {
    var app = this
    app.course_id = this.$refs.course_container.getAttribute('course_id')
    app.rating = new Rating({course_id: app.course_id})
    if (app.$refs.hasOwnProperty('alert_course_status')) {
      app.course_status = app.$refs.alert_course_status.getAttribute('initial-status')
    }
  },

  methods: {

    updateCourseStatus(status) {
      var app = this
      app.course_status_loading = true
      var url = api_url + 'courses/update-status/' + app.course_id
      app.$http.post(url, { course_status: status }).then(res => {
        app.course_status_loading = false
        if (res.body.status == 'success') {
          app.course_status = status
        }
      }, err => {
        app.course_status_loading = false
      })
    },

    getCourseStatusColor() {
      switch (this.course_status) {
        case '2':
          return 'warning'
          break
      
        case '1':
          return 'success'
          break
              
        case '0':
          return 'error'
          break
      }
    },

  }
});
