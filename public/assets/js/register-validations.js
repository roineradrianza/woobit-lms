const validations = {
  selectRules: [
		v => !!v || 'Selectați o opțiune',
	],

  usernameRules: [
    v => !!v || 'Numele de utilizator este necesar',
    v => (v && v.length <= 30) || 'Utilizatorul trebuie să aibă mai puțin de 30 de caractere',
  ],

  requiredRules: [
		v => !!v || 'Acest câmp este obligatoriu',
	],

  nameRules: [
    v => !!v || 'Acest câmp este obligatoriu',
    v => (v && v.length <= 60) || 'Trebuie să aibă mai puțin de 60 de caractere',
  ],

  emailRules: [
    v => !!v || 'Acest câmp este obligatoriu',
    v => /.+@.+\..+/.test(v) || 'Trebuie să fie o adresă de e-mail validă',
  ],

  birthdateRules: [
    v => !!v || 'Data nașterii este necesară',
  ],

  agesGraduated: [
    v => !!v || 'Acest câmp este obligatoriu',
    v => (v && v.length <= 3) || 'Trebuie să fie mai mic de 3 caractere',
  ],

  genderRules: [
    v => !!v || 'Trebuie să selectați un sex',
  ],

  telephoneRules: [
    v => !!v || 'Introduceți un număr de telefon',
  ],

  countryRules: [
    v => !!v || 'Selectați o țară',
  ],

  countryStateRules: [
    v => !!v || 'Selectați provincia',
  ],

  passwordRules: [
    v => !!v || 'Introduceți o parolă',
    v => (v && v.length >= 5 && v.length <= 20) || 'Trebuie să fie mai mare sau egală cu 5 caractere și mai mică de 20 de caractere.',
  ],

  passwordConfirmRules: [
    v => vm.checkPasswords() || 'Ambele trebuie să se potrivească cu parola',
  ],

}