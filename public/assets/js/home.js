
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

    created () {
      check_google_user()
    },

    mounted () {
      
    },

    methods: {
  	}
});