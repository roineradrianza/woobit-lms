/*
* const vuetify
* const validations
*/
/*VUE INSTANCE*/
const splitted_domain = window.location.href.split('/')
const course_slug = splitted_domain[4]
const lesson_id = splitted_domain[5]
Vue.component(VueCountdown.name, VueCountdown)
moment.locale('es')
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    drawer: false,
    tab: null,
    nav_tab: null,
    alert: false,
    loading: false,
    send_quiz_loading: false,
    certified_approved_dialog: false,
    certified_loading: false,
    certified_url: '',
    requireCertifiedPaid: false,
    alert_message: '',
    alert_type: '',
    selection: 1,
    quiz_countdown: 16000,
    quiz_started: false,
    quiz_finished: false,
    counting: false,
    meta: {
    },
    notifications: [],
    attempt_results: [],
    quiz_results: [],
    quiz: [],
  },

  computed: {
  },

  watch: {
    quiz_started(val) {
      if (val) {
        this.counting = true
        window.addEventListener('scroll', this.handleScroll)
      }
    }
  },

  created() {
    this.initialize()
    this.initializeQuizAttempts()
    this.initializeQuiz()
  },

  mounted() {
  },

  methods: {
    initialize() {
      var app = this
      var url = api_url + 'course-lessons/get-meta-info/' + lesson_id
      app.loading = true
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          res.body.forEach((meta) => {
            app.meta[meta['lesson_meta_name']] = meta['lesson_meta_val']
            if (meta['lesson_meta_name'] == 'quiz_duration') {
              countdown = meta['lesson_meta_val']
              app.quiz_countdown = countdown * 60000
            }
          })
        }
        app.loading = false
      }, err => {
      })
    },

    initializeQuizAttempts() {
      var app = this
      var url = api_url + 'lesson-quizzes/get-attempt/' + lesson_id
      app.loading = true
      app.$http.get(url).then(res => {
        if (res.body.hasOwnProperty('attempt_data') || res.body.hasOwnProperty('quiz_results')) {
          app.attempt_results = res.body.attempt_data
          app.quiz_results = res.body.quiz_results
          if (app.attempt_results.hasOwnProperty('approved')) {
            app.quiz_finished = true
          }
        }
        app.loading = false
      }, err => {
      })
    },

    initializeQuiz() {
      var app = this
      var url = api_url + 'lesson-quizzes/get-questions/' + lesson_id
      app.loading = true
      app.$http.get(url).then(res => {
        app.loading = false
        app.quiz = res.body
      }, err => {
      })
    },

    saveQuiz(no_answer = true) {
      var app = this
      var empty_quizzes = app.checkEmptyAnswers()
      if (empty_quizzes > 0 && no_answer) {
        var amount = empty_quizzes > 1 ? 'preguntas' : 'pregunta'
        app.alert = true
        app.alert_message = "Por favor revisa nuevamente el quiz, tienes " + empty_quizzes + ' ' + amount + " sin responder"
        app.alert_type = 'warning'
        return false
      }
      app.send_quiz_loading = true
      app.counting = false
      var data = {
        meta: app.meta,
        lesson: {
          lesson_id: lesson_id
        },
        answers: app.quiz
      }
      app.$refs.countdown_component1.abort()
      app.$refs.countdown_component2.abort()
      var url = api_url + 'lesson-quizzes/save-attempt'
      app.$http.post(url, data).then(res => {
        app.$refs.quiz_form.reset();
        app.quiz_finished = true
        app.send_quiz_loading = false
        app.attempt_results = res.body.data.attempt_data
        app.quiz_results = res.body.data.quiz_results
        window.scrollTo(0, 0)
        if (res.body.status == 'success') {
          if (res.body.data.hasOwnProperty('certified_url') && res.body.data.certified_url !== ''
            || res.body.data.hasOwnProperty('requireCertifiedPaid') && res.body.data.requireCertifiedPaid != 2) {
            app.certified_url = res.body.data.certified_url
            app.requireCertifiedPaid = res.body.data.requireCertifiedPaid
            app.certified_approved_dialog = true
          }
        }
      }, err => {
        app.send_quiz_loading = false
      })
    },

    handleScroll() {
      if (!this.quiz_finished) {
        var countdown_container = this.$refs.countdown_row
        var countdown_height = this.$refs.countdown.scrollWidth
        var isCountdownHide = window.scrollY > countdown_height ? 1 : 0
        if (isCountdownHide) {
          if (!countdown_container.classList.contains('d-flex')) {
            countdown_container.classList.remove('d-none')
          }
          countdown_container.classList.add('d-flex')
        }
        else {
          if (!countdown_container.classList.contains('d-none')) {
            countdown_container.classList.remove('d-flex')
          }
          countdown_container.classList.add('d-none')
        }
      }
    },

    transformSlotProps(props) {
      const formattedProps = {};

      Object.entries(props).forEach(([key, value]) => {
        formattedProps[key] = value < 10 ? `0${value}` : String(value);
      });

      return formattedProps;
    },

    checkEmptyAnswers() {
      var app = this
      var quiz_empty = 0
      app.quiz.forEach((question) => {
        if (question.correct_answer == '' || question.correct_answer.lenght == 0) {
          quiz_empty++
        }
      })
      if (quiz_empty > 0) { return quiz_empty }
      return false
    },

    getTimeDifference(t) {
      return moment(t).diff(moment().format());
    },

    formatDate(d) {
      return moment(d).format('LLL');
    },

    replaceString(s, d, r) {
      return s.replace(d, r)
    },

    replaceMissingWords(question, quiz) {
      var text = question.answer;
      var regex = /\[([^\]]+)]/g;
      var results = text.match(regex) != null ? text.match(regex) : []
      results.forEach((s, i) => {
        var badge = `
            <span class="pr-1 mr-4 v-badge theme--light">
              <span class="v-badge__wrapper">
                <span aria-atomic="true" aria-label="Badge" 
                aria-live="polite" role="status" class="v-badge__badge primary" 
                style="inset: auto auto calc(100% - 4px) calc(100% - 4px);">${i + 1}
                </span>
              </span>
            </span>
          `
        question.answer = text.replace(s, badge)
        quiz.correct_answer = []
        quiz.correct_answer.push()
      });

    },

    replaceMissingWordsReview(question, quiz) {
      var text = question.answer;
      var regex = /\[([^\]]+)]/g;
      var results = text.match(regex) != null ? text.match(regex) : []
      results.forEach((s, i) => {
        var badge = `
            <span class="pr-1 mr-4 v-badge theme--light">
              <span class="v-badge__wrapper">
                <span aria-atomic="true" aria-label="Badge" 
                aria-live="polite" role="status" class="v-badge__badge primary" 
                style="inset: auto auto calc(100% - 4px) calc(100% - 4px);">${i + 1}
                </span>
              </span>
            </span>
          `
        question.answer = text.replace(s, badge)
      });
    },

    parseAnswers(quiz) {
      if (!Array.isArray(quiz.correct_answer)) {
        quiz.correct_answer = JSON.parse(quiz.correct_answer)
      }
    },

    checkWords(word, question, i) {
      var correct = question.correct_answer[i]
      var result = word.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase() == correct.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase() ? true : false
      return result
    },

    getWords(word, question, i) {
      input = question.correct_answer[i]
      return input
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