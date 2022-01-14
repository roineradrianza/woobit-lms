/*
* const vuetify
* const validations
*/
/*VUE INSTANCE*/
const splitted_domain = window.location.href.split('/')
const course_slug = splitted_domain[4]
const lesson_id = splitted_domain[5]
const timezone = moment.tz.guess()
Vue.component(VueCountdown.name, VueCountdown)
moment.locale(app_language)
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    course_id: '',
    drawer: false,
    tab: null,
    nav_tab: null,
    loading: false,
    join_loading: false,
    lesson_tab: 'overview',
    lesson_materials_sent_loading: false,
    classmates_loading: false,
    send_comment_loading: false,
    skills_container: false,
    resource_preview_dialog: false,
    resource_preview_loading: true,
    canPost: false,
    selection: 1,
    snackbar: false,
    snackbar_timeout: 5000,
    snackbar_text: '',
    snackbar_type: '',
    zoom_countdown: 1000,
    countdown_container: {},
    show_button: false,
    zoom_link: false,
    meta: {},
    notifications: [],
    recent_questions: [],
    recent_contributions: [],
    classmates: [],
    comments: [],
    resources: [],
    resource_preview: {},
    comment: '',
    lesson_messages: new LessonMessage({uid: uid, lesson_id: lesson_id}),
    child_profile: new ChildProfile,
    student_materials_headers: [
      { text: 'Student', align: 'start', value: 'full_name' }
    ],
    students_selected: [],
    student_selected: {},
    customToolbar: [
      [{ header: [false, 1, 2, 3, 4, 5, 6] }],
      ["bold", "italic", "underline" , "strike"],
      [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
      ["blockquote"],
      [{ indent: "-1" }, { indent: "+1" }]
      [
        { align: "" },
        { align: "center" },
        { align: "right" },
        { align: "justify" }
      ],
      [{ indent: "-1" }, { indent: "+1" }],
      ["link"],
    ],
    resources: [],
    lesson_materials_sent: [],
    resource_preview: {},
  },

  computed: {
    ScreenHeight() {
      return window.screen.height - (window.screen.height * 35 / 100)
    },
  },

  watch: {
    zoom_countdown(val) {
      if (val <= 1800000) {
        this.show_button = true
      }
    },

    students_selected(val) {
      this.student_selected = Object.assign({}, val[0])
      this.initializeLessonMaterialsSent({child_id: this.student_selected.user_id})
    }
  },

  created() {
    this.initialize()
    this.initializeLessonResources()
    this.initializeLessonClassmates()
    this.initializeComments()
    this.lesson_messages.load()
  },

  mounted() {
    this.$refs.hasOwnProperty('child_profile_select') ? this.child_profile.filterAndSelect(this.$refs.child_profile_select.items) : ''
    this.course_id = this.$refs.lesson_container.getAttribute('data-course-id')
  },

  methods: {
    initialize() {
      var app = this
      var url = api_url + 'course-lessons/get-meta-info/' + lesson_id
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          res.body.forEach((meta) => {
            app.meta[meta['lesson_meta_name']] = meta['lesson_meta_val']
            if (meta['lesson_meta_name'] == 'zoom_start_time') {
              countdown = app.getTimeDifference(meta['lesson_meta_val'])
              app.zoom_countdown = countdown < 0 ? 0 : countdown
              app.countdown_container = app.$refs.meeting_countdown
            }
          })
        }
      }, err => {

      })
    },

    initializeComments() {
      var app = this
      var url = api_url + 'lesson-comments/get/' + lesson_id
      app.$http.post(url, { course_slug }).then(res => {
        if (res.body.length > 0) {
          app.comments = []
          res.body.forEach(item => {
            item.edit_comment_box = false
            item.edit_comment_loading = false
            item.edited_comment = item.comment
            item.edit_answer_box = false
            item.edit_answer_loading = false
            item.edited_answer = ''
            item.answer_loading = false
            item.edit_answer_loading = false
            item.answer = ''
            item.answer_box = false
            app.comments.push(item)
          })
        }
      }, err => {
      })
    },

    initializeLessonClassmates() {
      var app = this
      var url = api_url + 'lessons/get-classmates/' + lesson_id

      app.classmates_loading = true

      app.$http.get(url).then( res => {
        app.classmates_loading = false
        res.body.forEach( item => {
          item.full_name = `${item.first_name} ${item.last_name}`
        })
        app.classmates = res.body
      }, err => {

      })
    },

    initializeLessonResources() {
      var app = this
      var url = api_url + 'media/get-lesson-resources/' + lesson_id
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          res.body.forEach((resource) => {
            resource.loading = false
            resource.percent_loading_active = false
            resource.percent_loading = 0
            resource.edit = false
            app.resources.push(resource)
          })
        }
      }, err => {

      })
    },

    initializeLessonMaterialsSent({child_id = null}) {
      var app = this
      var url = api_url + 'lesson-materials-sent/get/' + lesson_id
      app.lesson_materials_sent = []
      var data = {
        child_id: child_id
      }

      if (data.child_id == null) {
        console.log(data.child_id)
        return false
      }

      app.lesson_materials_sent_loading = true

      app.$http.post(url, data).then(res => {
        if (res.body.length > 0) {
          res.body.forEach((resource) => {
            resource.loading = false
            resource.percent_loading_active = false
            resource.percent_loading = 0
            resource.edit = false
            app.lesson_materials_sent.push(resource)
          })
        }
        app.lesson_materials_sent_loading = false
      }, err => {

      })
    },

    transformSlotProps(props) {
      const formattedProps = {};

      Object.entries(props).forEach(([key, value]) => {
        formattedProps[key] = value < 10 ? `0${value}` : String(value);
      });

      return formattedProps;
    },

    getTimeDifference(t) {
      var tz = moment.tz.guess();
      return moment(t).tz(this.meta.zoom_timezone).diff(moment().tz(tz).format());
    },

    formatDate(d) {
      return moment(d).format('LLL');
    },

    replaceString(s, d, r) {
      return s.replace(d, r)
    },

    joinClass() {
      var app = this
      app.join_loading = true
      var url = api_url + 'lessons/join-class/' + lesson_id
      app.$http.post(url, { slug: course_slug }).then(res => {
        if (res.body.status == 'success') {
          window.open(app.meta.zoom_url, '_blank')
          if (res.body.data.hasOwnProperty('certified_url') && res.body.data.certified_url !== ''
            || res.body.data.hasOwnProperty('requireCertifiedPaid') && res.body.data.requireCertifiedPaid != 2) {
            app.certified_url = res.body.data.certified_url
            app.requireCertifiedPaid = res.body.data.requireCertifiedPaid
            app.certified_approved_dialog = true
          }
        }
        app.zoom_link = true
        app.join_loading = false
      }, err => {
        app.join_loading = false
      })
    },

    getExt(file_name) {
      var url = file_name
      var splitted_url = url.split('/')
      var ext = splitted_url[splitted_url.length - 1].split('.')
      return ext[1]
    },

    getExtIcon(file_name) {
      var url = file_name
      var splitted_url = url.split('/')
      var ext = splitted_url[splitted_url.length - 1].split('.')
      var file_icon = ''
      switch (ext[1]) {
        case 'pdf':
          file_icon = 'pdf-box'
          break;
        case 'docx':
          file_icon = 'word'
          break;
        case 'doc':
          file_icon = 'word'
          break;
        case 'ppt':
          file_icon = 'powerpoint'
          break;
        case 'pptx':
          file_icon = 'powerpoint'
          break;
        case 'ppt':
          file_icon = 'powerpoint'
          break;
        case 'png':
          file_icon = 'image'
          break;
        case 'jpg':
          file_icon = 'image'
          break;
        case 'jpeg':
          file_icon = 'image'
          break;
        case 'xls':
          file_icon = 'excel'
          break;
        case 'xlsx':
          file_icon = 'excel'
          break;
        default:
          file_icon = 'document'
          break;
      }
      return file_icon
    },

    saveFile(url, loading_target) {
      var app = this
      loading_target = loading_target === undefined ? app : loading_target
      var filename = url.substring(url.lastIndexOf("/") + 1).split("?")[0];
      app.$http.get(url, {
        responseType: 'blob',
        progress(e) {
          if (e.lengthComputable) {
            loading_target.percent_loading_active = true
            loading_target.percent_loading = (e.loaded / e.total) * 100
          }
        }
      }).then(res => {
        var a = document.createElement('a');
        a.href = window.URL.createObjectURL(res.body);
        a.download = filename;
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        delete a;
      })
    },

    updateResource(resource, index) {
      var app = this
      var url = api_url + 'media/create'
      var data = new FormData()
      resource.loading = true
      data.append('course_id', app.course_id)
      data.append('lesson_id', lesson_id)
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
        if (res.body.status == 'success') {
          if (!resource.hasOwnProperty('media_id')) {
            resource.media_id = res.body.data.media_id
          }
          resource.url = res.body.data.url
          resource.edit = false
        }
        resource.loading = false
        resource.percent_loading_active = false
      }, err => {
        resource.percent_loading_active = false
        resource.loading = false
      })
    },

    removeResource(resource, index) {
      var app = this
      if (resource.hasOwnProperty('media_id')) {
        var url = api_url + 'media/delete'
        app.$http.post(url, resource).then(res => {
          if (res.body.status == 'success') {
            app.resources.splice(index, 1)
          }
        }, err => {

        })
      }
      else {
        app.resources.splice(index, 1)
      }
    },

    updateLessonMaterial({resource, child_id = null }) {
      var app = this
      var url = api_url + 'lesson-materials-sent/create'
      var data = new FormData()
      resource.loading = true
      resource.lesson_id = lesson_id
      resource.children_id = !resource.hasOwnProperty('children_id') ? child_id == null 
      ? app.student_selected.hasOwnProperty('user_id') ? app.student_selected.user_id : app.child_profile.child_id : child_id : resource.children_id
      data.append('lesson_id', resource.lesson_id)
      data.append('children_id', resource.children_id)
      data.append('sender', resource.sender)
      data.append('resource_name', resource.name)
      data.append('material', resource.file)
      if (resource.hasOwnProperty('material_id')) {
        data.append('material_id', resource.material_id)
        data.append('url', resource.url)
        url = api_url + 'lesson-materials-sent/update'
      }
      app.$http.post(url, data, {
        progress(e) {
          if (e.lengthComputable) {
            resource.percent_loading_active = true
            resource.percent_loading = (e.loaded / e.total) * 100
          }
        }
      }).then(res => {
        if (res.body.status == 'success') {
          if (!resource.hasOwnProperty('material_id')) {
            resource.material_id = res.body.data.material_id
          }
          resource.url = res.body.data.url
          resource.edit = false
        }
        resource.loading = false
        resource.percent_loading_active = false
      }, err => {
        resource.percent_loading_active = false
        resource.loading = false
      })
    },

    removeLessonMaterial(resource, index) {
      var app = this
      if (resource.hasOwnProperty('material_id')) {
        var url = api_url + 'lesson-materials-sent/delete'
        app.$http.post(url, resource).then(res => {
          if (res.body.status == 'success') {
            app.lesson_materials_sent.splice(index, 1)
          }
        }, err => {

        })
      }
      else {
        app.lesson_materials_sent.splice(index, 1)
      }
    },

    saveComment(comment_type) {
      var app = this
      var child = app.child_profile.child_selected
      app.send_comment_loading = true

      var data = {
        comment: app.comment,
        comment_type: comment_type,
        user_id: child.user_id,
        gender: child.gender,
        first_name: child.first_name,
        last_name: child.last_name,
        lesson_id
      }

      var url = api_url + 'lesson-comments/create'
      app.$http.post(url, data).then(res => {
        app.send_comment_loading = false
        if (res.body.status == 'success') {
          app.snackbar = true
          app.snackbar_text = res.body.message
          app.snackbar_type = 'primary'

          data.editable = true
          data.edit_comment_box = false
          data.edit_comment_loading = false
          data.edited_comment = data.comment
          data.edit_answer_box = false
          data.edit_answer_loading = false
          data.edited_answer = ''
          data.answer_loading = false
          data.edit_answer_loading = false
          data.lesson_comment_id = res.body.data.lesson_comment_id
          data.published_at = moment.utc()

          app.comments.push(data)

          if (comment_type == 'question') {
            app.recent_questions.push(data)
          }

          else if (comment_type == 'contribution') {
            app.recent_contributions.push(data)
          }

          app.comment = ''

        }
      }, err => {
        app.send_comment_loading = false
        app.snackbar = true
        app.snackbar_text = 'S-a produs o eroare neașteptată la postarea comentariului'
        app.snackbar_type = 'primary'
      })
    },

    editComment(item) {
      var app = this
      app.edit_comment_loading = true
      var comment_index = app.comments.indexOf(item)
      var data = {
        lesson_comment_id: item.lesson_comment_id,
        comment: item.edited_comment,
      }
      var url = api_url + 'lesson-comments/update'
      app.$http.post(url, data).then(res => {
        app.edit_comment_loading = false
        if (res.body.status == 'success') {
          app.snackbar = true
          app.snackbar_text = res.body.message
          app.snackbar_type = 'primary'
          item.comment = data.comment
          item.edit_answer_box = false
          Object.assign(app.comments[comment_index], item)
        }
      }, err => {
        app.edit_comment_loading = false
        app.snackbar = true
        app.snackbar_text = 'S-a produs o eroare neașteptată în timpul actualizării'
        app.snackbar_type = 'primary'
      })
    },

    saveAnswer(item) {
      var app = this
      app.answer_loading = true
      var comment_index = app.comments.indexOf(item)
      var data = {
        comment: item.answer,
        lesson_comment_id: item.lesson_comment_id
      }
      var url = api_url + 'lesson-comments-answers/create'
      app.$http.post(url, data).then(res => {
        app.answer_loading = false
        if (res.body.status == 'success') {
          app.snackbar = true
          app.snackbar_text = res.body.message
          app.snackbar_type = 'primary'

          data.editable = true
          data.lesson_comment_answer_id = res.body.data.lesson_answer_comment_id
          data.avatar = res.body.data.avatar
          data.first_name = res.body.data.first_name
          data.last_name = res.body.data.last_name
          data.username = res.body.data.username
          data.published_at = moment.utc()
          app.comments[comment_index].answers.push(data)
        }
      }, err => {
        app.answer_loading = false
        app.snackbar = true
        app.snackbar_text = 'S-a produs o eroare neașteptată la postarea comentariului'
        app.snackbar_type = 'primary'
      })
    },

    editAnswer(item, answer) {
      var app = this
      app.edit_answer_box = true
      var comment_index = app.comments.indexOf(item)
      var answer_index = app.comments[comment_index].answers.indexOf(answer)
      var data = {
        lesson_comment_answer_id: answer.lesson_comment_answer_id,
        comment: answer.edited_answer,
      }
      var url = api_url + 'lesson-comments-answers/update'
      app.$http.post(url, data).then(res => {
        app.edit_comment_loading = false
        if (res.body.status == 'success') {
          app.snackbar = true
          app.snackbar_text = res.body.message
          app.snackbar_type = 'primary'

          answer.comment = data.comment
          Object.assign(app.comments[comment_index].answers[answer_index], answer)
        }
      }, err => {
        app.edit_comment_loading = false
        app.snackbar = true
        app.snackbar_text = 'S-a produs o eroare neașteptată în timpul actualizării'
        app.snackbar_type = 'primary'
      })
    },

    deleteComment(item) {
      var app = this
      var url = api_url + 'lesson-comments/delete/'
      var comment_index = this.comments.indexOf(item)
      var data = Object.assign({}, item)
      data.lesson_id = lesson_id
      app.$http.post(url, data).then(res => {
        app.snackbar = true
        app.snackbar_text = res.body.message
        app.snackbar_type = 'primary'
        if (res.body.status == 'success') {
          app.comments.splice(comment_index, 1)
        }
      }, err => {
        app.send_comment_loading = false
        app.snackbar = true
        app.snackbar_text = 'S-a produs o eroare neașteptată la postarea comentariului'
        app.snackbar_type = 'primary'
      })
    },

    deleteAnswer(item) {
      var app = this
      var url = api_url + 'lesson-comments/delete/'
      var comment_index = this.comments.indexOf(item)
      var data = Object.assign({}, item)
      data.lesson_id = lesson_id
      app.$http.post(url, data).then(res => {
        app.snackbar = true
        app.snackbar_text = res.body.message
        app.snackbar_type = 'primary'
        if (res.body.status == 'success') {
          app.comments.splice(comment_index, 1)
        }
      }, err => {
        app.send_comment_loading = false
        app.snackbar = true
        app.snackbar_text = 'S-a produs o eroare neașteptată la postarea comentariului'
        app.snackbar_type = 'primary'
      })
    },

    getFullName(item) {
      return item.first_name + ' ' + item.last_name
    },

    fromNow(date_time) {
      var cest = moment.tz(date_time, 'Europe/Berlin');
      return cest.tz(timezone).fromNow();
    }

  }
});