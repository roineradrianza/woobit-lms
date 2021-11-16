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
moment.locale('es')

window.addEventListener("load", (e) => {
  vm.check_attendance(vm)
});

let vm = new Vue({
  vuetify,
  el: '#full-learning-container',
  data: {
    drawer: false,
    tab: null,
    nav_tab: null,
    loading: false,
    join_loading: false,
    already_joined: false,
    skills_container: false,
    resource_preview_dialog: false,
    resource_preview_loading: true,
    certified_approved_dialog: false,
    certified_loading: false,
    certified_url: '',
    requireCertifiedPaid: false,
    selection: 1,
    streaming_countdown: 1000,
    countdown_container: {},
    show_button: false,
    meta: {},
    notifications: [],
    resources: [],
    resource_preview: {},
  },

  computed: {
    StartTime() {
      if (this.meta.hasOwnProperty('streaming_date')) {
        return this.meta.streaming_date + ' ' + this.meta.streaming_time
      }
      else {
        return ''
      }
    },
    ScreenHeight() {
      return window.screen.height - (window.screen.height * 35 / 100)
    },
  },

  watch: {
    streaming_countdown(val) {
      if (val <= 1800000) {
        this.show_button = true
      }
    }
  },

  created() {
    this.initialize()
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
          if (app.meta.hasOwnProperty('streaming_date')) {
            countdown = app.getTimeDifference(app.StartTime)
            app.streaming_countdown = countdown < 0 ? 0 : countdown
            app.countdown_container = app.$refs.meeting_countdown
          }
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

    transformSlotProps(props) {
      const formattedProps = {};

      Object.entries(props).forEach(([key, value]) => {
        formattedProps[key] = value < 10 ? `0${value}` : String(value);
      });

      return formattedProps;
    },

    hideSkills() {
      this.skills_container = false;
    },

    getTimeDifference(t) {
      var tz = moment.tz.guess();
      return moment(t).tz(this.meta.streaming_timezone).diff(moment().tz(tz).format());
    },

    formatDate(d) {
      return moment(d).format('LLL');
    },

    replaceString(s, d, r) {
      return s.replace(d, r)
    },

    check_attendance(app) {
      (function () {
        var tz = moment.tz.guess();
        var countdown_total = moment(app.StartTime).tz(vm.$data.meta.streaming_timezone).diff(moment().tz(tz).format());
        var mark_attendance = countdown_total < - 1200000 ? true : false
        if (!app.already_joined && mark_attendance) {
          app.joinClass()
        }
        app.saveTimeInterval = setTimeout(arguments.callee, 60000);
      })();
    },

    joinClass() {
      var app = this
      var url = api_url + 'lessons/join-class/' + lesson_id
      app.$http.post(url, { slug: course_slug }).then(res => {
        if (res.body.status == 'success') {
          app.already_joined = true
          if (res.body.data.hasOwnProperty('certified_url') && res.body.data.certified_url !== ''
            || res.body.data.hasOwnProperty('requireCertifiedPaid') && res.body.data.requireCertifiedPaid != 2) {
            app.certified_url = res.body.data.certified_url
            app.requireCertifiedPaid = res.body.data.requireCertifiedPaid
            app.certified_approved_dialog = true
          }
        }
      }, err => {
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

    saveFile(url, loading_target) {
      var app = this
      loading_target = loading_target === undefined ? app : loading_target
      var filename = url.substring(url.lastIndexOf("/") + 1).split("?")[0]; 5
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