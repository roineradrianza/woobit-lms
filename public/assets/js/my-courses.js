/*
*/
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {     
      nav_tab: null,
      notifications: [],
      loading: false,
      search: '',
      courses: [],
      filtered_courses: [],
    },

    computed: {
    },

    watch: {
        search() {
            this.searchCourse()
        }
    },

    created () {
      window.onload = () => {
        check_google_user() 
      }
      this.initialize()
    },

    mounted () {
    },

    methods: {

      initialize () {
        var url = api_url + 'courses/get-own-courses/' + uid
        this.loading = true
        this.$http.get(url).then(res => {
          this.loading = false
          this.courses = res.body
          this.filtered_courses = res.body
        }, err => {

        })
      },

      searchCourse() {
          var search = this.search
          this.filtered_courses = this.courses.filter( course => {
            return course.title.toLowerCase().includes(search.toLowerCase())
          })
      },

      save () {
        var app = this
        app.loading = true
        var course = app.editedItem
        let data = new FormData()
        data.append('featured_image', course.featured_image)
        data.append('title', course.title)
        data.append('duration', course.duration)
        data.append('price', parseFloat(course.price))
        data.append('category_id', course.category_id)
        data.append('subcategory_id', course.subcategory_id)
        data.append('level', course.level)
        data.append('active', course.active)
        data.append('platform_owner', course.platform_owner)
        data.append('meta', JSON.stringify(course.meta))
        var editedIndex = app.editedIndex
        if (editedIndex > -1) {
          data.append('user_id', course.user_id)
          data.append('course_id', course.course_id)
          var url = api_url + 'courses/update'
          app.$http.post(url, data).then(res => {
            if (res.body.status == "success") {
              course.featured_image = res.body.data.featured_image
              course.slug = res.body.data.slug
              Object.assign(app.courses[editedIndex], course)              
            }
            app.close()
            app.loading = false
          }, err => {
            app.loading = false
          })
        } else {
          var url = api_url + 'courses/create'
          app.$http.post(url, data).then(res => {
            course.date = current_date
            if (res.body.status == 'success') {
              course.course_id = res.body.data.course_id
              course.slug = res.body.data.slug
              course.featured_image = res.body.data.featured_image
              app.courses.push(course)
            }
            app.close()
            app.loading = false
          }, err => {
            app.loading = false
            app.close()
          })
        }
      },

      formatDate (d, f) {
        return moment(d).format(f);
      },

  	}
});