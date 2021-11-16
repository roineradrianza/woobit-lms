/*
* const vuetify
* const validations
*/
/*VUE INSTANCE*/
const splitted_domain = window.location.href.split('/')
const course_id = splitted_domain[5]
let vm = new Vue({
  vuetify,
  el: '#full-learning-container',
  data: {
    tab: null,
    nav_tab: null,
    alert: false,
    dialog: false,
    reminder: false,
    loading: false,
    page_loading: false,
    image_loading: false,
    general_loading: false,
    setup_loading: false,
    image_certified_by_loading: false,
    percent_loading_active: false,
    dialog: false,
    valid: false,
    dialogDelete: false,
    birthdateDialog: false,
    zoomDateDialog: false,
    zoomTimeDialog: false,
    streamingTimeDialog: false,
    streamingDateDialog: false,
    birthdate_modal: false,
    zoom_date_modal: false,
    zoom_time_modal: false,
    streaming_time_modal: false,
    streaming_date_modal: false,
    drawer: true,
    modal: false,
    alert_message: '',
    alert_type: '',
    previewImage: '',
    previewCertifiedBy: '',
    currentImage: '',
    currentCertifiedBy: '',
    selectedItem: 4,
    percent_loading: 0,
    validations,
    featured_image: '',
    certified_by: '',
    faq: {
      add_loading: false,
      items: [],
      customToolbar: [
        ["bold", "italic", "underline"],
        [{ list: "ordered" }, { list: "bullet" }],
      ],
    },
    curriculum: {
      loading: false,
      add_loading: false,
      add_lesson_loading: false,
      add_quiz_loading: false,
      update_section_loading: false,
      update_lesson_loading: false,
      update_lesson_meta_loading: false,
      sections: [],
      customToolbar: [
        ["bold", "italic", "underline"],
        [{ list: "ordered" }, { list: "bullet" }],
      ],
    },
    notifications: [],
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
    lessons: {
      loading: false,
      quiz_options: [
        {
          text: 'Selección simple',
          value: '1',
        },
        {
          text: 'Verdadero o Falso',
          value: '2',
        },
        {
          text: 'Completación',
          value: '3',
        },
      ],
      types: [
        {
          text: 'Clase',
          value: '1'
        },
        {
          text: 'Quiz',
          value: '2'
        },
        {
          text: 'Actividades',
          value: '3'
        },
        {
          text: 'Recursos',
          value: '4'
        },
      ],
      class_types: [
        {
          text: 'Video',
          value: 'video'
        },
        {
          text: 'Zoom',
          value: 'zoom_meeting'
        },
        {
          text: 'Streaming',
          value: 'streaming'
        },
      ],
      item: {
        quizzes: [],
        meta: {
          class_type: '',
          duration: '',
          description: '',
          zoom_agenda: '',
          zoom_duration: '',
          zoom_date: '',
          zoom_time: '',
          zoom_start_time: '',
          zoom_timezone: '',
          video: undefined,
          poster: undefined,
        }
      },
      itemMetaDefault: {
        class_type: '',
        duration: '',
        description: '',
        zoom_description: '',
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
      featured_image: '',
      title: '',
      slug: '',
      price: '',
      duration: '',
      category: '',
      level: '',
      user_id: '',
      active: 0,
      course_id,
      meta: {
        description: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa sunt aspernatur eveniet cupiditate soluta architecto ducimus, fuga. Quo voluptatem eligendi, harum eius nostrum veniam minima iste illo explicabo adipisci, voluptate!',
        certified_by: '',
        instructors: []
      },
    },
    instructors: {
      loading: false,
      instructors_loading: false,
      add_loading: false,
      searched: false,
      alert: false,
      alert_type: '',
      alert_message: '',
      user_selected: '',
      items: [],
      users: [],
      username_search: '',
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
    window.onload = () => {
      check_google_user()
    }
    this.editedItem = this.defaultItem
    this.initialize()
    this.initializeCategories()
    this.initializeSubCategories()
    this.initializeTimezones()
  },

  mounted() {
    this.reminder = true
  },

  methods: {

    initialize() {
      var url = api_url + 'courses/get/' + this.course.course_id
      this.page_loading = true
      this.$http.get(url).then(res => {
        this.page_loading = false
        this.course = res.body[0]
        this.getInstructors()
        if (this.course.meta.hasOwnProperty('certified_by')) {
          this.currentCertifiedBy = this.course.meta.certified_by
          this.previewCertifiedBy = this.course.meta.certified_by
        }
        if (this.course.meta.hasOwnProperty('faq')) {
          this.course.meta.faq = JSON.parse(this.course.meta.faq)
          this.faq.items = this.course.meta.faq
        }
        this.currentImage = this.course.featured_image
        this.previewImage = this.currentImage
        this.getSections()
      }, err => {

      })
    },

    initializeCategories() {
      var url = api_url + 'categories/get'
      this.categories_loading = true
      this.$http.get(url).then(res => {
        this.categories_loading = false
        this.categories = res.body
      }, err => {

      })
    },

    initializeSubCategories() {
      var url = api_url + 'subcategories/get'
      this.subcategories_loading = true
      this.$http.get(url).then(res => {
        this.subcategories_loading = false
        this.subcategories = res.body
        this.filtered_subcategories = res.body
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

    getInstructors() {
      var app = this
      var url = api_url + 'courses/get-instructors/' + app.course.course_id
      app.$http.get(url).then(res => {
        app.instructors.items = res.body
      }, err => {

      })
    },

    getSections() {
      var app = this
      var data = { course_id: app.course.course_id }
      var url = api_url + 'course-sections/get'
      app.$http.post(url, data).then(res => {
        if (res.body != {}) {
          res.body.forEach((section, section_index) => {
            if (res.body[section_index].items.length > 0) {
              res.body[section_index].items.forEach((lesson, section_index) => {
                if (Array.isArray(lesson.meta)) {
                  lesson.meta = {}
                }
                lesson.resources.forEach((resource, resource_index) => {
                  resource.loading = false
                  resource.percent_loading_active = false
                  resource.percent_loading = 0
                })
              })
            }
          })
        }
        app.curriculum.sections = res.body
      }, err => {

      })
    },

    searchUser() {
      var app = this
      var url = api_url + 'members/search-user/' + app.instructors.username_search
      app.instructors.alert = false
      app.instructors.searched = false
      app.instructors.user_selected = ''
      app.instructors.loading = true
      app.$http.get(url).then(res => {
        app.instructors.loading = false
        app.instructors.searched = true
        app.instructors.users = res.body
      }, err => {

      })
    },

    saveGeneral() {
      var app = this
      app.general_loading = true
      var course = app.course
      let data = new FormData()
      data.append('featured_image', course.featured_image)
      data.append('title', course.title)
      data.append('duration', course.duration)
      data.append('price', parseFloat(course.price))
      data.append('level', course.level)
      data.append('active', course.active)
      data.append('meta', JSON.stringify(course.meta))
      data.append('user_id', course.user_id)
      data.append('platform_owner', course.platform_owner)
      data.append('course_id', course.course_id)
      data.append('category_id', course.category_id)
      data.append('subcategory_id', course.subcategory_id)
      var url = api_url + 'courses/update'
      app.$http.post(url, data).then(res => {
        if (res.body.status == "success") {
          app.course.slug = res.body.data.slug
        }
        app.general_loading = false
      }, err => {
        app.general_loading = false
      })
    },

    saveSetup() {
      var app = this
      app.setup_loading = true
      var course = app.course
      let data = new FormData()
      var meta = {
        zoom_jwt: course.meta.zoom_jwt,
        zoom_host: course.meta.zoom_host,
      }
      data.append('meta', JSON.stringify(meta))
      data.append('course_id', course.course_id)
      var url = api_url + 'courses/update-meta'
      app.$http.post(url, data).then(res => {
        if (res.body.status == "success") {
        }
        app.setup_loading = false
      }, err => {
        app.setup_loading = false
      })
    },

    saveInstructor() {
      var app = this
      app.instructors.alert = false
      if (app.checkInstructor(app.instructors.user_selected)) {
        app.instructors.alert = true
        app.instructors.alert_message = 'El usuario ya se encuentra añadido como profesor'
        app.instructors.alert_type = 'warning'
      }
      else {
        app.instructors.add_loading = true
        var url = api_url + 'courses/add-instructor'
        var data = { course_id: app.course.course_id, user_id: app.instructors.user_selected.user_id }
        app.$http.post(url, data).then(res => {
          if (res.body.status == "success") {
            app.instructors.items.push(app.instructors.user_selected)
          }
          app.instructors.add_loading = false
        }, err => {
          app.instructors.add_loading = false
        })
      }
    },

    saveFAQ() {
      var app = this
      app.faq.add_loading = true
      var url = api_url + 'courses/update-meta'
      let data = new FormData()
      data.append('course_id', app.course.course_id)
      data.append('meta', JSON.stringify({ faq: app.faq.items }))
      app.$http.post(url, data).then(res => {
        app.faq.add_loading = false
      }, err => {
        app.faq.add_loading = false
      })
    },

    checkInstructor(user) {
      var app = this
      var result = app.instructors.items.filter((item) => {
        return item.user_id == user.user_id;
      });
      if (result.length > 0) {
        return true
      }
      return false
    },

    removeInstructor(item) {
      var app = this
      app.instructors.add_loading = true
      var url = api_url + 'courses/remove-instructor';
      var index = app.instructors.items.indexOf(item)
      var data = { course_id: app.course.course_id, user_id: item.user_id }
      app.$http.post(url, data).then(res => {
        if (res.body.status == "success") {
          app.instructors.items.splice(index, 1)
        }
        app.instructors.add_loading = false
      }, err => {
        app.instructors.add_loading = false
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

    prevCertifiedByImage(e) {
      const image = e.target.files[0]
      const reader = new FileReader()
      reader.readAsDataURL(image)
      reader.onload = e => {
        this.course.meta.certified_by = image
        this.previewCertifiedBy = e.target.result
      };
    },

    resetImage() {
      var app = this
      app.previewImage = app.currentImage
      app.course.featured_image = app.currentImage
    },

    resetCertifiedByImage() {
      var app = this
      if (app.currentCertifiedBy != '') {
        app.previewCertifiedBy = app.currentCertifiedBy
        app.course.meta.certified_by = app.currentCertifiedBy
      }
      else {
        app.previewCertifiedBy = ''
      }
    },

    saveFeaturedImage() {
      var app = this
      app.image_loading = true
      var course = app.course
      let data = new FormData()
      data.append('featured_image', course.featured_image)
      data.append('slug', course.slug)
      data.append('course_id', course.course_id)
      var url = api_url + 'courses/update-cover'
      app.$http.post(url, data).then(res => {
        if (res.body.status == "success") {
          app.currentImage = res.body.data.featured_image
          app.course.featured_image = res.body.data.featured_image
        }
        app.image_loading = false
      }, err => {
        app.image_loading = false
      })
    },

    saveCertifiedByImage() {
      var app = this
      app.image_certified_by_loading = true
      var course = app.course
      let data = new FormData()
      data.append('certified_by_image', course.meta.certified_by)
      data.append('slug', course.slug)
      data.append('course_id', course.course_id)
      var url = api_url + 'courses/update-certified-by'
      app.$http.post(url, data).then(res => {
        if (res.body.status == "success") {
          app.currentCertifiedBy = res.body.data.certified_by_image
          app.course.meta.certified_by = res.body.data.certified_by_image
        }
        app.image_certified_by_loading = false
      }, err => {
        app.image_certified_by_loading = false
      })
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

    getSubCategory(id) {
      var app = this
      var result = app.subcategories.filter((e) => {
        return e.subcategory_id == id;
      });
      if (result.length > 0) {
        return ' / ' + result[0].name;
      }
    },

    addFAQ() {
      var app = this
      var id = app.faq.items.length
      id++
      app.faq.items.push({ name: "", id, text: "" });
    },

    addSection() {
      var app = this
      app.curriculum.add_loading = true
      var id = app.curriculum.sections.length
      var order = id == -1 ? 0 : id
      id++
      var section = {
        section_name: "Sección " + id,
        section_id: id,
        section_order: order,
        items: [],
        course_id: app.course.course_id
      }
      var url = api_url + 'course-sections/create'
      app.$http.post(url, section).then(res => {
        if (res.body.status == 'success') {
          section.section_id = res.body.data.section_id
          section.old_section_name = section.section_name
          section.old_section_order = section.section_order
          app.curriculum.sections.push(section);
        }
        app.curriculum.add_loading = false
      }, err => {
        app.curriculum.add_loading = false
      })
    },

    updateSection(item) {
      var app = this
      app.curriculum.update_section_loading = true
      var order = app.curriculum.sections.indexOf(item)
      item.course_id = app.course.course_id
      item.section_order = order
      var url = api_url + 'course-sections/update'
      app.$http.post(url, item).then(res => {
        if (res.body.status == 'success') {
          item.old_section_order = item.section_order
          item.old_section_name = item.section_name
          Object.assign(app.curriculum.sections[order], item)
        }
        app.curriculum.update_section_loading = false
      }, err => {
        app.curriculum.update_section_loading = false
      })
    },

    addLesson(section_index, item) {
      var app = this
      app.curriculum.add_lesson_loading = true
      var section = app.curriculum.sections[section_index]
      var i = section.items.indexOf(item)
      var order = i == -1 ? 0 : i
      var id = section.items.length
      id++
      var lesson = {
        lesson_name: "Clase " + id,
        old_lesson_name: "Clase " + id,
        lesson_type: 1,
        lesson_order: order,
        meta: {},
        quizzes: [],
        resources: [],
        section_id: section.section_id
      }
      var url = api_url + 'course-lessons/create'
      app.$http.post(url, lesson).then(res => {
        if (res.body.status == 'success') {
          lesson.lesson_id = res.body.data.lesson_id
          lesson.old_lesson_order = order
          app.curriculum.sections[section_index].items.push(lesson);
        }
        app.curriculum.add_lesson_loading = false
      }, err => {
        app.curriculum.add_lesson_loading = false
      })
    },

    addQuestion() {
      var app = this
      app.curriculum.add_quiz_loading = true
      var lesson = app.curriculum.sections[app.lessons.editedSectionIndex].items[app.lessons.editedLessonIndex]
      var id = app.lessons.item.hasOwnProperty('quizzes') ? app.lessons.item.quizzes.length + 1 : 1
      var quiz = {
        question_name: "Pregunta " + id,
        old_question_name: "Pregunta " + id,
        question_type: "1",
        score: 1,
        question_answers: [],
        correct_answer: '',
        lesson_id: lesson.lesson_id
      }
      var url = api_url + 'lesson-quizzes/create'
      app.$http.post(url, { lesson, quiz }).then(res => {
        if (res.body.status == 'success') {
          app.curriculum.add_quiz_loading = false
          quiz.question_id = res.body.data.question_id
          if (app.lessons.item.hasOwnProperty('quizzes')) {
            app.lessons.item.quizzes.push(quiz);
          }
          else {
            app.lessons.item.quizzes = [quiz]
          }
          lesson.quizzes = Object.assign({}, app.lessons.item.quizzes)
        }
      }, err => {
        app.curriculum.add_quiz_loading = false
      })
    },

    addQuestionAnswer(quiz) {
      var app = this
      var answer_index = quiz.question_answers.length + 1
      var answer = 'Respuesta ' + answer_index
      quiz.question_answers.push({ answer: answer })
      quiz.question_name += ' '
    },

    updateLessonMeta() {
      var app = this
      app.curriculum.update_lesson_meta_loading = true
      var lesson = app.lessons.item
      if (lesson.lesson_type == 1) {
        var data = new FormData()
        var url = api_url + 'course-lessons/update-class-lesson-meta/'
        data.append('course_id', app.course.course_id)
        data.append('lesson_id', lesson.lesson_id)
        data.append('class_type', lesson.meta.class_type)
        data.append('send_publish_email', lesson.meta.send_publish_email)
        data.append('description', lesson.meta.description)
        data.append('duration', lesson.meta.duration)

        if (lesson.meta.class_type == 'video') {
          data.append('poster', lesson.meta.poster)
          data.append('video', lesson.meta.video)
        }

        else if (lesson.meta.class_type == 'zoom_meeting') {
          data.append('zoom_topic', lesson.lesson_name)
          if (lesson.meta.hasOwnProperty('zoom_id')) {
            data.append('meeting_id', lesson.meta.zoom_id)
          }
          data.append('zoom_topic', lesson.lesson_name)
          data.append('zoom_jwt', app.course.meta.zoom_jwt)
          data.append('zoom_host', app.course.meta.zoom_host)
          data.append('zoom_duration', lesson.meta.zoom_duration)
          data.append('zoom_date', lesson.meta.zoom_date)
          data.append('zoom_time', lesson.meta.zoom_time)
          data.append('zoom_timezone', lesson.meta.zoom_timezone)
          data.append('zoom_start_time', moment(lesson.meta.zoom_date + ' ' + lesson.meta.zoom_time).format())
          data.append('zoom_agenda', lesson.meta.zoom_agenda)
        }

        else if (lesson.meta.class_type == 'streaming') {
          data.append('streaming_date', lesson.meta.streaming_date)
          data.append('streaming_time', lesson.meta.streaming_time)
          data.append('streaming_id', lesson.meta.streaming_id)
          data.append('streaming_timezone', lesson.meta.streaming_timezone)
        }
      }
      else if (lesson.lesson_type == 2) {
        var data = {
          lesson,
          course: {
            course_id: app.course.course_id,
            title: app.course.title,
            slug: app.course.slug
          }
        }
        var url = api_url + 'course-lessons/update-quiz-lesson-meta/'
      }
      app.$http.post(url, data, {
        progress(e) {
          if (e.lengthComputable) {
            app.percent_loading_active = true
            app.percent_loading = (e.loaded / e.total) * 100
          }
        }
      }).then(res => {
        app.percent_loading_active = false
        app.curriculum.update_lesson_meta_loading = false
        app.alert = true
        app.alert_type = res.body.status
        app.alert_message = res.body.message
        if (res.body.status == 'success') {
          if (lesson.meta.class_type == 'video') {
            lesson.meta.video_url = res.body.data.hasOwnProperty('video_url') ? res.body.data.video_url : lesson.meta.video_url
            lesson.meta.poster_url = res.body.data.hasOwnProperty('poster_url') ? res.body.data.poster_url : lesson.meta.video_url
          }
          else if (lesson.meta.class_type == 'zoom_meeting' && !lesson.meta.hasOwnProperty('zoom_id')) {
            lesson.meta.zoom_id = res.body.data.id
            lesson.meta.zoom_url = res.body.data.join_url
          }
          Object.assign(app.curriculum.sections[app.lessons.editedSectionIndex].items[app.lessons.editedLessonIndex].meta, lesson.meta)
        }
      }, err => {
        app.percent_loading_active = false
        app.curriculum.update_lesson_meta_loading = false
      })
    },

    updateResource(resource, index) {
      var app = this
      var url = api_url + 'media/create'
      var data = new FormData()
      resource.loading = true
      data.append('course_id', app.course.course_id)
      data.append('lesson_id', app.lessons.item.lesson_id)
      data.append('preview_only', resource.preview_only)
      data.append('resource_name', resource.name)
      data.append('media', resource.file)
      if (resource.hasOwnProperty('media_id')) {
        data.append('media_id', resource.media_id)
        data.append('url', resource.url)
        url = api_url + 'media/update'
      }
      app.$http.post(url, data, {
        progress(e) {
          if (e.lengthComputable) {
            resource.percent_loading_active = true
            resource.percent_loading = (e.loaded / e.total) * 100
          }
        }
      }).then(res => {
        app.curriculum.update_lesson_meta_loading = false
        if (res.body.status == 'success') {
          if (!resource.hasOwnProperty('media_id')) {
            resource.media_id = res.body.data.media_id
          }
          resource.url = res.body.data.url
        }
        resource.loading = false
        resource.percent_loading_active = false
      }, err => {
        resource.percent_loading_active = false
        resource.loading = false
      })
    },

    updateLesson(section_index, item) {
      var app = this
      app.curriculum.update_lesson_loading = true
      var section = app.curriculum.sections[section_index]
      var i = section.items.indexOf(item)
      var order = i == -1 ? 0 : i
      item.section_id = section.section_id
      item.lesson_order = order
      var url = api_url + 'course-lessons/update'
      app.$http.post(url, item).then(res => {
        if (res.body.status == 'success') {
          item.old_lesson_order = item.lesson_order
          item.old_lesson_name = item.lesson_name
          Object.assign(app.curriculum.sections[section_index].items[order], item)
        }
        app.curriculum.update_lesson_loading = false
      }, err => {
        app.curriculum.update_lesson_loading = false
      })
    },

    updateQuestion(quiz) {
      var app = this
      app.curriculum.update_quiz_loading = true
      var url = api_url + 'lesson-quizzes/update'
      app.$http.post(url, quiz).then(res => {
        if (res.body.status == 'success') {
          quiz.old_question_name = quiz.question_name
        }
        app.curriculum.update_quiz_loading = false
      }, err => {
        app.curriculum.update_quiz_loading = false
      })
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

    removeFAQ(item) {
      var app = this
      var id = app.faq.items.indexOf(item)
      app.faq.items.splice(id, 1);
    },

    removeSection(item) {
      var app = this
      app.curriculum.loading = true
      var id = app.curriculum.sections.indexOf(item)
      var url = api_url + 'course-sections/delete';
      data = { course_id: app.course.course_id, section_id: item.section_id }
      app.$http.post(url, data).then(res => {
        if (res.body.status == "success") {
          app.curriculum.sections.splice(id, 1);
        }
        app.curriculum.loading = false
      }, err => {
        app.curriculum.loading = false
      })
    },

    removeLesson(section_index, item) {
      var app = this
      app.curriculum.loading = true
      var section = app.curriculum.sections[section_index]
      var id = app.curriculum.sections[section_index].items.indexOf(item)
      var url = api_url + 'course-lessons/delete';
      data = { section_id: section.section_id, lesson_id: item.lesson_id }
      app.$http.post(url, data).then(res => {
        if (res.body.status == "success") {
          app.curriculum.sections[section_index].items.splice(id, 1);
        }
        app.curriculum.loading = false
      }, err => {
        app.curriculum.loading = false
      })
    },

    removeQuiz(quiz, quiz_index) {
      var app = this
      var url = api_url + 'lesson-quizzes/delete';
      data = { lesson_id: quiz.lesson_id, question_id: quiz.question_id }
      app.$http.post(url, data).then(res => {
        if (res.body.status == "success") {
          app.lessons.item.quizzes.splice(quiz_index, 1);
        }
      }, err => {
      })
    },

    removeResource(resource, index) {
      var app = this
      if (resource.hasOwnProperty('media_id')) {
        var url = api_url + 'media/delete'
        app.$http.post(url, resource).then(res => {
          if (res.body.status == 'success') {
            app.lessons.item.resources.splice(index, 1)
          }
        }, err => {

        })
      }
      else {
        app.lessons.item.resources.splice(index, 1)
      }
    },

    removeQuestionAnswer(quiz, answer) {
      var app = this
      quiz.question_answers.splice(answer, 1)
      quiz.old_question_name += ' '
    },

    formatText(item) {
      var str = item.split('').filter(c => c.charCodeAt() > 0).join('');
      return str;
    },

    checkLessonNames(item) {
      var old = item.old_lesson_name
      var _new = item.lesson_name
      return _new == old ? true : false
    },

    checkQuizNames(item) {
      var old = item.old_question_name
      var _new = item.question_name
      return _new == old ? true : false
    },

    checkQuizType(quiz) {
      if (quiz.question_type == '2') {
        quiz.question_answers = [
          {
            answer: 'Verdadero'
          },
          {
            answer: 'Falso'
          }
        ]
        quiz.correct_answer = 'Falso'
      }
      else if (quiz.question_type == '3') {
        quiz.question_answers = [
          {
            answer: '',
            missing_words: ''
          }
        ]
      }
    },

    matchWords(answer) {
      var text = answer.answer;
      var regex = /\[([^\]]+)]/g;
      var re1 = '[';
      var re2 = ']';
      var results = text.match(regex) != null ? text.match(regex) : []
      var missing_words = []
      results.forEach((s, i) => {
        var text = s.replace(re1, '')
        text = text.replace(re2, '')
        missing_words.push(text)
      });
      answer.missing_words = missing_words
    },

    checkSectionNames(item) {
      var old = item.old_section_name
      var _new = item.section_name
      return _new == old ? true : false
    },

    getExt (file_name) {
      var url = file_name
      var splitted_url = url.split('/')
      var ext = splitted_url[splitted_url.length - 1].split('.')
      return ext[1]
    },
    
    close() {
      this.$nextTick(() => {
        this.alert = false
        this.lessons.item.meta = Object.assign({}, this.lessons.itemMetaDefault)
      })
    }

  }
});
