<v-col class="white px-12 py-md-8 info-container mx-md-6" cols="12" md="7" v-if="children_container">
    
    <?= new Controller\Template('account/parts/private/children/dialog') ?>

    <v-dialog v-model="children.delete_dialog" max-width="900px">
        <v-card>
            <v-toolbar class="gradient" elevation="0">
                <v-toolbar-title class="white--text">Îndepărtați copilul</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon @click="children.dialog = false" color="transparent">
                        <v-icon color="white">mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>

            <v-divider></v-divider>
            <v-card-text v-if="children.delete_dialog">
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <h4 class="text-center text-h5">
                                ¿Sunteți sigur că doriți să o eliminați? Odată ce a fost făcută, nu mai poate fi anulată
                            </h4>
                        </v-col>
                        <v-col class="d-flex justify-center" cols="12">
                            <v-btn color="error" @click="children.delete()" :loading="children.loading">
                                Da
                            </v-btn>

                            <v-btn @click="children.delete_dialog = false;children.reset()" :loading="children.loading">
                                Nu
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
    <v-row v-if="children.items.length > 0">
        <v-col class="d-flex justify-end" cols="12">
            <v-btn class="secondary white--text" @click="children.reset(); children.dialog = true;">Adăugați</v-btn>
        </v-col>
        <v-col cols="12">
            <v-row>
                <v-col cols="12" md="4" v-for="child in children.items">
                    <v-card :color="child.gender == 'M' ? 'primary' : '#e70f66'" class="mx-auto" max-width="344"
                        outlined>
                        <v-list-item three-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5 mb-1 white--text">
                                    {{ child.first_name + ' ' + child.last_name }}
                                </v-list-item-title>
                                <v-list-item-subtitle class="white--text">
                                    {{ children.getAge(child.birthdate) }} Ani
                                </v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-avatar size="70">
                                <v-icon color="white" size="64">
                                    {{ child.gender == 'M' ? 'mdi-face-man' : 'mdi-face-woman' }}
                                </v-icon>
                            </v-list-item-avatar>
                        </v-list-item>

                        <v-card-actions>
                            <v-btn color="white" @click="children.editDialog(child)" outlined rounded text>
                                Editați
                            </v-btn>

                            <v-btn class="white--text" color="red" @click="children.deleteDialog(child)" rounded>
                                Ștergeți
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
    <v-row class="px-16" v-else>
        <v-col class="d-flex justify-center" cols="12">
            <v-img src="<?= SITE_URL ?>/img/no-children.svg" max-width="40%"></v-img>
        </v-col>
        <v-col class="m-0" cols="12">
            <h4 class="text-h5 text-center">
                Nu ați înregistrat încă niciun copil
            </h4>
        </v-col>
        <v-col class="m-0 d-flex justify-center" cols="12">
            <v-btn class="secondary white--text" @click="children.reset(); children.dialog = true;">Adăugați</v-btn>
        </v-col>
    </v-row>
</v-col>