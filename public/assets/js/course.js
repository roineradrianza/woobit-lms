
/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#full-learning-container',
  data: {
    current_url,
    course_tab: null,
    tab: null,
    nav_tab: null,
    loading: false,
    coupon_loading: false,
    certified_loading: false,
    coupon_field: false,
    stepper_dialog: true,
    modal_course: true,
    alert: false,
    alert_type: '',
    alert_message: '',
    course_id: '',
    stepper: 1,
    selection: 2,
    coupon_code: '',
    notifications: [],
    sponsors: [],
    sponsors_posts: [],
    sponsors_posts_filtered: [],
    rating: {
      my_rating: {},
      items: [],
      loading: false,
      form_valid: true,
      form_loading: false,
      myCommentIsPublished: false,
      form_rules: {
        comment: [
          v => !!v || 'Es requerido escribir un comentario',
          v => (v && v.length <= 10) || 'Debe ser un comentario mayor a 10 caracteres',
        ],
      },
      form: {
        comment: '',
        stars: 5,
      },
      defaultForm: {
        comment: '',
        stars: 5
      }
    },
    my_progress: {
      progress: 'N/A',
      quizzes_approved: 0,
      total_quizzes: 0,
      quizzes: [],
      certified: '',
    },
  },

  computed: {
  },

  created() {
    check_google_user()
  },

  mounted() {
    this.course_id = this.$refs.course_container.getAttribute('course_id')
    if (url_params.get('course_tab') != null) {
      this.course_tab = url_params.get('course_tab')
      setTimeout(() => {
        this.$refs.tabs_section.$el.scrollIntoView({ behavior: 'smooth' })
      }, 2000)
    }
    this.initializeSponsors()
    this.initializeSponsorsPosts()
    this.initializeComments()
  },

  methods: {


    initializeSponsors() {
      var app = this
      var url = api_url + 'sponsors/get-by-course/' + app.course_id
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          app.sponsors = res.body
        }
      }, err => {

      })
    },

    initializeSponsorsPosts() {
      var app = this
      var url = api_url + 'sponsors-posts/get/' + app.course_id
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          app.sponsors_posts_filtered = _.shuffle(res.body)
          app.sponsors_posts = res.body
        }
      }, err => {

      })
    },

    initializeComments() {
      var app = this
      var url = api_url + 'course-ratings/get/' + app.course_id
      app.rating.loading = true
      app.$http.get(url).then(res => {
        app.rating.items = res.body;
        app.rating.loading = false
      }, err => {
        app.rating.loading = false
      })
      if (typeof basic_info !== 'undefined') {
        var url = api_url + 'course-ratings/get-mine/' + app.course_id
        app.rating.loading = true
        app.$http.post(url).then(res => {
          if (res.body.length > 0) {
            app.rating.myCommentIsPublished = true
            res.body[0].stars = parseInt(res.body[0].stars)
            app.rating.my_rating = res.body[0]
          }
          app.rating.loading = false
        }, err => {
          app.rating.loading = false
        })
      }
    },

    initializeCourseProgress() {
      var app = this
      var data = {
        course_id: app.course_id
      }
      var url = api_url + 'course-students/get-student-progress-total'
      app.certified_loading = true
      app.$http.post(url, data).then(res => {
        app.my_progress = res.body
        app.certified_loading = false
      }, err => {
        app.certified_loading = false
      })
    },

    saveSponsorView(sponsor_id) {
      var app = this
      app.$http.post(api_url + 'sponsor-views/create', { sponsor_id: sponsor_id, course_id: app.course_id })
        .then(res => { })
    },

    saveSponsorPostView(sponsor_post_id) {
      var app = this
      app.$http.post(api_url + 'sponsor-post-views/create',
        { sponsor_post_id: sponsor_post_id, course_id: app.course_id })
        .then(res => { console.log(res) })
    },

    saveRating() {
      var app = this
      var url = api_url + 'course-ratings/create'
      if (!app.$refs.rating_form.validate()) {
        return false
      }
      else {
        app.rating.form_loading = true
        var data = {
          course_id: app.course_id,
          comment: app.rating.form.comment,
          stars: app.rating.form.stars
        }
        app.$http.post(url, data).then(res => {
          app.rating.form_loading = false
          if (res.body.status == 'success') {
            data.published_at = moment().format('YYYY-MM-DD h:mm:ss')
            data.course_rating_id = res.body.data.course_rating_id
            app.rating.my_rating = data
            app.rating.myCommentIsPublished = true
          }
        }, err => {
          app.rating.form_loading = false
        })
      }

    },

    editMyRating() {
      var app = this
      var url = api_url + 'course-ratings/update'
      app.rating.form_loading = true
      app.rating.form.course_id = app.course_id
      app.$http.post(url, app.rating.form).then(res => {
        app.rating.form_loading = false
        if (res.body.status == 'success') {
          app.rating.my_rating = app.rating.form
          app.rating.myCommentIsPublished = true
        }
      }, err => {
        app.rating.form_loading = false
      })
    },

    deleteMyRating() {
      var app = this
      var url = api_url + 'course-ratings/delete'
      app.$http.post(url, { 'course_rating_id': app.rating.my_rating.course_rating_id }).then(res => {
        if (res.body.status == 'success') {
          app.rating.myCommentIsPublished = false
          app.rating.my_rating = {}
          app.rating.form = Object.assign({}, app.rating.defaultForm)
        }
      }, err => {

      })
    },

    filterSponsorPosts(sponsor_id) {
      var app = this
      app.saveSponsorView(sponsor_id)
      var filtered = _.filter(app.sponsors_posts, (post) => { return post.sponsor_id == sponsor_id })
      var other_posts = _.filter(app.sponsors_posts, (post) => { return post.sponsor_id != sponsor_id })
      app.sponsors_posts_filtered = filtered
      other_posts.forEach((post) => {
        app.sponsors_posts_filtered.push(post)
      });
    },

    checkCoupon(course) {
      var app = this
      var url = api_url + 'coupons/apply-coupon'
      var data = {
        course_id: course,
        coupon_code: app.coupon_code
      }
      app.coupon_loading = true
      app.$http.post(url, data).then(res => {
        app.coupon_loading = false
        app.alert = true
        app.alert_type = res.body.status
        app.alert_message = res.body.message
        if (res.body.status == 'success') {
          location.reload();
        }
      }, err => {
        app.coupon_loading = false
      })
    },

    enrollToCourse(course) {
      var app = this
      var url = api_url + 'course-students/enroll-free-course'
      var data = {
        course_id: course,
      }
      app.coupon_loading = true
      app.$http.post(url, data).then(res => {
        app.coupon_loading = false
        app.alert = true
        app.alert_type = res.body.status
        app.alert_message = res.body.message
        if (res.body.status == 'success') {
          location.reload();
        }
      }, err => {
        app.coupon_loading = false
      })
    },

    openTab(tab_element) {
      window.scrollTo(0, this.$refs.tabs_section.$el.scrollWidth)
      this.course_tab = tab_element
    },

    setCookie() {
      var app = this
      let expires = "";
      let date = new Date();
      date.setTime(date.getTime() + 365 * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
      document.cookie = 'modalv1_course_' + app.course_id + "=closed" + expires + "; path=/";
      app.modal_course = false
    },
    
    saveFile(url, loading_target) {
      var app = this
      loading_target = loading_target === undefined ? app : loading_target
      var filename = url.substring(url.lastIndexOf("/") + 1).split("?")[0]
      app.$http.get(url, {
        responseType: 'blob',
        progress(e) {
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
