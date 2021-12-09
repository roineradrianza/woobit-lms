
Vue.use(VueTelInputVuetify, {
  vuetify,
});
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
    paypal: {},
    info: {
      course_id: '',
      total_pay: 0,
      payment_method: 'Paypal',
      meta: {
        USD: 0,
        usd_tax_day: 0
      }
    }
  },

  computed: {

    FullName() {
      return this.personal_info.first_name + ' ' + this.personal_info.last_name
    },

    AmountInBs() {
      var amount = this.info.meta.tax_day * this.info.total_pay
      var formatter = new Intl.NumberFormat('es-ES', {
        style: 'currency',
        currency: 'RON',
      });
      return formatter.format(amount)
    },

  },

  created() {
    check_google_user()
  },

  mounted() {
    this.initialize()
    this.getRONtoUSDTax()
  },

  methods: {

    initialize() {
      var app = this
      var url = api_url + 'courses/get/' + app.course_id
      app.checkout_loading = true
      app.$http.get(url).then(res => {
        app.checkout_loading = false
        if (res.body.length > 0) {
          var course = res.body[0]
          app.info.course_id = app.course_id
          app.info.type = 1
          app.info.total_pay = course.price

        }
      }, err => {

      })
    },

    fillPpCheckout() {
      var app = this
      total_pay = app.info.total_pay
      pp_pay = app.info.meta.USD
      paypal.Buttons({
        style: {
          color: 'blue',
          shape: 'pill',
          label: 'pay',
          height: 40
        },
        createOrder(data, actions) {
          // This function sets up the details of the transaction, including the amount and line item details.
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: pp_pay,
                breakdown: {
                  item_total: { value: pp_pay, currency_code: 'USD' }
                }
              },
              items: [{
                name: app.title,
                unit_amount: { value: pp_pay, currency_code: 'USD' },
                quantity: '1',
              }]
            }]
          });
        },
        onApprove(data, actions) {
          // This function captures the funds from the transaction.
          return actions.order.capture().then((details) => {
            app.info.meta.pp_order_id = details.id
            app.info.meta.pp_transaction_id = details.purchase_units[0].payments.captures[0].id
            app.info.meta.pp_state = 1
            app.info.meta.total_paid = pp_pay
            app.pay()
          });
        }
      }).render('#paypal-button-container');
    },

    fillPayUCheckout() {
      var url = `sandbox.api.payulatam.com`
      var data = {
      }
      app.$http.get(url).then(res => {
      }, err => {

      })
    },

    getInput(text, data) {
      this.personal_info.telephone = data.number.international
    },

    pay() {
      var app = this
      var data = app.info
      app.loading_btn = true
      data.meta.first_name = app.personal_info.first_name
      data.meta.user_email = app.personal_info.email
      data.meta.last_name = app.personal_info.last_name
      data.meta.telephone = app.personal_info.telephone
      data.meta.address = app.personal_info.address
      data.meta.course = app.title

      var url = api_url + 'orders/create'
      app.$http.post(url, data).then(res => {
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

    getRONtoUSDTax() {
      var app = this
      var url = `https://freecurrencyapi.net/api/v2/latest?apikey=${free_currency_api_key}&base_currency=USD`
      app.$http.get(url).then(res => {
        if (res.body.data.hasOwnProperty('RON')) {
          app.info.meta.usd_tax_day = res.body.data.RON
          app.info.meta.USD = (parseInt(app.info.total_pay) / app.info.meta.tax_day).toFixed(2)
          app.fillPpCheckout()
        }
      }, err => {

      })
    },

  }
});
