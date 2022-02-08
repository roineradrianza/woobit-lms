
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {
      tab: null,
      nav_tab: null,
      search: '',
      start_date_modal: false,
      start_date: '',
      category: '',
      loading: false,
      selection: 2,
      notifications: [],
      params: {
        search: url_params.get('search'),
        start_date: url_params.get('start_date'),
        category: url_params.get('category') != '' ? parseInt(url_params.get('category')) : ''
      }
    },

    computed: {
    },

    created () {
      this.search = this.params.search
      this.start_date = this.params.start_date
      this.category = this.params.category
    },

    mounted () {
    },

    methods: {

      searchCourse() {
        var app = this
        window.location = domain + '/cursuri/get?search=' + app.search + '&start_date=' 
        + app.start_date + '&category=' + app.category
      }

  	}
});