<v-row class="mb-16 pt-10">
    <v-col class="mx-auto" cols="12" md="8">
        <v-sheet class="rounded-xl contact-container">
            <v-form ref="contact_form" v-model="valid">
                <v-row class="px-md-16 px-8 py-12">
                    <v-col cols="12">
                        <h3 class="text-h4">
                        Scrie-ne un mesaj!

                        </h3>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field label="Nume" v-model="form.name" :rules="validations.requiredRules" filled flat></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field label="Adresa de email" v-model="form.email" :rules="validations.requiredRules" filled flat></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-textarea label="Mesaj" v-model="form.message" :rules="validations.requiredRules" filled flat></v-textarea>
                    </v-col>
					<v-col cols="12">
                    	<v-btn class="secondary py-4 white--text" @click="sendMessage" :loading="loading" :disabled="!valid" block>
                            Trimite
                        </v-btn>
					</v-col>
					<?= new Controller\Template('components/alert')?>
                </v-row>
            </v-form>
        </v-sheet>
    </v-col>
</v-row>