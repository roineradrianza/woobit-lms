/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#full-learning-container',
    data: {
      alert: false,
      loading: false,
      courses_loading: false,
      students_loading: false,
      coupons_table_loading: false,
      send_loading: false,
      dialog: false,
      valid: false,
      dialogDelete: false,
      modal: false,
      drawer: true,
      openList: false,
      emailFieldActivate: false,
      selectedItem: 7,
      optionSelected: -1,
      userOptionSelected: -1,
      alert_message: '',
      alert_type: '',
      new_email: '',
      userRolOptionSelected: '',
      studentsSelected: [],
      course: {},
      email: {
        title: '',
        content: '',
        attachment: undefined,
      },
      user_xlsx: undefined,
      customToolbar: [
        [{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
        ["bold", "italic", "underline"],
        [{ list: "ordered" }, { list: "bullet" }],
        ["link", "code-block", "strike"],
      ],
      coupon_selected: [],
      email_options: [
        {
          text: 'Cupones de descuento autogenerados',
          value: 0
        },
        {
          text: 'Correo personalizado',
          value: 1
        },
        {
          text: 'Enviar certificados',
          value: 2
        },
      ],
      user_options: [
        {
          text: 'Selección por rol',
          value: 0
        },
        {
          text: 'Selección personalizada',
          value: 1
        },
        {
          text: 'Archivo de excel con correos electrónicos',
          value: 2
        },
      ],
      rol_options: [
        {
          text: 'Estudiante',
          value: 'student'
        },
        {
          text: 'Estudiante de medicina',
          value: 'medicine_student'
        },
        {
          text: 'Profesor de medicina',
          value: 'medicine_teacher'
        },
      ],
      courses: [],
      students: [],
      students_list: [],
      students_excel: [],
      headers: [
        { text: 'Nombre del cupón', align: 'start', value: 'coupon_name' },
        { text: 'Rol del usuario', value: 'student_rol' },
        { text: 'Descuento', value: 'discount' },
      ],
      coupons: [],
      editedIndex: -1,
      editedItem: {},
      defaultItem: {
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

      optionSelected (val) {
        this.alert = false
        this.studentsSelected = []
        this.students_excel = []
        if (this.userRolOptionSelected != '') {
          this.filterByRol()
        }
      },

      userOptionSelected () {
        this.students = this.students_list
      },

      coupon_selected (val) {
        this.openList = val.length > 0 ? true : false
      },

      userRolOptionSelected (val) {
        this.filterByRol()
      },

      studentsSelected (val) {
        this.emailFieldActivate = val.length > 0 ? true : false
      },

      students_excel (val) {
        this.emailFieldActivate = val.length > 0 ? true : false
      },

    },

    created () {
      check_google_user()
      this.editedItem = this.defaultItem
      this.loadCourses()
      this.loadStudents()
    },

    mounted () {
    },

    methods: {

      loadCoupons () {
        var url = api_url + 'coupons/get-by-course/' + this.course.course_id
        this.coupons_table_loading = true
        this.coupon_selected = []
        this.$http.get(url).then(res => {
          this.coupons_table_loading = false
          this.coupons = res.body;
        }, err => {

        })
      },

      loadCourses() {
        var url = api_url + 'courses/get-courses'
        this.courses_loading = true
        this.$http.get(url).then(res => {
          this.courses_loading = false
          if (res.body.length > 0) {
            this.courses = res.body;
          }
        }, err => {

        })    
      },

      loadStudents() {
        var url = api_url + 'members/get-by-members'
        this.students_loading = true
        this.$http.get(url).then(res => {
          this.students_loading = false
          if (res.body.length > 0) {
            this.students = res.body;
            this.students_list = res.body;
          }
        }, err => {

        })    
      },

      sendCoupons () {
        var app = this
        app.send_loading = true
        app.alert = false
        var data = {
          course: app.course,
          coupon: app.coupon_selected[0],
          title: app.email.title,
          content: app.email.content,
          attachment: app.email.attachment,
        }
        var info = {
          course: app.course,
          coupon: app.coupon_selected[0],
          title: app.email.title,
          content: app.email.content,
          attachment: app.email.attachment,
        }
        if (app.userOptionSelected == 2) {
          info.students = app.students_excel
        }
        else{
          info.students = app.studentsSelected
        }
        var data = new FormData()
        data.append('course', JSON.stringify(info.course))
        data.append('students', JSON.stringify(info.students))
        data.append('coupon', JSON.stringify(info.coupon))
        data.append('title', info.title)
        data.append('content', info.content)
        data.append('attachment', info.attachment)
        if (app.userOptionSelected == 2) {
          data.students = app.students_excel
          var url = api_url + 'emails/send-coupons-codes-and-register'
        }
        else{
          data.students = app.studentsSelected
          var url = api_url + 'emails/send-coupons-codes'
        }
        app.$http.post(url, data).then(res => {
          app.alert = true
          app.alert_message = res.body.message
          app.alert_type = res.body.status
          if (res.body.data.errors.length > 0) {
            app.alert_message += '<p>Se encontraron los siguientes problemas:</p>'
            res.body.data.errors.forEach( ( err) => {
              app.alert_message += `<p>${err}</p>`
            });
            app.alert_type = "warning"
          }
          app.send_loading = false
        }, err => {
          app.send_loading = false
        })
      },

      sendCustomEmail () {
        var app = this
        app.send_loading = true
        app.alert = false
        var info = {
          course: app.course,
          students: [],
          title: app.email.title,
          content: app.email.content,
          attachment: app.email.attachment,
        }
        if (app.userOptionSelected == 2) {
          info.students = app.students_excel
        }
        else{
          info.students = app.studentsSelected
        }
        var data = new FormData()
        data.append('course', JSON.stringify(info.course))
        data.append('students', JSON.stringify(info.students))
        data.append('title', info.title)
        data.append('content', info.content)
        data.append('attachment', info.attachment)
        var url = api_url + 'emails/send-custom-email'
        app.$http.post(url, data).then(res => {
          app.alert = true
          app.alert_message = res.body.message
          app.alert_type = res.body.status
          if (res.body.data.errors.length > 0) {
            app.alert_message += '<p>Se encontraron los siguientes problemas:</p>'
            res.body.data.errors.forEach( ( err) => {
              app.alert_message += `<p>${err}</p>`
            });
            app.alert_type = "warning"
          }
          app.send_loading = false
        }, err => {
          app.send_loading = false
        })
      },

      sendCertifiedEmail () {
        var app = this
        app.send_loading = true
        app.alert = false
        var url = api_url + 'emails/send-certifieds'
        var info = {
          course: app.course,
          title: app.email.title,
          content: app.email.content,
          attachment: app.email.attachment,
        }
        if (app.userOptionSelected == 2) {
          info.students = app.students_excel
        }
        else{
          info.students = app.studentsSelected
        }
        var data = new FormData()
        data.append('course', JSON.stringify(info.course))
        data.append('title', info.title)
        data.append('content', info.content)
        data.append('students', JSON.stringify(info.students))
        data.append('attachment', info.attachment)
        app.$http.post(url, data).then(res => {
          app.alert = true
          app.alert_message = res.body.message
          app.alert_type = res.body.status
          if (res.body.data.errors.length > 0) {
            app.alert_message += '<p>Se encontraron los siguientes problemas:</p>'
            res.body.data.errors.forEach( ( err) => {
              app.alert_message += `<p>${err}</p>`
            });
            app.alert_type = "warning"
          }
          app.send_loading = false
        }, err => {
          app.send_loading = false
        })
      },

      filterByRol() {
        var app = this
        if (app.userRolOptionSelected != '') {
          var results = app.students.filter( (student) => {
            return student.meta.student_type == app.userRolOptionSelected
          });
          app.studentsSelected = results
        }
      },

      displayItem(item) {
         if (item.hasOwnProperty('first_name') || item.hasOwnProperty('last_name')) {
          return item.first_name + ' ' + item.last_name
         }
         else {
          return item.email
         }
      },

      addEmail() {
        var app = this
        app.students.push({'email': app.new_email})
        app.studentsSelected.push({'email': app.new_email})
      },

      readStudentsXLSX (e) {
        var app = this
        const reader = new FileReader()
        if (typeof undefined !== app.user_xlsx) {
          reader.readAsBinaryString(app.user_xlsx)
          reader.onload = e =>{
            const header = ['full_name', 'email']
            var data = e.target.result
            var workbook = XLSX.read(data, {type: 'binary'});
            var Sheet = workbook.SheetNames[0]
            var students = XLSX.utils.sheet_to_json(workbook.Sheets[Sheet], {header: header})
            app.students_excel = students.splice(1, students.length)
          };
        }
      },

      validate () {
        this.$refs.form.validate()
      },

    }
});