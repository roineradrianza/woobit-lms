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
    if (this.$refs.hasOwnProperty('alert_course_status')) {
      this.course_status = this.$refs.alert_course_status.getAttribute('initial-status')
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
