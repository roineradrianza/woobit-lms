/*
* const vuetify
* const validations
*/
moment.locale('es');
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {     
      previewImage: '',
      loading: false,
      approve_loading: false,
      rejectDialog: false,
      tab: null,
      nav_tab: null,
      notifications: [],
      order_id: url_params.get('order_id'),
      order: {},
      btn_approve_loading: false,
    },

    computed: {

      FullName () {
        return this.order.meta.first_name + ' ' + this.order.meta.last_name
      },

      AmountInBs () {
        var amount = this.order.meta.tax_day * this.order.total_pay 
        var percent = amount * 0.16
        amount = amount + percent
        var formatter = new Intl.NumberFormat('es-ES', {
          style: 'currency',
          currency: 'VES',
        });
        return formatter.format(amount)
      },

    },

    watch: {

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
        var app = this
        var url = api_url + 'orders/get/' + app.order_id
        app.table_loading = true
        var clientDateTime = Intl.DateTimeFormat().resolvedOptions()
        app.$http.post(url, {timezone: clientDateTime.timeZone}).then(res => {
          app.table_loading = false
          if (res.body.length > 0) {
            app.order = res.body[0]
          }
        }, err => {

        })
      },

      processOrder (action = 1) {

        var app = this
        var method = action === 1 ? 'approve' : 'reject'
        var url = api_url + 'orders/' + method + '/' + app.order.order_id
        app.approve_loading = true
        var data = app.order
        data.course_title = app.order.meta.hasOwnProperty('course') ? app.order.meta.course : ''
        app.$http.post(url, app.order).then(res => {
          app.approve_loading = false
          if (res.body.status == 'success') {
            app.order.status = action
            app.rejectDialog = false
          }
        }, err => {

        })

      },

      getStatus (status) {
        switch (parseInt(status)) {
          case 0:
            return {color: 'warning', name: 'Procesando'}
            break;

          case 1:
            return {color: 'success', name: 'Aprobada'}
            break;

          case 2:
            return {color: 'error', name: 'Rechazada'}
            break;

        }
      }

    }
});