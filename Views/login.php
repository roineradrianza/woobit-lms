				
				<v-row class="login-container pb-0 mb-0">
					<v-col class="px-16 pt-16" cols="12" md="5">
						<h2 class="text-h2 pt-md-16">Iniciar sesión.</h2>
						<p class="font-weight-light" v-if="1 == 2">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus, dignissimos, dolor. Animi eveniet vitae beatae, reiciendis praesentium aliquid temporibus soluta fugit fuga, distinctio mollitia.</p>
						<v-form>
							<v-row class="pr-md-16">
								<v-col cols="12">
									<label class="body-1 font-weight-thin pl-1">Usuario o Correo Electrónico</label>
									<v-text-field v-model="email" name="email" class="mt-3 fl-text-input" filled rounded dense></v-text-field>
								</v-col>
								<v-col cols="12">
									<label class="body-1 font-weight-thin pl-1">Contraseña</label>
									<v-text-field type="password" v-model="password" class="mt-3 fl-text-input" filled rounded dense></v-text-field>
								</v-col>
								<v-row>
									<?php echo new Controller\Template('components/alert') ?>
								</v-row>	
								<v-btn class="white--text secondary rounded-pill mb-6 mt-4 py-6" :loading="loading" @click="signIn" :disabled="email == '' || password == ''" block>Iniciar sesión</v-btn>
								<v-btn class="mb-4 secondary--text font-weight-bold" href="<?php echo SITE_URL ?>/register" block text>Registrarte</v-btn>
								<v-row class="d-flex justify-center">
									<v-col class="p-0 mb-n4" cols="12">
										<v-divider></v-divider>										
										<p class="text-h6 mt-2 text-center primary--text">Iniciar sesión con</p>
									</v-col>
									<v-btn class="ma-2 white--text padding- py-6" @click="googleSignIn">
							      <v-img class="myGoogleButton" src="<?php echo SITE_URL ?>/img/google-logo.png" width="1vw"></v-img>
							    </v-btn>
									<v-btn class="ma-2 white--text py-6" v-if="1 == 2">
							      <v-img src="<?php echo SITE_URL ?>/img/facebook-logo.svg" width="1vw"></v-img>
							    </v-btn>
								</v-row>
								<v-col class="mt-6" cols="12">
									<a class="mb-13 secondary--text font-weight-bold d-block" @click="dialog = true">Olvidé mi contraseña</a>
								</v-col>
							</v-row>
							<?php echo new Controller\Template('components/reset_password') ?>
						</v-form>
					</v-col>
					<v-col class="secondary px-16 d-flex align-end" cols="12" md="7">
						<v-sheet class="mx-auto my-auto rounded-lg quote-container" color="white">
							<h3 class="text-h5 font-weight-thin">"La <span class="text-uppercase font-weight-bold">educación</span> es el <strong>pasaporte</strong>  hacia el <strong>futuro</strong>, el mañana pertenece a aquellos que se preparan para él en el día de hoy."</h3>
							<h3 class="text-h5 font-weight-bold text-center text-md-right">- Malcolm X</h3>
						</v-sheet>
					</v-col>
				</v-row>