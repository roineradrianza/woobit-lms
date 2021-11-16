/*
* const vuetify
* const validations
*/
moment.locale('es');
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#full-learning-container',
    data: {     
      previewImage: '',
      loading: false,
      table_loading: false,
      btn_approve_loading: false,
      approve_loading: false,
      dialog: false,
      dialogOrderPreview: false,
      dialogOrderDelete: false,
      rejectDialog: false,
      valid: false,
      drawer: true,
      modal: false,
      selectedItem: 5,
      validations: {
        email: [
          v => !!v || 'El correo electrónico es valido',
          v => /.+@.+\..+/.test(v) || 'Debe ser un correo electrónico',
        ],
      },
      true_false: [
        {
          text: 'Activo',
          value: '1'
        },
        {
          text: 'Inactivo',
          value: '0'
        },
      ],
      payments: {
        items: [],
        processing_items: [],
        headers: [
          { text: 'Nombre', align: 'start', value: 'name' },
          { text: 'Acciones', value: 'actions', align:'center', sortable: false },
        ],
        editedIndex: -1,
        editedItem: {},
        defaultItem: {
          name: '',
          meta: {},
        },
      },
      orders: {
        search: '',
        items: [],
        headers: [
          { text: 'ID', align: 'start', value: 'order_id' },
          { text: 'Fecha', align: 'start', value: 'registered_at' },
          { text: 'Monto', align: 'start', value: 'amount' },
          { text: 'Método de Pago', align: 'start', value: 'payment_method' },
          { text: 'Estado', align: 'start', value: 'status' },
          { text: 'Acciones', value: 'actions', align:'center', sortable: false },
        ],
        editedIndex: -1,
        editedItem: {},
        defaultItem: {
          name: '',
          meta: {},
        },
      },
    },

    computed: {

      FullName () {
        return this.orders.editedItem.meta.first_name + ' ' + this.orders.editedItem.meta.last_name
      },

      formTitle () {
        return this.editedIndex === -1 ? 'Crear método de pago' : 'Editar método de pago'
      },   

      AmountInBs () {
        var amount = this.orders.editedItem.meta.tax_day * this.orders.editedItem.total_pay 
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
      dialog (val) {
        val || this.close()
      },

      dialogOrderPreview (val) {
        val || this.closeOrderPreview()
      },

      dialogOrderDelete (val) {
        val || this.closeOrderDelete()
      },
      
    },

    created () {
      window.onload = () => {
        check_google_user() 
      }
      this.editedItem = this.defaultItem
      this.initialize()
      this.initializeOrders()
    },

    mounted () {
    },

    methods: {

      initialize () {
        var url = api_url + 'payments/get'
        this.table_loading = true
        this.$http.get(url).then(res => {
          this.table_loading = false
          this.payments.items = res.body
        }, err => {

        })
      },

      initializeOrders () {
        var url = api_url + 'orders/get'
        this.table_loading = true
        var clientDateTime = Intl.DateTimeFormat().resolvedOptions()
        this.$http.post(url, {timezone: clientDateTime.timeZone}).then(res => {
          this.table_loading = false
          this.orders.items = res.body
          this.filterProcessingOrder()
        }, err => {

        })
      },

      filterProcessingOrder () {
        var app = this
        var items = app.orders.items.filter( (item) => {
          return parseInt(item.status) == 0 
        })
        app.orders.processing_items = items
      },

      editItem (item) {
        this.payments.editedIndex = this.payments.items.indexOf(item)
        this.payments.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      previewOrderItem (item) {
        this.orders.editedIndex = this.orders.items.indexOf(item)
        this.orders.editedItem = Object.assign({}, item)
        this.dialogOrderPreview = true
      },

      deleteOrderItem (item) {
        this.orders.items.editedIndex = this.orders.items.indexOf(item)
        this.orders.editedItem = Object.assign({}, item)
        this.dialogOrderDelete = true
      },

      deleteOrderItemConfirm () {
        var id = this.orders.editedItem.order_id;
        var url = api_url + 'orders/delete'
        this.$http.post(url, {order_id: id}).then(res => {
            this.orders.items.splice(this.editedIndex, 1)
            this.closeOrderDelete()
            this.filterProcessingOrder()
          }, err => {
          this.closeOrderDelete()
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.payments.editedItem = Object.assign({}, this.payments.defaultItem)
          this.payments.editedIndex = -1
        })
      },

      closeOrderDelete () {
        this.dialogOrderDelete = false
        this.$nextTick(() => {
          this.orders.editedItem = Object.assign({}, this.orders.defaultItem)
          this.orders.editedIndex = -1
        })
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.payments.editedItem = Object.assign({}, this.payments.defaultItem)
          this.payments.editedIndex = -1
        })
      },

      closeOrderPreview () {
        this.dialogOrderPreview = false
        this.$nextTick(() => {
          this.orders.editedItem = Object.assign({}, this.orders.defaultItem)
          this.orders.editedIndex = -1
        })
      },

      save () {
        var app = this
        app.loading = true
        var payment = app.payments.editedItem
        let data = new FormData()
        data.append('payment_method_id', payment.payment_method_id)
        data.append('meta', JSON.stringify(payment.meta))
        var editedIndex = app.payments.editedIndex
        var url = api_url + 'payments/update'
        app.$http.post(url, data).then(res => {
          if (res.body.status == "success") {
            Object.assign(app.payments.items[editedIndex], payment)              
          }
          app.close()
          app.loading = false
        }, err => {
          app.loading = false
        })
      },

      processOrder (action = 1) {
        var app = this
        var method = action === 1 ? 'approve' : 'reject'
        var url = api_url + 'orders/' + method + '/' + app.orders.editedItem.order_id
        app.approve_loading = true
        var data = app.orders.editedItem
        data.course_title = app.orders.editedItem.meta.hasOwnProperty('course') ? app.orders.editedItem.meta.course : ''
        app.$http.post(url, data).then(res => {
          app.approve_loading = false
          if (res.body.status == 'success') {
            app.orders.editedItem.status = action
            Object.assign(app.orders.items[app.orders.editedIndex], app.orders.editedItem)
            app.filterProcessingOrder()
            app.rejectDialog = false
            app.dialogOrderPreview = false
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