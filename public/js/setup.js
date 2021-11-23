const domain = window.location.origin
const current_url = window.location.href
const url_params = new URLSearchParams(window.location.search);
const api_url = domain + "/api/"
const google_api_key = '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'
const google_client_key = "815646876780-esiladq6m2oak54mier5r6upt2qa4kuj.apps.googleusercontent.com"
const fb_app_id = '701132754096805'
const fb_secret_key = "44cf119ba1352cc9a0aa2700890850f3"
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
