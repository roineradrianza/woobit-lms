/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {
      loading: false,
      table_loading: false,
      courses_loading: false,
      dialog: false,
      valid: false,
      dialogDelete: false,
      modal: false,
      drawer: true,
      selectedItem: 5,
      rol_options: [
        {
          text: 'Estudiante',
          value: 'estudiante'
        },
        {
          text: 'Residente',
          value: 'residente'
        },
        {
          text: 'Profesor',
          value: 'profesor'
        },
        {
          text: 'Oyente',
          value: 'oyente'
        },
      ],
      courses: [],
      validations,
      headers: [
        { text: 'Nombre del cupón', align: 'start', value: 'coupon_name' },
        { text: 'Rol del usuario', value: 'student_rol' },
        { text: 'Descuento', value: 'discount' },
        { text: 'Acciones', value: 'actions', align:'center', sortable: false },
      ],
      coupons: [],
      editedIndex: -1,
      editedItem: {},
      defaultItem: {
        coupon_name: '',
        student_rol: 'estudiante',
        discount: '',
        course_id: '',
        coupon_id: '',
      },
    },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Crear cupón' : 'Modificar cupón'
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
      this.loadCourses()
      this.initialize()
    },

    mounted () {
    },

    methods: {
      initialize () {
        var url = api_url + 'coupons/get'
        this.table_loading = true
        this.$http.get(url).then(res => {
          this.table_loading = false
          this.coupons = res.body;
        }, err => {

        })
      },

      loadCourses() {
        var url = api_url + 'courses/get-courses'
        this.courses_loading = true
        this.$http.get(url).then(res => {
          this.courses_loading = false
          var courses = []
          if (res.body.length > 0) {
            this.courses = res.body;
          }
        }, err => {

        })    
      },

      editItem (item) {
        this.editedIndex = this.coupons.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.coupons.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        var id = this.editedItem.coupon_id;
        var url = api_url + 'coupons/delete'
        this.$http.post(url, {coupon_id: id}).then(res => {
          if (res.body.status == 'success') {
            this.coupons.splice(this.editedIndex, 1)
          }
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
        var coupon = app.editedItem
        if (app.editedIndex > -1) {
          var url = api_url + 'coupons/update'
          app.$http.post(url, coupon).then(res => {
            if (res.body.status == "success") {
              Object.assign(app.coupons[editedIndex], coupon)              
            }
            app.close()
          }, err => {

          })
        } else {
          var url = api_url + 'coupons/create'
          app.$http.post(url, coupon).then(res => {
            if (res.body.status == 'success') {
              coupon.coupon_id = res.body.data.coupon_id
              app.coupons.push(coupon)
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