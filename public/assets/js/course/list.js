/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#full-learning-container',
    data: {
      loading: false,
      table_loading: false,
      dialog: false,
      valid: false,
      dialogDelete: false,
      modal: false,
      headers: [
        { text: 'Nombre completo', align: 'start', value: 'full_name' },
        { text: 'Correo electrónico', value: 'email' },
        { text: 'Provincia / País', value: 'location' },
        { text: 'Teléfono', value: 'telephone' },
        { text: 'Acciones', value: 'actions', align:'center', sortable: false },
      ],
      students_enrolled: [],
      editedIndex: -1,
      editedItem: {},
      defaultItem: {
      },
    },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Registrar usuario' : 'Editar usuario'
      },
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
      this.loadCountries()
      this.initialize()
    },

    mounted () {
    },

    methods: {
      initialize () {
        var url = api_url + 'members/get-students'
        this.table_loading = true
        this.$http.get(url).then(res => {
          this.table_loading = false
          this.members = res.body;
        }, err => {

        })
      },

      editItem (item) {
        this.editedIndex = this.members.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.members.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        var id = this.editedItem.user_id;
        var url = api_url + 'members/delete'
        this.$http.post(url, {user_id: id}).then(res => {
            this.members.splice(this.editedIndex, 1)
            this.closeDelete()
          }, err => {
          this.closeDelete()
        })
      }, 

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
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


     validate () {
        this.$refs.form.validate()
      },

  	}
});