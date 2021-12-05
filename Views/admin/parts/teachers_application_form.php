<v-card-text>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-alert icon="mdi-shield-lock-outline" prominent text type="info">
                            Acest formular este doar abilitat în modul lectură
                        </v-alert>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select v-model="editedItem.status" label="Starea cererii" :items="status" outlined>
                        </v-select>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12">
                <?= new Controller\Template('become-teacher/step-1', [
                        'object' => 'editedItem',
                        'form_mode' => 'readonly'
                    ]) ?>
            </v-col>

            <v-col cols="12">
                <?= new Controller\Template('become-teacher/step-2', [
                        'object' => 'editedItem',
                        'form_mode' => 'readonly'
                    ]) ?>
            </v-col>

            <v-col cols="12">
                <?= new Controller\Template('become-teacher/step-3', [
                        'object' => 'editedItem',
                        'form_mode' => 'readonly'
                    ]) ?>
            </v-col>

            <v-col cols="12">
                <?= new Controller\Template('become-teacher/step-4', [
                        'object' => 'editedItem',
                        'form_mode' => 'readonly'
                    ]) ?>
            </v-col>

            <v-col cols="12">
                <?= new Controller\Template('become-teacher/step-5', [
                        'object' => 'editedItem',
                        'form_mode' => 'readonly'
                    ]) ?>
            </v-col>
            <v-col cols="12">
                <v-divider></v-divider>
            </v-col>
            <v-col cols="12">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-alert icon="mdi-shield-lock-outline" prominent text type="info">
                            Acest formular este doar abilitat în modul lectură
                        </v-alert>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-select v-model="editedItem.status" label="Starea cererii" :items="status" outlined>
                        </v-select>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</v-card-text>

<v-card-actions class="px-8">
    <v-spacer></v-spacer>
    <v-btn color="secondary white--text" block @click="save">
        Stare de actualizare
    </v-btn>
</v-card-actions>