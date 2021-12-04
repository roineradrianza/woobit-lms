/*
* const vuetify
* const vaidations
*/
/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    tab: null,
    nav_tab: null,
    alert: false,
    dialog: false,
    reminder: false,
    loading: false,
    percent_loading_active: false,
    dialog: false,
    valid: false,
    saved: false,
    dialogDelete: false,
    zoomDateDialog: false,
    zoomTimeDialog: false,
    zoom_date_modal: false,
    zoom_time_modal: false,
    modal: false,
    alert_message: '',
    alert_type: '',
    previewImage: '',
    currentImage: '',
    selectedItem: 4,
    percent_loading: 0,
    validations,
    featured_image: '',
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
    notifications: [],
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
    categories: [],
    subcategories: [],
    filtered_subcategories: [],
    timezones: [],
    course: {
      featured_image: new File([], ''),
      title: '',
      slug: '',
      price: '',
      duration: '',
      category: '',
      category_id: '',
      active: 1,
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
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
    dialogDelete(val) {
      val || this.closeDelete()
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
    this.editedItem = this.defaultItem
    this.initializeCategories()
    this.initializeTimezones()
  },

  mounted() {
    this.reminder = true
  },

  methods: {

    initializeCategories() {
      var url = api_url + 'categories/get'
      this.categories_loading = true
      this.$http.get(url).then(res => {
        this.categories_loading = false
        this.categories = res.body
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

    save() {
      var app = this
      app.loading = true
      var course = Object.assign({}, app.course)
      course.section = JSON.stringify(app.curriculum.sections)
      course.meta = JSON.stringify(course.meta)
      let data = new FormData()

      for (var key in course) {
        data.append(key, course[key])
      }

      var url = api_url + 'courses/create'
      app.$http.post(url, data).then(res => {
        if (res.body.status == 'success') {
          app.response(res.body.status, res.body.message)
          app.saved = true
          app.course.slug = res.body.data.slug
        } else {
          app.loading = false
        }
      }, err => {
        app.response('error')
      })
    },

    prevImage(e) {
      const image = e.target.files[0]
      const reader = new FileReader()
      reader.readAsDataURL(image)
      reader.onload = e => {
        this.course.featured_image = image
        this.previewImage = e.target.result
      };
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

    resetImage() {
      var app = this
      app.previewImage = app.currentImage
      app.course.featured_image = app.currentImage
    },

    filterSubcategories() {
      var app = this
      app.$refs.subcategory_select.reset()
      app.course.subcategory_id = ''
      var result = app.subcategories.filter((subcategory) => {
        return subcategory.category_id == app.course.category_id;
      });
      app.filtered_subcategories = result
    },

    getCategory(id) {
      var app = this
      var result = app.categories.filter((e) => {
        return e.category_id == id;
      });
      if (result.length > 0) {
        return result[0].name;
      }
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
      app.dialog = false
    },

    openLessonDialog(section_index, item) {
      var app = this
      app.lessons.item = Object.assign({}, item)
      app.lessons.editedLessonIndex = app.curriculum.sections[section_index].items.indexOf(item)
      app.lessons.editedSectionIndex = section_index
      app.lessons.item.meta = item.hasOwnProperty('meta') ? item.meta : app.lessons.itemMetaDefault
      app.lessons.item.quizzes = item.hasOwnProperty('quizzes') ? item.quizzes : []
      app.dialog = true
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

    removeResource(resource, index) {
      var app = this
      app.lessons.item.resources.splice(index, 1)
    },

    getExt(file_name) {
      var url = file_name
      var splitted_url = url.split('/')
      var ext = splitted_url[splitted_url.length - 1].split('.')
      return ext[1]
    },

    response(type = '', message = '') {
      this.loading = false
      this.alert = true
      this.alert_type = type
      this.alert_message = type == 'error' ? message == '' ? 'A apărut o eroare neașteptată, vă rugăm să încercați din nou.' : message : message
    },

    close() {
      this.$nextTick(() => {
        this.alert = false
        this.lessons.item.meta = Object.assign({}, this.lessons.itemMetaDefault)
      })
    }

  }
});
