class Rating {
    constructor({
        course_id = ''
    }) {
        this.course_id = course_id,
            this.alert = true,
            this.alert_type = '',
            this.alert_message = '',
            this.snackbar = false,
            this.snackbar_timeout = 3000,
            this.snackbar_text = '',
            this.dialog = false,
            this.delete_dialog = false,
            this.loading = false,
            this.items_loading = false,
            this.form = true,
            this.my_rating = {},
            this.items = [],
            this.loading = false,
            this.form_valid = true,
            this.form_loading = false,
            this.myCommentIsPublished =false,
            this.form_rules = {
                comment: [
                v => !!v || 'Ești obligat să scrii un comentariu',
                v => (v && v.length >= 10) || 'Trebuie să fie un comentariu mai lung de 10 caractere',
                ],
            },
            this.form = {
                comment: '',
                stars: 5,
            },
            this.defaultForm = {
                comment: '',
                stars: 5
            }
            this.index = -1,
            this.items = []
        this.load()
    }

    reset() {
        this.loading = false
        this.alert = false
        this.message = Object.assign({}, this.default)
        this.index = -1
    }

    load() {
        var app = this
        var url = api_url + 'course-ratings/get/' + app.course_id
        app.loading = true
        Http.get(url).then(res => {
            app.items = res;
            app.loading = false
        }, err => {
            app.loading = false
        })
        if (typeof basic_info !== 'undefined') {
            var url = api_url + 'course-ratings/get-mine/' + app.course_id
            app.loading = true
            Http.post(url).then(res => {
                if (res.length > 0) {
                    app.myCommentIsPublished = true
                    res[0].stars = parseInt(res[0].stars)
                    app.my_rating = res[0]
                }
                app.loading = false
            }, err => {
                app.loading = false
            })
        }
    }

    save() {
        var app = this
        app.active = false
        app.form_loading = true

        var data = {
            course_id: app.course_id,
            comment: app.form.comment,
            stars: app.form.stars
        }

        var url = api_url + 'course-ratings/create'
        Http.post(url, data).then(res => {
            app.form_loading = false
            app.response(res.status, res.message)
            if (res.status == 'success') {
                data.published_at = moment().format('YYYY-MM-DD h:mm:ss')
                data.course_rating_id = res.data.course_rating_id
                app.my_rating = data
                app.myCommentIsPublished = true
            }
        }, err => {
            app.form_loading = false
            app.response('error')
        })
    }

    deleteItem(item, index) {
        var app = this
        var url = api_url + 'course-ratings/delete'
        Http.post(url, { 'course_rating_id': item.course_rating_id }).then(res => {
            app.response(res.status, res.message)
          if (res.status == 'success') {
            app.items.splice(index, 1)
          }
        }, err => {
            app.response('error')
        })
    }

    editMyRating() {
        var app = this
        var url = api_url + 'course-ratings/update'
        app.form_loading = true
        app.form.course_id = app.course_id
        Http.post(url, app.form).then(res => {
          app.form_loading = false
          app.response(res.status, res.message)
          if (res.status == 'success') {
            app.my_rating = app.form
            app.myCommentIsPublished = true
          }
        }, err => {
          app.form_loading = false
          app.response('error')
        })
      }

    deleteMyRating() {
        var app = this
        var url = api_url + 'course-ratings/delete'
        Http.post(url, { 'course_rating_id': app.my_rating.course_rating_id }).then(res => {
            app.response(res.status, res.message)
            if (res.status == 'success') {
                app.myCommentIsPublished = false
                app.my_rating = {}
                app.form = Object.assign({}, app.defaultForm)
            }
        }, err => {
            app.response('error')
        })
    }

    response(type = '', message = '') {
        type == 'error' ? message == '' ? 'A apărut o eroare neașteptată, vă rugăm să încercați din nou.' : message : message
        this.loading = false
        this.alert = true
        this.alert_type = type
        this.snackbar = true
        this.snackbar_timeout = 3000
        this.alert_message, this.snackbar_text = message
    }

    editDialog(item) {
        this.message = Object.assign({}, item)
        this.index = this.items.indexOf(item)
        this.dialog = true
    }

    deleteDialog(item) {
        this.message = Object.assign({}, item)
        this.index = this.items.indexOf(item)
        this.delete_dialog = true
    }

    fromNow(date) {
        return moment(date).fromNow()
    }

    formatDate(date, format) {
        return moment(date).format(format)
    }

}