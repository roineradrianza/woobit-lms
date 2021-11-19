<v-row class="login-container gradient pb-0 mb-0 py-16" justify="center">
    <v-col class="px-16 bg-white rounded" cols="11" md="8" lg="6">
        <h2 class="text-h2 pt-md-8 text-center">Conectați-vă.</h2>
        <v-form>
            <v-row class="px-8">
                <v-col cols="12">
                    <label class="body-1 font-weight-thin pl-1">Utilizator o Email</label>
                    <v-text-field v-model="email" name="email" class="mt-3" outlined>
                    </v-text-field>
                </v-col>
                <v-col cols="12">
                    <label class="body-1 font-weight-thin pl-1">Parola</label>
                    <v-text-field type="password" v-model="password" class="mt-3" outlined>
                    </v-text-field>
                </v-col>
                <v-row>
                    <?= new Controller\Template('components/alert') ?>
                </v-row>
                <v-btn class="white--text secondary mb-6 mt-4 py-6" :loading="loading" @click="signIn"
                    :disabled="email == '' || password == ''" block>Autentificare</v-btn>
                <v-btn class="mb-4 secondary--text font-weight-bold" href="<?= SITE_URL ?>/register" block text>
					Înregistrare
				</v-btn>
                <v-row justify="center">
                    <v-col class="p-0 mb-n4" cols="12">
                        <v-divider></v-divider>
                        <p class="text-h6 mt-2 text-center primary--text">Conectați-vă cu</p>
                    </v-col>
                    <v-btn class="ma-2 white--text padding- py-6" @click="googleSignIn">
                        <v-img class="myGoogleButton" src="<?= SITE_URL ?>/img/google-logo.png" width="1vw">
                        </v-img>
                    </v-btn>
                    <v-btn class="ma-2 white--text py-6" v-if="1 == 2">
                        <v-img src="<?= SITE_URL ?>/img/facebook-logo.svg" width="1vw"></v-img>
                    </v-btn>
                </v-row>
                <v-col class="mt-6" cols="12">
                    <a class="mb-13 secondary--text font-weight-bold d-block text-center" 
					@click="dialog = true">
						Mi-am uitat parola
					</a>
                </v-col>
            </v-row>
            <?= new Controller\Template('components/reset_password') ?>
        </v-form>
    </v-col>
</v-row>