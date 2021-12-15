class Children {
    constructor({uid = ''}) {
        this.uid = uid,
        this.alert = true,
        this.alert_type = '',
        this.alert_message = '',
        this.dialog = false,
        this.delete_dialog = false,
        this.loading = false,
        this.children_courses_loading = false,
        this.form = true,
        this.child = {
            first_name: '',
            last_name: '',
            gender: '',
            birthdate: moment().format('YYYY-MM-DD')
        },
        this.default = {
            first_name: '',
            last_name: '',
            gender: '',
            user_id: this.uid,
            birthdate: moment().format('YYYY-MM-DD')
        },
        this.index = -1,
        this.children_courses = [],
        this.items = []
    }

    reset() {
        this.loading = false
        this.alert = false
        this.child = Object.assign({}, this.default)
        this.index = -1
    }

    load() {
        var app = this
        var url = api_url + 'children/get/' + this.uid
        app.loading = true
        Http.get(url).then(res => {
            if (res.length > 0) {
                app.items = res
                app.loadChildrenCourses()
            }
            app.loading = false
        }, err => {
            app.response({type: 'error'})
        })
    }

    loadChildrenCourses() {
        var app = this
        var url = api_url + 'child-courses/get-latest'
        var data = []
        app.items.forEach(e => {
            data.push(e.children_id)
        });

        app.children_courses_loading = true
        Http.post(url, data).then(res => {
            if (res.length > 0) {
                app.children_courses = res
            }
            app.children_courses_loading = false
        }, err => {
            app.response({type: 'error'})
        })
    }

    save() {
        var app = this
        app.active = false
        app.loading = true
        if (app.index >= 0) {
            var url = api_url + 'children/update'
            Http.put(url, app.child).then(res => {
                app.response(res.status, res.message)
                if(res.status == 'success') {
                    app.items[app.index] = Object.assign({}, app.child)
                }
                app.dialog = false
                app.reset()
            }, err => {
                app.response('error')
            })
        }
        else {
            var url = api_url + 'children/create'
            Http.post(url, app.child).then(res => {
                app.response(res.status, res.message)
                if(res.status == 'success') {
                    app.child.children_id = res.data.id
                    app.items.push(app.child)
                }
                app.dialog = false
                app.reset()
            }, err => {
                app.response('error')
            })
        }
    }

    delete() {
        var app = this
        app.active = false
        app.loading = true
        var url = api_url + 'children/delete'
        Http.delete(url, app.child).then(res => {
            app.response(res.status, res.message)
            if(res.status == 'success') {
                app.items.splice(1, app.index)
                app.delete_dialog = false
                app.reset()
            }
        }, err => {
            app.response('error')
        })
    }

    response(type = '', message = '') {
        this.loading = false
        this.alert = true
        this.alert_type = type
        this.alert_message = type == 'error' ? message == '' ? 'A apărut o eroare neașteptată, vă rugăm să încercați din nou.' : message : message
    }

    editDialog(item) {
        this.child = Object.assign({}, item)
        this.index = this.items.indexOf(item)
        this.dialog = true
    }

    deleteDialog(item) {
        this.child = Object.assign({}, item)
        this.index = this.items.indexOf(item)
        this.delete_dialog = true
    }

    getAge(date) {
        return moment().diff(date, 'years')
    }

}

