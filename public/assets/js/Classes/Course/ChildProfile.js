class ChildProfile {
    constructor() {
        this.child_id = url_params.get('child_id')
        this.alert = true
        this.dialog = true
        this.form = true
        this.child_selected = {}
        this.student_materials_selected = {}
        this.items = []
    }

    save() {
        var app = this
        app.dialog = false
    }

    filterAndSelect(items) {
        var app = this
        app.items = items
        app.child_selected = app.child_id != null ? app.items.find(e => e.user_id == app.child_id) : {}
        window.addEventListener('DOMContentLoaded', () => {
            app.child_id != null ? app.dialog = false : ''
        })
    }

}