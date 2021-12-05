/*
* const vuetify
* const validations
*/
moment.locale('ru');
/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    previewImage: '',
    course_search: '',
    category_search: '',
    loading: false,
    table_loading: false,
    dialog: false,
    lesson_dialog: false,
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
    zoomDateDialog: false,
    zoomTimeDialog: false,
    zoom_date_modal: false,
    zoom_time_modal: false,
    drawer: true,
    modal: false,
    selectedItem: 4,
    validations,
    percent_loading_active: false,
    percent_loading: 0,
    min_age: 4,
    max_age: 18,
    age_range: [4, 18],
    customToolbar: [
      ["bold", "italic", "underline"],
      [{ list: "ordered" }, { list: "bullet" }],
      [
        { align: "" },
        { align: "center" },
        { align: "right" },
        { align: "justify" }
      ],
    ],
    curriculum: {
      loading: false,
      add_loading: false,
      add_lesson_loading: false,
      add_quiz_loading: false,
      update_section_loading: false,
      update_lesson_loading: false,
      update_lesson_meta_loading: false,
      sections: []
    },
    lessons: {
      loading: false,
      types: [
        {
          text: 'Clasa',
          value: '1'
        },
      ],
      class_types: [
        {
          text: 'Zoom',
          value: 'zoom_meeting'
        },
      ],
      item: {
        quizzes: [],
        meta: {
          class_type: 'zoom_meeting',
          duration: '',
          description: '',
          zoom_agenda: '',
          zoom_duration: '',
          zoom_date: '',
          zoom_time: '',
          zoom_start_time: '',
          zoom_timezone: 'Europe/Bucharest',
          video: undefined,
          poster: undefined,
        }
      },
      itemMetaDefault: {
        class_type: 'zoom_meeting',
        duration: '',
        description: '',
        zoom_agenda: '',
        zoom_duration: '',
        zoom_date: '',
        zoom_time: '',
        zoom_start_time: '',
        zoom_timezone: 'Europe/Bucharest',
        video: undefined,
        poster: undefined,
      },
      editedLessonIndex: -1,
      editedSectionIndex: -1
    },
    true_false: [
      {
        text: 'Activ',
        value: '1'
      },
      {
        text: 'Inactiv',
        value: '0'
      },
    ],
    headers: [
      { text: 'Data creării', align: 'start', value: 'published_at' },
      { text: 'Titlul cursului', align: 'start', value: 'title' },
      { text: 'Preț', value: 'price' },
      { text: 'Stare', value: 'active' },
      { text: 'Acțiuni', value: 'actions', align: 'center', sortable: false },
    ],
    courses: [],
    timezones: [],
    categories: {
      table_loading: false,
      loading: false,
      valid: false,
      items: [],
      headers: [
        { text: 'Denumirea categoriei', align: 'start', value: 'name' },
        { text: 'Acțiuni', value: 'actions', align: 'center', sortable: false },
      ],
      editedItem: {
        name: ''
      },
      editedIndex: -1
    },
    editedIndex: -1,
    editedItem: {
      course_id: undefined,
      featured_image: '',
      new_featured_image: new File([], ''),
      title: '',
      slug: '',
      price: '',
      duration: '',
      category: '',
      category_id: '',
      active: '1',
      min_students: 1,
      max_students: 20,
      min_age: 4,
      max_age: 18,
      meta: {
        description: '',
      },
    },
    defaultItem: {
      course_id: undefined,
      featured_image: '',
      new_featured_image: new File([], ''),
      title: '',
      slug: '',
      price: '',
      duration: '',
      category: '',
      category_id: '',
      active: '1',
      min_students: 1,
      max_students: 20,
      min_age: 4,
      max_age: 18,
      meta: {
        description: '',
      },
    },
  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? 'Adăugați un nou curs' : 'Editare curs'
    },

    categoryFormTitle() {
      return this.categories.editedIndex === -1 ? 'Creați o categorie' : 'Editați categoria'
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },

    dialogDelete(val) {
      val || this.closeDelete()
    },

    categoryDialog(val) {
      val || this.closeCategory()
    },

    categoryDialogDelete(val) {
      val || this.closeCategoryDelete()
    },

    age_range() {
      this.course.min_age = this.age_range[0]
      this.course.max_age = this.age_range[1]
    }
  },

  created() {
    window.onload = () => {
      check_google_user()
    }
    this.initialize()
    this.initializeCategories()
    this.initializeTimezones()
  },

  mounted() {
  },

  methods: {

    initialize() {
      var url = api_url + 'courses/get'
      this.table_loading = true
      this.$http.get(url).then(res => {
        this.table_loading = false
        this.courses = res.body
      }, err => {

      })
    },

    initializeTimezones() {
      var app = this
      var url = domain + '/timezones.min.json'
      app.$http.get(url).then(res => {
        app.timezones = res.body.timezone
      }, err => {

      })
    },

    initializeCategories() {
      var url = api_url + 'categories/get'
      this.categories.table_loading = true
      this.$http.get(url).then(res => {
        this.categories.table_loading = false
        this.categories.items = res.body
      }, err => {

      })
    },

    getCurriculum() {
      var url = api_url + 'course-sections/get'
      this.$http.post(url, {course_id: this.editedItem.course_id}).then(res => {
        this.curriculum.sections = res.body
      }, err => {

      })
    },

    checkSectionMove() {
      var sections = this.curriculum.sections

      sections.forEach((section, i) => {
        section.section_order = i
      });

    },

    checkLessonMove(index) {
      var lessons = this.curriculum.sections[index].items

      lessons.forEach((lesson, i) => {
        lesson.lesson_order = i
      });

    },

    addSection() {
      var app = this
      var id = app.curriculum.sections.length
      var order = id == -1 ? 1 : id
      id++
      var section = {
        section_name: "Secțiunea " + id,
        section_id: undefined,
        section_order: order,
        items: [],
        course_id: undefined
      }
      app.curriculum.sections.push(section);
    },

    addLesson(section_index, item) {
      var app = this
      var section = app.curriculum.sections[section_index]
      var i = section.items.indexOf(item)
      var order = i == -1 ? 0 : i
      var id = section.items.length
      id++
      var lesson = {
        lesson_name: "Clasa " + id,
        old_lesson_name: "Clasa " + i,
        lesson_type: '1',
        lesson_order: order,
        meta: Object.assign({}, app.lessons.itemMetaDefault),
        quizzes: [],
        resources: [],
      }
      app.curriculum.sections[section_index].items.push(lesson);

    },

    updateLessonMeta() {
      var app = this
      var lesson = app.lessons.item
      Object.assign(app.curriculum.sections[app.lessons.editedSectionIndex].items[app.lessons.editedLessonIndex].meta, lesson.meta)
      app.lesson_dialog = false
    },

    openLessonDialog(section_index, item) {
      var app = this
      app.lessons.item = Object.assign({}, item)
      app.lessons.editedLessonIndex = app.curriculum.sections[section_index].items.indexOf(item)
      app.lessons.editedSectionIndex = section_index
      app.lessons.item.meta = item.hasOwnProperty('meta') ? item.meta : app.lessons.itemMetaDefault
      app.lessons.item.quizzes = item.hasOwnProperty('quizzes') ? item.quizzes : []
      app.lesson_dialog = true
    },

    removeSection(item) {
      var app = this
      var id = app.curriculum.sections.indexOf(item)
      app.curriculum.sections.splice(id, 1);
    },

    removeLesson(section_index, item) {
      var app = this
      var section = app.curriculum.sections[section_index]
      var id = app.curriculum.sections[section_index].items.indexOf(item)
      app.curriculum.sections[section_index].items.splice(id, 1);
    },


    editItem(item) {
      this.editedIndex = this.courses.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.editedItem.new_featured_image = new File([], '')
      if (!this.editedItem.meta.hasOwnProperty('description')) {
        this.editedItem.meta.description = ''
      }
      this.getCurriculum()
      this.dialog = true
    },

    deleteItem(item) {
      this.editedIndex = this.courses.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    deleteItemConfirm() {
      var id = this.editedItem.course_id;
      var url = api_url + 'courses/delete'
      this.$http.post(url, { course_id: id }).then(res => {
        this.courses.splice(this.editedIndex, 1)
        this.closeDelete()
      }, err => {
        this.closeDelete()
      })
    },

    editCategoryItem(item) {
      this.categories.editedIndex = this.categories.items.indexOf(item)
      this.categories.editedItem = Object.assign({}, item)
      this.categoryDialog = true
    },

    deleteCategoryItem(item) {
      this.categories.editedIndex = this.categories.items.indexOf(item)
      this.categories.editedItem = Object.assign({}, item)
      this.categoryDialogDelete = true
    },

    deleteCategoryItemConfirm() {
      var id = this.categories.editedItem.category_id;
      var url = api_url + 'categories/delete'
      this.$http.post(url, { category_id: id }).then(res => {
        if (res.body.status == 'success') {
          this.categories.items.splice(this.categories.editedIndex, 1)
          this.initialize()
        }
        this.closeCategoryDelete()
      }, err => {
        this.closeCategoryDelete()
      })
    },

    closeDelete() {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    closeCategoryDelete() {
      this.categoryDialogDelete = false
      this.$nextTick(() => {
        this.categories.editedItem = Object.assign({}, { name: '' })
        this.categories.editedIndex = -1
      })
    },

    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.curriculum.sections = []
        this.editedIndex = -1
      })
    },

    closeCategory() {
      this.categoryDialog = false
      this.$nextTick(() => {
        this.categories.editedItem = Object.assign({}, { name: '' })
        this.categories.editedIndex = -1
      })
    },

    closeSubCategory() {
      this.subCategoryDialog = false
      this.$nextTick(() => {
        this.subcategories.editedItem = Object.assign({}, { name: '' })
        this.subcategories.editedIndex = -1
      })
    },

    save() {
      var app = this
      app.loading = true
      var course = Object.assign({}, app.editedItem)
      var editedIndex = app.editedIndex

      course.section = JSON.stringify(app.curriculum.sections)
      course.meta = JSON.stringify(course.meta)
      let data = new FormData()

      for (var key in course) {
        data.append(key, course[key])
      }

      if (editedIndex > -1) {
        var url = api_url + 'courses/update'
        app.$http.post(url, data).then(res => {
          if (res.body.status == 'success') {
            app.editedItem.featured_image = res.body.data.featured_image
            app.editedItem.slug = res.body.data.slug
            Object.assign(app.courses[editedIndex], app.editedItem)
            app.loading = false
            app.close()
          } else {
            app.loading = false
          }
        }, err => {
          app.loading = false
        })
      }
      else {
        var url = api_url + 'courses/create'
        app.$http.post(url, data).then(res => {
          if (res.body.status == 'success') {
            app.editedItem.date = current_date
            app.editedItem.course_id = res.body.data.course_id
            app.editedItem.slug = res.body.data.slug
            app.editedItem.featured_image = res.body.data.featured_image

            app.courses.push(app.editedItem)
            app.close()
            app.loading = false
          } else {
            app.loading = false
          }
        }, err => {
          app.loading = false
        })
      }
    },

    saveCategory() {
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

    prevImage(e) {
      const image = e.target.files[0]
      const reader = new FileReader()
      reader.readAsDataURL(image)
      reader.onload = e => {
        this.editedItem.featured_image = image
        this.previewImage = e.target.result
        this.upload_button = true
      };
    },

    validate() {
      this.$refs.form.validate()
    },

    formatDate(d, f) {
      return moment(d).format(f);
    },

  }
});