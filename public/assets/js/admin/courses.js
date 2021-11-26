/*
* const vuetify
* const validations
*/
moment.locale('es');
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {     
      previewImage: '',
      loading: false,
      table_loading: false,
      dialog: false,
      dialogDelete: false,
      categoryDialogDelete: false,
      categoryDialog: false,
      subCategoryDialogDelete: false,
      subCategoryDialog: false,
      valid: false,
      validCategory: false,
      validSubCategory: false,
      birthdateDialog: false,
      birthdate_modal: false,
      drawer: true,
      modal: false,
      selectedItem: 4,
      validations,
      levels: [
        {
          text: 'Principiante',
          value: 'principiante'
        },
        {
          text: 'Intermedio',
          value: 'intermedio'
        },
        {
          text: 'Avanzado',
          value: 'avanzado'
        },
      ],
      true_false: [
        {
          text: 'Activo',
          value: '1'
        },
        {
          text: 'Inactivo',
          value: '0'
        },
      ],
      headers: [
        { text: 'Fecha de publicación', align: 'start', value: 'published_at' },
        { text: 'Título del curso', align: 'start', value: 'title' },
        { text: 'Nivel', value: 'level' },
        { text: 'Activo', value: 'active' },
        { text: 'Acciones', value: 'actions', align:'center', sortable: false },
      ],
      courses: [],
      categories: {
        table_loading: false,
        loading: false,
        valid: false,
        items: [],      
        headers: [
          { text: 'Nombre', align: 'start', value: 'name' },
          { text: 'Acciones', value: 'actions', align:'center', sortable: false },
        ],
        editedItem: {
          name: ''
        },
        editedIndex: -1
      },
      subcategories: {
        table_loading: false,
        loading: false,
        valid: false,
        items: [],      
        filtered_items: [],      
        headers: [
          { text: 'Nombre', align: 'start', value: 'name' },
          { text: 'Acciones', value: 'actions', align:'center', sortable: false },
        ],
        editedItem: {
          name: ''
        },
        editedIndex: -1
      },
      editedIndex: -1,
      editedItem: {},
      defaultItem: {
        featured_image: '',
        title: '',
        slug: '',
        price: 0,
        duration: '',
        category_id: null,
        subcategory_id: null,
        duration: '',
        level: 'principiante',
        user_id: '',
        active: '0',
        platform_owner: '0',
        published_at: current_date,
        meta: {},
      },
    },

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Crear curso' : 'Editar curso'
      },

      categoryFormTitle () {
        return this.categories.editedIndex === -1 ? 'Crear categoría' : 'Editar categoría'
      },

      subCategoryFormTitle () {
        return this.categories.editedIndex === -1 ? 'Crear subcategoría' : 'Editar subcategoría'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },


      dialogDelete (val) {
        val || this.closeDelete()
      },

      categoryDialog (val) {
        val || this.closeCategory()
      },

      categoryDialogDelete (val) {
        val || this.closeCategoryDelete()
      },
    },

    created () {
      window.onload = () => {
        check_google_user() 
      }
      this.editedItem = this.defaultItem
      this.initialize()
      this.initializeCategories()
      this.initializeSubCategories()
    },

    mounted () {
    },

    methods: {

      initialize () {
        var url = api_url + 'courses/get'
        this.table_loading = true
        this.$http.get(url).then(res => {
          this.table_loading = false
          this.courses = res.body
        }, err => {

        })
      },

      initializeCategories () {
        var url = api_url + 'categories/get'
        this.categories.table_loading = true
        this.$http.get(url).then(res => {
          this.categories.table_loading = false
          this.categories.items = res.body
        }, err => {

        })
      },

      initializeSubCategories () {
        var url = api_url + 'subcategories/get'
        this.subcategories.table_loading = true
        this.$http.get(url).then(res => {
          this.subcategories.table_loading = false
          this.subcategories.items = res.body
          this.subcategories.filtered_items = res.body
        }, err => {

        })
      },

      editItem (item) {
        this.editedIndex = this.courses.indexOf(item)
        this.editedItem = Object.assign({}, item)
        if (!this.editedItem.meta.hasOwnProperty('description')) {
          this.editedItem.meta.description = ''
        }
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.courses.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        var id = this.editedItem.course_id;
        var url = api_url + 'courses/delete'
        this.$http.post(url, {course_id: id}).then(res => {
            this.courses.splice(this.editedIndex, 1)
            this.closeDelete()
          }, err => {
          this.closeDelete()
        })
      },

      editCategoryItem (item) {
        this.categories.editedIndex = this.categories.items.indexOf(item)
        this.categories.editedItem = Object.assign({}, item)
        this.categoryDialog = true
      },

      deleteCategoryItem (item) {
        this.categories.editedIndex = this.categories.items.indexOf(item)
        this.categories.editedItem = Object.assign({}, item)
        this.categoryDialogDelete = true
      },

      deleteCategoryItemConfirm () {
        var id = this.categories.editedItem.category_id;
        var url = api_url + 'categories/delete'
        this.$http.post(url, {category_id: id}).then(res => {
          if (res.body.status == 'success') {
            this.categories.items.splice(this.categories.editedIndex, 1)
            this.initialize()
          }
            this.closeCategoryDelete()
          }, err => {
          this.closeCategoryDelete()
        })
      },

      editSubCategoryItem (item) {
        this.subcategories.editedIndex = this.subcategories.items.indexOf(item)
        this.subcategories.editedItem = Object.assign({}, item)
        this.subCategoryDialog = true
      },

      deleteSubCategoryItem (item) {
        this.subcategories.editedIndex = this.subcategories.items.indexOf(item)
        this.subcategories.editedItem = Object.assign({}, item)
        this.subCategoryDialogDelete = true
      }, 

      deleteSubCategoryItemConfirm () {
        var id = this.subcategories.editedItem.subcategory_id;
        var url = api_url + 'subcategories/delete'
        this.$http.post(url, {subcategory_id: id}).then(res => {
          if (res.body.status == 'success') {
            this.subcategories.items.splice(this.subcategories.editedIndex, 1)
            this.initialize()
          }
            this.closeSubCategoryDelete()
          }, err => {
          this.closeSubCategoryDelete()
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeCategoryDelete () {
        this.categoryDialogDelete = false
        this.$nextTick(() => {
          this.categories.editedItem = Object.assign({}, {name: ''})
          this.categories.editedIndex = -1
        })
      },

      closeSubCategoryDelete () {
        this.subCategoryDialogDelete = false
        this.$nextTick(() => {
          this.subcategories.editedItem = Object.assign({}, {name: ''})
          this.subcategories.editedIndex = -1
        })
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedItem.featured_image = ''
          this.previewImage = ''
          this.editedItem.meta.description = ''
          this.editedIndex = -1
        })
      },

      closeCategory () {
        this.categoryDialog = false
        this.$nextTick(() => {
          this.categories.editedItem = Object.assign({}, {name: ''})
          this.categories.editedIndex = -1
        })
      },

      closeSubCategory () {
        this.subCategoryDialog = false
        this.$nextTick(() => {
          this.subcategories.editedItem = Object.assign({}, {name: ''})
          this.subcategories.editedIndex = -1
        })
      },

      save () {
        var app = this
        app.loading = true
        var course = app.editedItem
        let data = new FormData()
        data.append('featured_image', course.featured_image)
        data.append('title', course.title)
        data.append('duration', course.duration)
        data.append('price', parseFloat(course.price))
        data.append('category_id', course.category_id)
        data.append('subcategory_id', course.subcategory_id)
        data.append('level', course.level)
        data.append('active', course.active)
        data.append('platform_owner', course.platform_owner)
        data.append('meta', JSON.stringify(course.meta))
        var editedIndex = app.editedIndex
        if (editedIndex > -1) {
          data.append('user_id', course.user_id)
          data.append('course_id', course.course_id)
          var url = api_url + 'courses/update'
          app.$http.post(url, data).then(res => {
            if (res.body.status == "success") {
              course.featured_image = res.body.data.featured_image
              course.slug = res.body.data.slug
              Object.assign(app.courses[editedIndex], course)              
            }
            app.close()
            app.loading = false
          }, err => {
            app.loading = false
          })
        } else {
          var url = api_url + 'courses/create'
          app.$http.post(url, data).then(res => {
            course.date = current_date
            if (res.body.status == 'success') {
              course.course_id = res.body.data.course_id
              course.slug = res.body.data.slug
              course.featured_image = res.body.data.featured_image
              app.courses.push(course)
            }
            app.close()
            app.loading = false
          }, err => {
            app.loading = false
            app.close()
          })
        }
      },

      saveCategory () {
        var app = this
        app.categories.loading = true
        var category = app.categories.editedItem
        var editedIndex = app.categories.editedIndex
        if (editedIndex > -1) {
          var url = api_url + 'categories/update'
          app.$http.post(url, category).then(res => {
            if (res.body.status == "success") {
              Object.assign(app.categories.items[editedIndex], category)              
            }
            app.closeCategory()
            app.categories.loading = false
          }, err => {
            app.categories.loading = false
          })
        } else {
          var url = api_url + 'categories/create'
          app.$http.post(url, category).then(res => {
            if (res.body.status == 'success') {
              category.category_id = res.body.data.category_id
              app.categories.items.push(category)
            }
            app.categories.loading = false
            app.closeCategory()
          }, err => {
            app.categories.loading = false
            app.closeCategory()
          })
        }
      },

      saveSubCategory () {
        var app = this
        app.subcategories.loading = true
        var subcategory = app.subcategories.editedItem
        var editedIndex = app.subcategories.editedIndex
        if (editedIndex > -1) {
          var url = api_url + 'subcategories/update'
          app.$http.post(url, subcategory).then(res => {
            if (res.body.status == "success") {
              Object.assign(app.subcategories.items[editedIndex], subcategory)              
            }
            app.closeSubCategory()
            app.subcategories.loading = false
          }, err => {
            app.subcategories.loading = false
          })
        } else {
          var url = api_url + 'subcategories/create'
          app.$http.post(url, subcategory).then(res => {
            if (res.body.status == 'success') {
              subcategory.subcategory_id = res.body.data.subcategory_id
              app.subcategories.items.push(subcategory)
            }
            app.subcategories.loading = false
            app.closeSubCategory()
          }, err => {
            app.subcategories.loading = false
            app.closeSubCategory()
          })
        }
      },

      prevImage(e){
        const image = e.target.files[0]
        const reader = new FileReader()
        reader.readAsDataURL(image)
        reader.onload = e =>{
            this.editedItem.featured_image = image
            this.previewImage = e.target.result
            this.upload_button = true
        };
      },

      validate () {
        this.$refs.form.validate()
      },

      formatDate (d, f) {
        return moment(d).format(f);
      },

      filterSubcategories () {
       var app = this
       app.$refs.subcategory_select.reset()
       app.editedItem.subcategory_id = ''
       var result = app.subcategories.items.filter( (subcategory) => {
         return subcategory.category_id == app.editedItem.category_id;
       });
       app.subcategories.filtered_items = result
      },

  	}
});