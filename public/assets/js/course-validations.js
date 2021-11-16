const validations = {
  selectRules: [
		v => !!v || 'Seleccione una opción',
	],

  titleRules: [
    v => !!v || 'Este campo es requerido',
    v => (v && v.length <= 250) || 'El usuario debe ser menor a 250 caracteres',
  ],

  emailRules: [
    v => !!v || 'El correo electrónico es valido',
    v => /.+@.+\..+/.test(v) || 'Debe ser un correo electrónico',
  ],

  requiredRules: [
    v => !!v || 'Este campo es requerido',
  ],

  telephoneRules: [
    v => !!v || 'Ingrese un número de télefono',
  ],

}