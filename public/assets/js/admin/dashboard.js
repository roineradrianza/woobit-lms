/*VUE INSTANCE*/
Vue.component("gchart", VueGoogleCharts.GChart);
let vm = new Vue({
    vuetify,
    el: '#full-learning-container',
    data: {
      loading: false,
      drawer: true,
      selectedItem: 1,
      chartData: [
        ['Year', 'Ventas', 'Gastos', 'Ganancias'],
        ['2014', 1000, 400, 200],
        ['2015', 1170, 460, 250],
        ['2016', 660, 1120, 300],
        ['2017', 1030, 540, 350]
      ],
      chartOptions: {
        chart: {
          title: 'Company Performance',
          subtitle: 'Sales, Expenses, and Profit: 2014-2017',
        },
      }
    },

    computed: {

    },

    created () {
      check_google_user()
    },

    mounted () {
    },

    methods: {
  	}
});