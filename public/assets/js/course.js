let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    notifications: [],
    tab: null,
    nav_tab: null,
    course_id: null,
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
  },

  methods: {

  }
});
