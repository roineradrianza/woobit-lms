Vue.use(VueTelInputVuetify, {
  vuetify,
});
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
    valid: false,
    dialogDelete: false,
    modal: false,
    validations,
    selectedItem: 2,
    status: [
      {
        text: 'Prelucrare',
        value: '0'
      },
      {
        text: 'Aprobat',
        value: '1'
      },
      {
        text: 'Respins',
        value: '3'
      }
    ],
    headers: [
      { text: 'Data', value: 'created_at' },
      { text: 'Nume și prenume', align: 'start', value: 'full_name' },
      { text: 'status', value: 'status_text' },
      { text: 'Acțiuni', value: 'actions', align: 'center', sortable: false },
    ],
    items: [],
    editedIndex: -1,
    min: 4,
    max: 18,
    range: [4, 18],
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
    search: '',
    editedItem: {
      application_id: Number,
      first_name: '',
      last_name: '',
      id_file: undefined,
      video_file: undefined,
      status: -1,
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
        min_students_age: 4,
        max_students_age: 18
      }
    },
    defaultItem: {
      application_id: Number,
      first_name: '',
      last_name: '',
      id_file: undefined,
      video_file: undefined,
      status: -1,
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
        min_students_age: 4,
        max_students_age: 18
      }
    },
  },

  computed: {
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
    dialogDelete(val) {
      val || this.closeDelete()
    },
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
      var url = api_url + 'applications/get'
      app.list_loading = true

      app.$http.get(url).then(res => {
        app.list_loading = false
        res.body.forEach(application => {
          application.full_name = application.first_name + ' ' + application.last_name
          application.status_text = app.getStatusText(application.status)
        });
        app.items = res.body
      }, err => {
        app.list_loading = false
      })
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem(item) {
      this.editedIndex = this.items.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    deleteItemConfirm() {
      var id = this.editedItem.user_id;
      var url = api_url + 'items/delete'
      this.$http.post(url, { user_id: id }).then(res => {
        this.items.splice(this.editedIndex, 1)
        this.closeDelete()
      }, err => {
        this.closeDelete()
      })
    },

    closeDelete() {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    save() {
      var app = this
      var editedIndex = app.editedIndex
      var application = app.editedItem
      application.full_name = application.first_name + ' ' + application.last_name
      var url = api_url + 'applications/update'
      app.$http.post(url, application).then(res => {
        if (res.body.status == "success") {
          application.status_text = app.getStatusText(application.status)
          Object.assign(app.items[editedIndex], application)
        }
        app.close()
      }, err => {

      })
    },

    getStatusText(val) {
      var item = this.status.find(e => e.value == val)
      return item != null ? item.text : ''
    },

    getStatusType(val) {
      var item = this.status.find(e => e.value == val)
      var type = 'info'
      if (item != null) {
        switch (item.value) {
          case '0':
            type = "warning"
            break;

          case '1':
            type = "success"
            break;

          case '3':
            type = "error"
            break;
        }
      }
      return type
    },

    getInput(text, data) {
      this.telephone = data.number.international
    },

  }
});