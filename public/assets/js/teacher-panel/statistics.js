/*
 */
/*VUE INSTANCE*/
Vue.component('line-chart', {
	extends: VueChartJs.Bar,
	mixins: VueChartJs.mixins.reactiveProp,
	props: ['chartdata', 'options'],
	mounted() {
		this.renderChart(this.chartdata, {
			responsive: true,
			maintainAspectRatio: true,
		})
	}
})
let vm = new Vue({
	vuetify,
	el: '#app-container',
	data: {
		nav_tab: null,
		notifications: [],
		loading: false,
		search: '',
		courses: [],
		total_students: [],
		total_class_hours: 0,
		chart: {
			loading: false,
			monthly_data: {
				current_year: moment().format('YYYY'),
				months: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', ],
				labels: [
					'Ianuarie', 'Februarie', 'Martie',
					'Aprilie', 'Mai', 'Iunie', 'Iulie', 'August',
					'Septembrie', 'Octombrie', 'Noiembrie', 'Decembrie'
				],
				datasets: [{
						label: 'Total ore',
						backgroundColor: vuetify.preset.theme.themes.light.secondary,
						data: []
					},
				]
			},
			weekly_data: {
				current_day: moment().format('YYYY-MM-DD'),
				labels: [],
				datasets: [{
						label: 'Total ore',
						backgroundColor: vuetify.preset.theme.themes.light.secondary,
						data: []
					},
				]
			},
		},
		current_tz: moment.tz.guess()
	},

	computed: {},

	created() {
		window.onload = () => {
			check_google_user()
		}
	},

	mounted() {
		this.initialize()		
	},

	methods: {

		initialize() {
			var app = this
			var url = api_url + 'courses/get-own-courses-and-lessons/' + uid
			app.total_class_hours = 0
			app.courses = []
			
			app.loading = true

			app.$http.get(url).then(res => {
				if (res.body.length > 0) {
					res.body.forEach( (course, course_index) => {
						if (course.status != 1) {
							res.body.splice(course_index, 1)
						}
					});
					app.courses = res.body
				}
				
			}).then( () => {
				url = api_url + 'courses/get-all-students/' + uid
				app.$http.get(url).then( res => {
					app.total_students = res.body
					app.loading = false
					app.getTotalClassesHours()
				})
			})
		},

		getTotalClassesHours() {
			var app = this
			for (var i = 0; i < 8; i++) {
				app.chart.weekly_data.labels[i] = moment(app.chart.weekly_data.current_day).subtract(7 - i, 'days').format('MM-DD')
			}

			var lessons = []
			var current_date = moment()

			app.courses.forEach( course => {
				course.lessons.forEach( lesson => {
					if (lesson.meta.hasOwnProperty('zoom_date') 
						&& moment(lesson.meta.zoom_date).isBefore(current_date)) {
							if (lesson.meta.hasOwnProperty('zoom_duration') 
							&& lesson.meta.zoom_duration !== undefined 
							&& lesson.meta.zoom_duration != '') {
								app.total_class_hours = app.total_class_hours + parseInt(lesson.meta.zoom_duration)
							}
					}
					lessons.push(lesson)
				})
			})

			app.total_class_hours = app.total_class_hours > 0 ? parseFloat(app.total_class_hours / 60).toFixed(1) : 0 

			app.chart.weekly_data.labels.forEach((e, i) => {
				app.chart.weekly_data.datasets[0].data[i] = 0

				var filtered_date = lessons.filter(lesson => {
				  return lesson.meta.zoom_date == moment().format('YYYY-') + e
				});

				filtered_date.forEach(item => {
					if(item.meta.hasOwnProperty('zoom_duration') && item.meta.zoom_duration !== undefined && item.meta.zoom_duration != '') {
						app.chart.weekly_data.datasets[0].data[i] = app.chart.weekly_data.datasets[0].data[i] 
						+ (item.meta.zoom_duration == 'undefined' ? 0 : parseInt(item.meta.zoom_duration))
					}
				});

				app.chart.weekly_data.datasets[0].data[i] = app.chart.weekly_data.datasets[0].data[i] > 0 
				? parseFloat(app.chart.weekly_data.datasets[0].data[i] / 60).toFixed(2) : 0
			})

			app.chart.monthly_data.months.forEach((e, i) => {
				app.chart.monthly_data.datasets[0].data[i] = 0

				var filtered_month = lessons.filter(lesson => {
					return moment(lesson.meta.zoom_date).format('YYYY-MM') == moment().format('YYYY-') + e
				})

				filtered_month.forEach(item => {
					if(item.meta.hasOwnProperty('zoom_duration') && item.meta.zoom_duration !== undefined && item.meta.zoom_duration != '') {
						app.chart.monthly_data.datasets[0].data[i] = app.chart.monthly_data.datasets[0].data[i] 
					  	+ parseInt(item.meta.zoom_duration)
					}
				})

				app.chart.monthly_data.datasets[0].data[i] = app.chart.monthly_data.datasets[0].data[i] > 0 
				? parseFloat(app.chart.monthly_data.datasets[0].data[i] / 60).toFixed(2) : 0
			})

			app.$refs.weekly_chart !== undefined ? app.$refs.weekly_chart.renderChart(app.chart.weekly_data) : ''
			app.$refs.monthly_chart !== undefined ? app.$refs.monthly_chart.renderChart(app.chart.monthly_data) : ''
		},

		getTimeDifference(t, timezone) {
			return moment(t).tz(timezone).diff(moment().tz(this.current_tz).format());
		},

		formatDate(d, f) {
			return moment(d).format(f);
		},

	}
});