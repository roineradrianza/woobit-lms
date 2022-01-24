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
        { text: 'Clasa', align: 'start', value: 'lesson_name' },
        { text: 'Titlul cursului', value: 'title' },
        { text: 'Lectori', value: 'instructor' },
        { text: 'Acțiuni', value: 'actions', align:'center', sortable: false },
      ],
      lessons: [],
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
        var url = api_url + 'lessons/get-pendings'
        this.table_loading = true
        this.$http.get(url).then(res => {
          this.table_loading = false
          this.lessons = res.body;
        }, err => {

        })
      },

      updateLessonStatus(status, lesson) {
        var app = this
        app.snackbar = false

        app.lesson_status_loading = true
        var url = api_url + 'lessons/update-status/'
        app.$http.post(url, { lesson_id: lesson.lesson_id, lesson_status: status }).then(res => {
          app.lesson_status_loading = false
          app.snackbar = true
          if (res.body.status == 'success') {
            app.lessons.splice(app.lessons.indexOf(lesson), 1)

            var message = `"${lesson.lesson_name}"`
            app.snackbar_text = message += status == 1 ? ' a fost aprobată' : ' a fost dezaprobat'
          } else {
            app.snackbar_text = res.body.message
          }
        }, err => {
          app.lesson_status_loading = false
        })
      },

  	}
});