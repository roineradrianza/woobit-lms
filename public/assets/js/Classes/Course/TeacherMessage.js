class LessonMessage {
    constructor({ uid = '', lesson_id = '' }) {
        this.lesson_id = lesson_id,
            this.uid = uid,
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
            this.message = {
                message: '',
                lesson_id: this.lesson_id,
                user_id: this.uid,
                created_at: moment()
            },
            this.default = {
                message: '',
                lesson_id: this.lesson_id,
                user_id: this.uid,
                created_at: moment()
            },
            this.index = -1,
            this.items = []
    }

    reset() {
        this.loading = false
        this.alert = false
        this.message = Object.assign({}, this.default)
        this.index = -1
    }

    load() {
        var app = this
        var url = api_url + 'lesson-messages/get/' + this.lesson_id
        app.loading = true
        Http.get(url).then(res => {
            if (res.length > 0) {
                app.items = res
            }
            app.loading = false
        }, err => {
            app.response({ type: 'error' })
        })
    }

    save() {
        var app = this
        app.active = false
        app.loading = true
        if (app.message.message == '') {
            app.response('error', 'Câmpul mesajului nu poate fi gol')
            return false
        }
        if (app.index >= 0) {
            var url = api_url + 'lesson-messages/update'
            Http.put(url, app.message).then(res => {
                app.response(res.status, res.message)
                if (res.status == 'success') {
                    app.load()
                }
                app.dialog = false
                app.reset()
            }, err => {
                app.response('error')
            })
        }
        else {
            var url = api_url + 'lesson-messages/create'
            Http.post(url, app.message).then(res => {
                app.response(res.status, res.message)
                if (res.status == 'success') {
                    app.message.lesson_message_id = res.data.id
                    app.items.unshift(app.message)
                }
                app.dialog = false
                app.reset()
            }, err => {
                app.response('error')
            })
        }
    }

    deleteItem() {
        var app = this
        app.active = false
        app.loading = true
        var url = api_url + 'lesson-messages/delete'
        Http.delete(url, app.message).then(res => {
            app.response(res.status, res.message)
            if (res.status == 'success') {
                app.load()
                app.delete_dialog = false
                app.reset()
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

}

