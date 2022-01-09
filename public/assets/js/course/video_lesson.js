/*
* const vuetify
*/
/*VUE INSTANCE*/
const splitted_domain = window.location.href.split('/')
const course_slug = splitted_domain[4]
const lesson_id = splitted_domain[5]
const timezone = moment.tz.guess()
Vue.component('video-player', VueVideoPlayer.videoPlayer)
moment.locale(app_language)
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    drawer: false,
    tab: null,
    nav_tab: null,
    sidebar_tab: 'contributions',
    loading: false,
    video_loading: true,
    resource_preview_loading: true,
    send_comment_loading: false,
    skills_container: false,
    previous_video_time: false,
    current_video_time: false,
    canPost: false,
    snackbar: false,
    playing: false,
    percent_loading_active: false,
    resource_preview_dialog: false,
    certified_approved_dialog: false,
    certified_loading: false,
    certified_url: '',
    requireCertifiedPaid: false,
    saveTimeInterval: undefined,
    percent_loading: 0,
    snackbar_timeout: 5000,
    snackbar_text: '',
    snackbar_type: '',
    selection: 1,
    comment: '',
    notifications: [],
    recent_questions: [],
    recent_contributions: [],
    comments: [],
    resources: [],
    resource_preview: {},
    toolbar: [
      ["bold", "italic", "underline"],
      [{ list: "ordered" }, { list: "bullet" }],
      [
        { align: "" },
        { align: "center" },
        { align: "right" },
        { align: "justify" }
      ],
      [{ color: [] }],
      ['link']
    ],
    meta: {
      video_url: '',
      poster_url: '',
    },
    playerOptions: {
      fluid: true,
      autoplay: false,
      language: 'es',
      playbackRates: [0.7, 1.0, 1.5, 2.0],
      sources: [
        {
          type: "video/mp4",
          src: "",
          label: '1080p',
          selected: true,
        }
      ],
      html5: {
        hls: {
          overrideNative: true
        },
        nativeAudioTracks: false,
        nativeVideoTracks: false
      },
      poster: "",
    },
    resolutions: [
      '720p',
      '480p',
      '360p',
      '240p'
    ],
  },

  computed: {
    ScreenHeight () {
      return window.screen.height - (window.screen.height * 35 / 100)
    },
    player() {
      return this.$refs.videoPlayer.player
    }
  },

  watch: {
    comment(val) {
      if (val == '') {
        this.canPost = true
      }
      else {
        this.canPost = false
      }
    }
  },

  created() {
    this.initialize()
    this.initializeComments()
    this.initializeLessonResources()
  },

  mounted() {
  },

  methods: {
    initialize() {
      var app = this
      var url = api_url + 'course-lessons/get-meta-info/' + lesson_id
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          res.body.forEach((meta) => {
            app.meta[meta['lesson_meta_name']] = meta['lesson_meta_val']
          })
          app.playerOptions.sources[0].src = app.meta.video_url
          app.resolutions.forEach(r => {
            if (app.meta.hasOwnProperty('video_url_' + r)) {
              var item = {
                type: 'video/mp4',
                src: app.meta['video_url_' + r],
                label: r
              }
              app.playerOptions.sources.push(item)
            }
          });
          if (app.meta.hasOwnProperty('video_poster') && app.meta.video_poster != '') {
            app.playerOptions.sources[0].poster = app.meta.poster_url
          }
        }
        app.video_loading = false
      }, err => {
        app.video_loading = false
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

    initializeLessonResources() {
      var app = this
      var url = api_url + 'media/get-lesson-resources/' + lesson_id
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          res.body.forEach((resource, resource_index) => {
            resource.loading = false
            resource.percent_loading_active = false
            resource.percent_loading = 0
            app.resources.push(resource)
          })
        }
      }, err => {

      })
    },

    restoreVideo() {
      this.$refs.videoPlayer.dispose()
      this.$refs.videoPlayer.initialize()
    },

    // listen event
    onPlayerPlay(player) {
      vm.$data.playing = true
      // console.log('player play!', player)
    },

    onPlayerPause(player) {
      vm.$data.playing = false
      // console.log('player pause!', player)
    },

    onPlayerEnded(player) {
      vm.$data.playing = false
      // console.log('player ended!', player)
    },

    onPlayerLoadeddata(player) {
      // console.log('player Loadeddata!', player)
    },

    onPlayerWaiting(player) {
      // console.log('player Waiting!', player)
    },

    onPlayerPlaying(player) {
      var timeInterval = this.saveTimeInterval
      if (timeInterval > 0) {
        clearTimeout(this.saveTimeInterval)
      }
      (function () {
        if (!player.ended()) {
          vm.storeVideoTime()
        }
        vm.$data.saveTimeInterval = setTimeout(arguments.callee, 9000);
      })();
    },

    onPlayerTimeupdate(player) {
      // console.log('player Timeupdate!', player.currentTime())
    },

    onPlayerCanplay(player) {
      
    },

    onPlayerCanplaythrough(player) {
      // console.log('player Canplaythrough!', player)
    },

    // or listen state event
    playerStateChanged(playerCurrentState) {
    },

    // player is ready
    playerReadied(player) {
      player.videoJsResolutionSwitcher()
    },

    getCurrentTime() {
      return this.$refs.videoPlayer.player.currentTime()
    },

    getVideoDuration() {
      return this.$refs.videoPlayer.player.duration()
    },

    storeVideoTime() {
      var app = this
      if (!app.playing) {
        return false
      }
      var current_time = app.getCurrentTime()
      var video_time = app.getVideoDuration()
      var video_missing = video_time - current_time
      var percent = parseInt(video_missing * 100 / video_time)
      var data = {
        slug: course_slug,
        video_time,
        video_missing: percent
      }
      var url = api_url + 'lessons/save-video-progress/' + lesson_id
      app.$http.post(url, data).then(res => {
        if (res.body.data.hasOwnProperty('certified_url') && res.body.data.certified_url !== '' 
        || res.body.data.hasOwnProperty('requireCertifiedPaid') && res.body.data.requireCertifiedPaid != 2) {
           app.certified_url = res.body.data.certified_url
           app.requireCertifiedPaid = res.body.data.requireCertifiedPaid
           app.certified_approved_dialog = true
        }
      }, err => {

      })
    },

    saveComment(comment_type) {
      var app = this
      app.send_comment_loading = true
      var data = {
        comment: app.comment,
        comment_type: comment_type,
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
          data.avatar = res.body.data.avatar
          data.first_name = res.body.data.first_name
          data.last_name = res.body.data.last_name
          data.username = res.body.data.username
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
        app.snackbar_text = 'Hubo un error inesperado al publicar el comentario'
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
        app.snackbar_text = 'Hubo un error inesperado al actualizar'
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
        app.snackbar_text = 'Hubo un error inesperado al publicar el comentario'
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
        app.snackbar_text = 'Hubo un error inesperado al actualizar'
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
        app.snackbar_text = 'Hubo un error inesperado al publicar el comentario'
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
        app.snackbar_text = 'Hubo un error inesperado al publicar el comentario'
        app.snackbar_type = 'primary'
      })
    },

    getFullName(item) {
      return item.first_name + ' ' + item.last_name
    },

    fromNow(date_time) {
      var cest = moment.tz(date_time, 'Europe/Berlin');
      return cest.tz(timezone).fromNow();
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
          file_icon = 'pdf'
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
        case 'xls':
          file_icon = 'excel'
          break;
        default:
          file_icon = 'document'
          break;
      }
      return file_icon
    },

    isLocalFile(url) {
      return url.includes(domain) ? true : false
    },

    saveFile(url, loading_target) {
      var app = this
      loading_target = loading_target === undefined ? app : loading_target
      var filename = url.substring(url.lastIndexOf("/") + 1).split("?")[0]
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

  }
});