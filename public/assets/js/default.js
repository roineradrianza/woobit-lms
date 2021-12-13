
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {
      nav_tab: String,
      notifications: [],
      carousel: 0,
    },

    computed: {
    },

    created () {
      check_google_user()
    },

});