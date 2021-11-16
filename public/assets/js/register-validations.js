const validations = {
  selectRules: [
		v => !!v || 'Seleccione una opción',
	],

  usernameRules: [
    v => !!v || 'Nombre de usuario es requerido',
    v => (v && v.length <= 30) || 'El usuario debe ser menor a 30 caracteres',
  ],

  requiredRules: [
		v => !!v || 'Este campo es requerido',
	],

  nameRules: [
    v => !!v || 'Este campo es requerido',
    v => (v && v.length <= 60) || 'Debe ser menor a 60 caracteres',
  ],

  emailRules: [
    v => !!v || 'Este campo es requerido',
    v => /.+@.+\..+/.test(v) || 'Debe ser un correo electrónico válido',
  ],

  birthdateRules: [
    v => !!v || 'La fecha de nacimiento es requerida',
  ],

  agesGraduated: [
    v => !!v || 'Este campo es requerido',
    v => (v && v.length <= 3) || 'Debe debe ser menor a 3 caracteres',
  ],

  genderRules: [
    v => !!v || 'Debe seleccionar un género',
  ],

  telephoneRules: [
    v => !!v || 'Ingrese un número de télefono',
  ],

  countryRules: [
    v => !!v || 'Seleccione un país',
  ],

  countryStateRules: [
    v => !!v || 'Seleccione la provincia',
  ],

  passwordRules: [
    v => !!v || 'Ingrese una contraseña',
    v => (v && v.length >= 5 && v.length <= 20) || 'Debe ser mayor o igual a 5 caracteres y menor a 20 caracteres',
  ],

  passwordConfirmRules: [
    v => vm.checkPasswords() || 'Deben ambas coincidir con la contraseña',
  ],

}