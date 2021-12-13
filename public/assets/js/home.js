
/*VUE INSTANCE*/
let vm = new Vue({
  vuetify,
  el: '#app-container',
  data: {
    loading: false,
    nav_tab: String,
    carousel: 0,
    search: '',
    notifications: [],
    carousel: 0,
  },

  computed: {
  },

  created() {
    check_google_user()
  },

  mounted() {
    window.addEventListener('scroll', (e) => {
      var container = this.$refs.header_menu.$el
      console.log(window.scrollY)
      if (window.scrollY >= 400) {
        container.classList.remove('bg-white')
        container.classList.add('white')
      }
      else {
        container.classList.remove('white')
        container.classList.add('bg-white')
      }
    })
  },

  methods: {
  }
});