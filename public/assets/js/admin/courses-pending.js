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
      dialogDelete: false,
      modal: false,
      selectedItem: 1,
      snackbar: false,
      snackbar_timeout: 3000,
      snackbar_text: '',
      headers: [
        { text: 'Titlul cursului', value: 'title' },
        { text: 'Lectori', value: 'instructor' },
        { text: 'Acțiuni', value: 'actions', align:'center', sortable: false },
      ],
      courses: [],
      editedIndex: -1,
      editedItem: {},
      defaultItem: {},
    },

    computed: {
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
      this.initialize()
    },

    mounted () {
    },

    methods: {
      initialize () {
        var url = api_url + 'courses/get-pendings'
        this.table_loading = true
        this.$http.get(url).then(res => {
          this.table_loading = false
          this.courses = res.body;
        }, err => {

        })
      },

      updateCourseStatus(status, course) {
        var app = this
        app.snackbar = false

        app.course_status_loading = true
        var url = api_url + 'courses/update-status/'
        app.$http.post(url, { course_id: course.course_id, course_status: status }).then(res => {
          app.course_status_loading = false
          app.snackbar = true
          if (res.body.status == 'success') {
            app.courses.splice(app.courses.indexOf(course), 1)

            var message = `"${course.title}"`
            app.snackbar_text = message += status == 1 ? ' a fost aprobată' : ' a fost dezaprobat'
          } else {
            app.snackbar_text = res.body.message
          }
        }, err => {
          app.course_status_loading = false
        })
      },

  	}
});