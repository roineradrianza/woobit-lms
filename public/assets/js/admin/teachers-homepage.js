/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    search: '',
    snackbar: false,
    snackbar_text: '',
    snackbar_timeout: 3000,
    loading: false,
    table_loading: false,
    drawer: true,
    selectedItem: 3,
    headers: [
      { text: 'Nume și prenume', value: 'full_name' },
      { text: 'Ratinguri medii', align: 'start', value: 'ratings.average' },
      { text: 'Ratinguri totale', value: 'ratings.total' },
    ],
    instructors_selected: [],
    items: [],
    editedIndex: -1,
    search: ''
  },

  computed: {
  },

  created() {
    check_google_user()
    this.editedItem = this.defaultItem
    this.initialize()
  },

  mounted() {
  },

  methods: {
    initialize() {
      var app = this
      var url = api_url + 'teachers/get'
      app.table_loading = true
      app.table_instructors_selected_loading = true

      app.items = []
      app.instructors_selected = []

      app.$http.get(url).then(res => {
        app.items = res.body
      }, err => {
        app.table_loading = false
      }).then( () => {
        url = api_url + 'settings/get/homepage_teachers'
        app.table_instructors_selected_loading = true
        app.$http.get(url).then( res => {
          app.instructors_selected = res.body.hasOwnProperty('value') ? JSON.parse(res.body.value) : []
          app.table_loading = false
          app.table_instructors_selected_loading = false
        })
      }, err => {
        app.table_instructors_selected_loading = false
      })
    },

    save() {
      var app = this
      var data = {
        name: 'homepage_teachers',
        val: app.instructors_selected
      }
      var url = api_url + 'settings/save'
      app.loading = true 
      app.$http.post(url, data).then(res => {
        app.snackbar = true
        app.snackbar_text = res.body.message
        app.loading = false
      }, err => {

      })
    },

  }
});