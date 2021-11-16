/*
* const vuetify
* const validations
*/
/*VUE INSTANCE*/
const splitted_domain = window.location.href.split('/')
const lesson_id = splitted_domain[5]
let vm = new Vue({
    vuetify,
    el: '#full-learning-container',
    data: {
      tab: null,
      nav_tab: null,
      loading: false,
      join_loading: false,
      skills_container: false,
      selection: 1,
      zoom_countdown: 1000,
      show_button: false,
      meta: {
      },
      notifications: [],
      resources: [],
    },

    computed: {
    },

    watch: {

    },

    created () {
      this.initialize()
      this.initializeLessonResources()
    },

    mounted () {
    },

    methods: {
      initialize () {
        var app = this
        var url = api_url + 'course-lessons/get-meta-info/' + lesson_id
        app.$http.get(url).then( res => {
          if (res.body.length > 0) {
            res.body.forEach( (meta) => {
              app.meta[meta['lesson_meta_name']] = meta['lesson_meta_val']
              if (meta['lesson_meta_name'] == 'zoom_start_time') {
                countdown = app.getTimeDifference(meta['lesson_meta_val']) 
                app.zoom_countdown = countdown < 0 ? 0 : countdown
              }
            })
          }
        }, err => {

        })
      },

      initializeLessonResources () {
        var app = this
        var url = api_url + 'media/get-lesson-resources/' + lesson_id
        app.$http.get(url).then( res => {
          if (res.body.length > 0) {
            res.body.forEach((resource, resource_index) => {
              resource.loading = false
              resource.percent_loading_active = false
              resource.percent_loading = 0
              app.resources.push(resource)
            })
          }
        }, err => {

        })
      },

      transformSlotProps(props) {
        const formattedProps = {};

        Object.entries(props).forEach(([key, value]) => {
          formattedProps[key] = value < 10 ? `0${value}` : String(value);
        });

        return formattedProps;
      },

      getTimeDifference (t) {
        return moment(t).diff(moment().format());
      },

      formatDate (d) {
        return moment(d).format('LLL');
      },

      replaceString (s, d, r) {
        return s.replace(d, r)
      },

      getExt (file_name) {
        var url = file_name
        var splitted_url = url.split('/')
        var ext = splitted_url[splitted_url.length - 1].split('.')
        return ext[1]
      },

      getExtIcon (file_name) {
        var url = file_name
        var splitted_url = url.split('/')
        var ext = splitted_url[splitted_url.length - 1].split('.')
        var file_icon = ''
        switch (ext[1]) {
          case 'pdf':
            file_icon = 'pdf'
            break;
          case 'docx':
            file_icon = 'word'
            break;
          case 'doc':
            file_icon = 'word'
            break;
          case 'ppt':
            file_icon = 'powerpoint'
            break;
          case 'pptx':
            file_icon = 'powerpoint'
            break;
          case 'ppt':
            file_icon = 'powerpoint'
            break;
          case 'xls':
            file_icon = 'excel'
            break;
          default:
            file_icon = 'document'
            break;
        }
        return file_icon
      },

      saveFile (url, loading_target) {
        var app = this 
        loading_target = loading_target === undefined ? app : loading_target
        var filename = url.substring(url.lastIndexOf("/") + 1).split("?")[0];5
        app.$http.get(url, {
          responseType: 'blob',
          progress(e) {
            if (e.lengthComputable) {
              loading_target.percent_loading_active = true
              loading_target.percent_loading = (e.loaded / e.total ) * 100
            }
          }
        }).then( res => {
          var a = document.createElement('a');
          a.href = window.URL.createObjectURL(res.body); 
          a.download = filename;
          a.style.display = 'none';
          document.body.appendChild(a);
          a.click();
          delete a;
        })
      },

  	}
});