const validations = {

  discountRules: [
    v => !!v || 'Este campo es requerido',
    v => (v && parseFloat(v) <= 100) || 'El descuento no puede ser mayor a 100',
  ],

  requiredRules: [
		v => !!v || 'Este campo es requerido',
	],

  nameRules: [
    v => (v && v.length <= 90) || 'Debe ser menor a 90 caracteres',
  ],

}