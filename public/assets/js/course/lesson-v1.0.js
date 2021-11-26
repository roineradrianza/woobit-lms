/*
* const vuetify
* const validations
*/
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#app-container',
    data: {
      loading: false,
      tab: false,
      nav_tab: false,
      selection: 1,
      notifications: [],
      items: [
        {
          text: 'Cursos',
          disabled: false,
          href: '../',
        },
        {
          text: 'Tecnología',
          disabled: false,
          href: '../category/tecnología',
        },
        {
          text: 'Programación de App',
          disabled: true,
          href: '../category/programacion-de-app',
        },
      ],
    },

    computed: {
    },

    created () {
    },

    mounted () {
    },

    methods: {
      hideSkills () {
        this.skills_container = false;
      }
  	}
});