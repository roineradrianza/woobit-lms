
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {
      already_paid: false,
      loading: false,
      loading_btn: false,
      alert: false,
      alert_type: false,
      alert_message: false,
      tab: null,
      nav_tab: null,
      notifications: [],
      course_id: url_params.get('course_id'),
      title: url_params.get('course'),
      extra: url_params.get('extra'),
      personal_info: basic_info,
      bs_bank_transfer: {},
      pagomovil: {},
      zelle: {},
      paypal: {},
      info: {
        course_id: '',
        total_pay: 0,
        payment_method: '',
        meta: {
          ref: '',
          total_pay_bs: 0,
          tax_day: 0
        }
      }
    },

    computed: {

      FullName () {
        return this.personal_info.first_name + ' ' + this.personal_info.last_name
      },

      AmountWithIVA () {
        var amount = this.info.meta.tax_day * this.info.total_pay 
        var percent = amount * 0.16
        amount = amount + percent
        var formatter = new Intl.NumberFormat('es-ES', {
          style: 'currency',
          currency: 'VES',
        });
        return formatter.format(amount)
      },

      AmountInBs () {
        var amount = this.info.meta.tax_day * this.info.total_pay 
        var formatter = new Intl.NumberFormat('es-ES', {
          style: 'currency',
          currency: 'VES',
        });
        return formatter.format(amount)
      },

      Document () {
        if (this.info.payment_method == 'Bank Transfer(Bs)') {
          return this.bs_bank_transfer.document_type + '-' + this.bs_bank_transfer.document_id
        }
        else if (this.info.payment_method == 'PagoMovil') {
          return this.pagomovil.document_type + '-' + this.bs_bank_transfer.document_id
        }
        
      },

    },

    created () {
      check_google_user()
    },

    mounted () {
      this.initialize()
    },

    methods: {

      initialize () {
        var app = this
        var url = api_url + 'courses/get/' + app.course_id
        app.checkout_loading = true
        app.$http.get(url).then( res => {
          app.checkout_loading = false
          if (res.body.length > 0) {
            var course = res.body[0]
            app.info.course_id = app.course_id
            app.info.type = 1
            if (app.extra == 'certified') {
              app.title = 'Certificado de ' + app.title
              app.info.type = 2
              app.info.total_pay = course.meta.certified_price
            }
            else {
              app.info.total_pay = course.price
            }
            app.getUSDtoBSTax()
            app.getPaymentMethods()
            app.fillPpCheckout()
          }
        }, err => {

        })
      },

      fillPpCheckout () {
        var app = this
        total_pay = app.info.total_pay
        pp_pay = Math.round(parseFloat(total_pay) + ((5.4 * app.info.total_pay) / 100)) + 0.30
        paypal.Buttons({
          style: {
            color:  'blue',
            shape:  'pill',
            label:  'pay',
            height: 40
          },
          createOrder (data, actions) {
            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
              purchase_units: [{
                amount: {
                  value: pp_pay,
                  breakdown: {
                    item_total: {value: pp_pay, currency_code: 'USD'}
                  }
                },
                items: [{
                  name: app.title,
                  unit_amount: {value: pp_pay, currency_code: 'USD'},
                  quantity: '1',
                }]
              }]
            });
          },
          onApprove (data, actions) {
            // This function captures the funds from the transaction.
            return actions.order.capture().then( (details) => {
              app.info.meta.pp_order_id = details.id
              app.info.meta.pp_transaction_id = details.purchase_units[0].payments.captures[0].id
              app.info.meta.pp_state = 1 
              app.info.meta.total_paid = pp_pay
              app.pay()
            });
          }
        }).render('#paypal-button-container');
      },

      pay () {
        var app = this
        var data = app.info
        data.meta.total_pay_bs = app.info.meta.tax_day * app.info.total_pay
        app.loading_btn = true
        data.meta.first_name = app.personal_info.first_name
        data.meta.user_email = app.personal_info.email
        data.meta.last_name = app.personal_info.last_name
        data.meta.telephone = app.personal_info.telephone
        data.meta.course = app.title
        switch (data.payment_method) {
          case 'Zelle':
            data.meta.email = app.zelle.email
            data.meta.owner = app.zelle.owner
            break;

          case 'Bank Transfer(Bs)':
            data.meta.document = app.bs_bank_transfer.document_type + '-' + app.bs_bank_transfer.document_id
            data.meta.owner = app.bs_bank_transfer.owner
            data.meta.bank = app.bs_bank_transfer.bank
            data.meta.bank_account = app.bs_bank_transfer.bank_account
            break;
          
          case 'PagoMovil':
            data.meta.document = app.pagomovil.document_type + '-' + app.pagomovil.document_id
            data.meta.owner = app.pagomovil.owner
            data.meta.bank = app.pagomovil.bank
            data.meta.telephone = app.pagomovil.telephone
            break;
        }
        var url = api_url + 'orders/create'
        app.$http.post(url, data).then( res => {
          app.loading_btn = false
          app.alert = true
          app.alert_message = res.body.message
          app.alert_type = res.body.status
          if (res.body.status == 'success') {
            app.already_paid = true
            window.location = domain + '/profile/?tab=orders_container'
          }
        }, err => {
          app.loading_btn = false
        })
      },

      getPaymentMethods () {
        var app = this
        var url = api_url + 'payments/get'
        app.payment_loading = true
        app.$http.get(url).then(res => {
          app.payment_loading = false
          res.body.forEach( (e) => {
            switch (e.name) {
              case 'Zelle':
                app.zelle = e.meta
                break;

              case 'Bank Transfer(Bs)':
                app.bs_bank_transfer = e.meta
                break;

              case 'PagoMovil':
                app.pagomovil = e.meta
                break;
            }
          });
        }, err => {

        })
      },

      getUSDtoBSTax () {
        var app = this
        var url = 'https://s3.amazonaws.com/dolartoday/data.json'
        app.$http.get(url).then(res => {
          if (res.body.hasOwnProperty('USD')) {
            app.info.meta.tax_day = res.body.USD.dolartoday
          }
        }, err => {

        })
      },

      disableByPayment () {
        var app = this
        var payment_method = app.info.payment_method
        var zelle = app.zelle
        var bs_bank_transfer = app.bs_bank_transfer
        switch (payment_method) {

          case 'Zelle':
            if (app.info.meta.ref == '') {
              return true
            }
            return false
            break;

          case 'Bank Transfer(Bs)':
            if (app.info.meta.ref == '') {
              return true
            }
            return false
            break;

          case 'PagoMovil':
            if (app.info.meta.ref == '') {
              return true
            }
            return false
            break;
  
          case 'Paypal':
            return false
            break;

          default:
            return true
            break;

        }
      }
    }
});
