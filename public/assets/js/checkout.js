
Vue.use(VueTelInputVuetify, {
  vuetify,
});
moment.locale(app_language)
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
    birthdate_modal: false,
    validations,
    course_id: url_params.get('course_id'),
    section_id: url_params.get('section'),
    title: url_params.get('course'),
    extra: url_params.get('extra'),
    personal_info: basic_info,
    paypal: {},
    children: new Children({ uid: uid }),
    initial_pay: 0,
    stripeElements: Object,
    stripePayment: Object,
    genders: [
      {
        text: 'Bărbat',
        value: 'M'
      },
      {
        text: 'Femeie',
        value: 'F'
      },
    ],
    section: {},
    info: {
      course_id: '',
      total_pay: 0,
      children: [],
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

    AmountInUSD() {
      var amount = this.info.total_pay / this.info.meta.usd_tax_day
      var formatter = new Intl.NumberFormat('ru-RU', {
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
  },

  methods: {

    initialize() {
      var app = this
      var url = api_url + 'courses/get/' + app.course_id
      app.checkout_loading = true
      app.children.load()
      app.$http.get(url).then(res => {
        app.checkout_loading = false
        if (res.body.length > 0) {
          var course = res.body[0]
          app.info.course_id = app.course_id
          app.info.type = 1
          app.initial_pay = course.price
          app.getRONtoUSDTax()
          app.$http.get(api_url + 'course-sections/get/' + app.section_id).then(res => {
            if (res.body.length > 0) {
              app.checkout_loading = false
              app.section = res.body[0]
            }
          })
        }
      }, err => {

      })
    },

    fillPpCheckout() {
      var app = this
      total_pay = app.info.total_pay
      pp_pay = app.info.meta.USD
      if (typeof paypal === 'undefined') {
        return false
      }
      app.$refs.paypal_container != undefined ? app.$refs.paypal_container.innerHTML = '' : ''
      if (app.info.total_pay >= app.initial_pay) {
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
      }
    },

    fillStripeCheckout() {
      // Customize which fields are collected by the Payment Element
      var app = this
      var url = api_url + 'checkout/stripe-intent-payment'
      app.stripe_loading = true
      app.stripe_enabled = false
      var data = {
        total_pay: app.info.total_pay
      }
      app.$http.post(url, data).then( res => {
        app.stripe_loading = false
        if (res.body.hasOwnProperty('clientSecret')) {
          app.info.meta.stripeClientSecret = res.clientSecret
          app.stripeElements = stripe.elements({
            clientSecret: res.body.clientSecret
          })
          app.stripePayment = app.stripeElements.create("payment", {
            business: {
              name: 'Woobit'
            },
            billingDetails: {
              email: app.personal_info.email,
              name: app.personal_info.first_name + ' ' + app.personal_info.last_name,
              phone: app.personal_info.telephone,
              address: {
                line1: app.personal_info.address
              }
            }
          })
          app.stripePayment.mount("#payment-form")
          app.stripe_enabled = true
        }
      })
    },

    checkStripePaymentStatus() {
      var app = this
      let clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
      );
    
      if (!clientSecret) {
        return
      }

      var url = api_url + 'checkout/check-stripe-payment-intent/' + clientSecret
    
      let { paymentIntent } = stripe.retrievePaymentIntent(clientSecret)
      app.info.meta.stripe_payment_status = paymentIntent.status
    
      switch (paymentIntent.status) {
        case "succeeded":
          app.stripe_order_loading = true
          app.$http.get(api_url, app.info).then( res => {
            app.stripe_order_loading = false
            app.alert = true
            app.alert_message = res.body.message
            app.alert_type = res.body.status
          })
          break;
        case "processing":
          app.stripe_order_loading = true
          app.$http.get(api_url, app.info).then( res => {
            app.stripe_order_loading = false
            app.alert = true
            app.alert_message = res.body.message
            app.alert_type = res.body.status
          })
          break;
        case "requires_payment_method":
          app.alert = true
          app.alert_message = 'Plata dvs. nu a fost efectuată cu succes, vă rugăm să încercați din nou.'
          app.alert_type = 'warning'
          break;
        default:
          app.alert = true
          app.alert_message = 'Ceva a mers prost.'
          app.alert_type = 'error'
          break;
      }
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
      data.section = app.section

      var url = api_url + 'orders/create'
      app.$http.post(url, data).then(res => {
        app.loading_btn = false
        app.alert = true
        app.alert_message = res.body.message
        app.alert_type = res.body.status
        if (res.body.status == 'success') {
          app.already_paid = true
          window.location = domain + '/profil-lector/view?tab=orders_container'
        }
      }, err => {
        app.loading_btn = false
      })
    },

    getRONtoUSDTax() {
      var app = this
      var url = `https://freecurrencyapi.net/api/v2/latest?apikey=${free_currency_api_key}&base_currency=USD`
      if (app.info.meta.usd_tax_day <= 0) {
        app.$http.get(url).then(res => {
          if (res.body.data.hasOwnProperty('RON')) {
            app.info.meta.usd_tax_day = res.body.data.RON
            app.info.meta.USD = (app.info.total_pay / app.info.meta.usd_tax_day).toFixed(2)
            app.fillPpCheckout()
            app.fillStripeCheckout()
          }
        }, err => {

        })
      }
      else {
        app.info.meta.USD = (app.info.total_pay / app.info.meta.usd_tax_day).toFixed(2)
        app.fillPpCheckout()
        app.fillStripeCheckout()
      }
    },

    getFormatStartDate(date) {
      return moment(date).format('LL');
    },

    getFrecuencyText(frecuency, classes) {
      let frecuency_sentence = ''
      let frecuency_txt = ''
      switch (frecuency) {
        case '1':
          frecuency_txt = ' pe săptămână';
          if (classes <= 1) {
            frecuency_sentence = `O dată ${frecuency_txt}`;
          } else {
            frecuency_sentence = `De ${classes} ori ${frecuency_txt}`;
          }
          break;
      
        case '2':
          frecuency_txt = ' pe lună';
          if ($classes <= 1) {
              frecuency_sentence = `O dată ${frecuency_txt}`;
          } else {
              frecuency_sentence = `De ${classes} ori ${frecuency_txt}`;
          }
          break;
      }

      return frecuency_sentence
    },

  }
});
