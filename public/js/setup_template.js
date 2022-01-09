const domain = window.location.origin
const current_url = window.location.href
const url_params = new URLSearchParams(window.location.search);
const api_url = domain + "/api/"
const google_api_key = ''
const google_client_key = ""
const fb_app_id = ''
const fb_secret_key = ""
const app_language = 'en'
let date =  new Date()
const current_date = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
/*VUE PLUGINS*/
/*VUETIFY OPTIONS AND SET UP*/
const vuetify_opts = {    
  theme: {
    themes: theme_setup,
  },
  lang: {
    current: 'ro',
  },
};

const vuetify = new Vuetify(vuetify_opts);
