const validations = {

  titleRules: [
    v => !!v || 'Acest câmp este obligatoriu',
    v => (v && v.length <= 100) || 'Nu poate depăși 100 de caractere',
  ],

  featuredImageRules: [
    v => v.size > 0 || 'Trebuie să selectați o imagine',
    v => !v || v.size < 4000000 || 'Imaginea nu trebuie să fie mai mare de 4 MB!'
  ],

  requiredRules: [
    v => !!v || 'Acest câmp este obligatoriu',
  ],

  descriptionRules: [
    v => !!v || 'Acest câmp este obligatoriu',
    v => (v && v.length <= 65) || 'Nu poate depăși 65 de caractere',
  ],

  minRules: [
    v => (v > 0) || 'Nu poate fi 0',
  ],

  maxRules: [
    v => (v > 1) || 'Nu poate fi 1',
  ],
}