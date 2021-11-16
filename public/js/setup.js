const domain = window.location.origin
const current_url = window.location.href
const url_params = new URLSearchParams(window.location.search);
const api_url = domain + "/api/"
const google_api_key = 'AIzaSyAaiN6mUmjX2r78VQ_nXsddb3xwJFpc21o'
const google_client_key = "221145536764-dtghmhr3lp61o07o1sp9ecruoqq6atv2.apps.googleusercontent.com"
const fb_app_id = '701132754096805'
const fb_secret_key = "44cf119ba1352cc9a0aa2700890850f3"
let date =  new Date()
const current_date = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
/*VUE PLUGINS*/
/*VUETIFY OPTIONS AND SET UP*/
const vuetify_opts = {    
  theme: {
    themes: theme_setup,
  }
};

const vuetify = new Vuetify(vuetify_opts);
