
/*VUE INSTANCE*/
Vue.use(VueTelInputVuetify, {
  vuetify,
});
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    tab: null,
    nav_tab: null,
    image_btns: false,
    image_upload_btn: false,
    loading: false,
    avatar_loading: false,
    edit_profile_loading: false,
    my_courses_loading: false,
    my_orders_loading: false,
    new_courses_loading: false,
    telephone: '',
    alert: false,
    alert_type: '',
    alert_message: '',
    preview_avatar_image: '',
    notifications: [],
    profile: {
      first_name: '',
      last_name: '',
      email: '',
      birthdate: '',
      gender: '',
      country_selected: '',
      state_selected: '',
      password: '',
      meta: [],
    },
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
    validations,
  },

  created() {
    check_google_user()
    this.initialize()
  },

  watch: {},

  mounted() {
  },

  methods: {

    initialize() {
      var app = this
      var url = api_url + 'members/get/' + uid
      if (app.sidebar_tab != null) {
        app[app.sidebar_tab] = true
      }
      app.$http.get(url).then(res => {
        if (res.body.length > 0) {
          app.profile = res.body[0]
          app.profile.meta = {
            teacher_telephone: res.body[0].meta.teacher_telephone,
            teacher_email: res.body[0].meta.teacher_email,
            bio: res.body[0].meta.bio
          }
          app.profile.old_avatar = app.profile.avatar
          app.preview_avatar_image = app.profile.avatar
          app.profile.user_id = uid
        }
      }, err => {

      })
    },

    saveProfile() {
      var app = this
      app.active = false
      app.edit_profile_loading = true
      var url = api_url + 'teachers/update'
      app.$http.post(url, app.profile).then(res => {
        app.alert = true
        app.alert_type = res.body.status
        app.alert_message = res.body.message
        app.edit_profile_loading = false
      }, err => {

      })
    },

    getInput(text, data) {
      this.profile.meta.teacher_telephone = data.number.international
    },

    prevImage(e) {
      var app = this
      const image = e.target.files[0]
      const reader = new FileReader()
      reader.readAsDataURL(image)
      reader.onload = e => {
        app.profile.avatar = image
        app.preview_avatar_image = e.target.result
        app.image_btns = true
      };
    },

    undoImagePreview() {
      var app = this
      app.preview_avatar_image = app.old_avatar
      app.image_btns = false
      app.image_upload_btn = false
    },

    updateAvatarImage() {
      var app = this
      let data = new FormData()
      app.avatar_loading = true
      data.append('avatar', app.profile.avatar)
      data.append('old_avatar', app.profile.old_avatar)
      var url = api_url + 'members/update-avatar'
      app.$http.post(url, data).then(res => {
        app.avatar_loading = false
        app.snackbar = true
        app.snackbar_text = res.body.message
        if (res.body.status == 'success') {
          app.profile.avatar = res.body.data.avatar
          app.profile.old_avatar = res.body.data.avatar
          app.preview_avatar_image = res.body.data.avatar
          app.image_upload_btn = false
          app.image_btns = false
        }
      }, err => {
        app.snackbar = true
        app.snackbar_text = 'Eroare neașteptată, încercați din nou'
        app.avatar_loading = false
      })
    },

  }
});