<template>
    <v-toolbar class="bg-transparent" flat>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="95%" @click:outside="dialog = false">
            <template v-slot:activator="{ on, attrs }">
                <v-btn color="secondary" dark pill class="mb-2" v-bind="attrs" v-on="on">
                    <v-icon>mdi-plus</v-icon>
                    Adăugați curs
                </v-btn>
            </template>
            <v-card>
                <v-toolbar class="gradient" elevation="0">
                    <v-toolbar-title class="white--text">{{ formTitle }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn icon @click="dialog = false">
                            <v-icon color="white">mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-divider></v-divider>
                <v-form v-model="valid" v-if="dialog" lazy-validation>
                    <?= new Controller\Template('course/edit/parts/lesson_form', ['dialog' => 'lesson_dialog']) ?>
                    <v-card-text>
                        <v-container fluid>
                            <v-row>
                                <v-col cols="12">
                                    <?= new Controller\Template('course/create/partials/general_information', [
                                      'object' => 'editedItem',
                                      'featured_image' => 'new_featured_image',
                                      'categories' => 'categories.items'
                                    ]) ?>
                                </v-col>

                                <v-col md="12">
                                    <?= new Controller\Template('course/create/partials/curriculum', [
                                      'object' => 'editedItem'
                                    ]) ?>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-actions class="px-4">
                        <v-spacer></v-spacer>
                        <v-btn color="secondary white--text" block @click="save" :disabled="!valid" :loading="loading">
                            {{ formTitle }}
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="50%">
            <v-card>
                <v-card-title class="headline d-flex justify-center">¿Estás seguro de que quieres eliminar este curso?
                </v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="closeDelete">Cancelar</v-btn>
                    <v-btn color="secondary" text @click="deleteItemConfirm">Continuar</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-toolbar>
</template>