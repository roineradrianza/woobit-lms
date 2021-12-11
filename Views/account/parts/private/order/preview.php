<template>
    <v-toolbar class="bg-transparent" flat>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialogOrderPreview" max-width="1200px" @click:outside="dialogOrderPreview = false">
            <v-card>
                <v-toolbar class="gradient" elevation="0">
                    <v-toolbar-title class="white--text">Informații de plată</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn icon @click="dialogOrderPreview = false">
                            <v-icon color="white">mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-divider></v-divider>
                <v-card-text>
                    <v-container fluid>
                        <v-row v-if="orders.editedIndex != -1">
                            <v-col cols="12">
                                <v-row>

                                    <v-col cols="4">
                                        <p class="body-1 primary--text">Suma:
                                            <span class="font-weight-light black--text">
                                                {{ orders.editedItem.total_pay }} RON
                                            </span>
                                        </p>
                                    </v-col>

                                    <v-col cols="4">
                                        <p class="body-1 primary--text">Suma (USD):
                                            <span class="font-weight-light black--text">
                                                $ {{ orders.editedItem.meta.USD }}
                                            </span>
                                        </p>
                                    </v-col>

                                    <v-col cols="4">
                                        <p class="body-1 primary--text">
                                            <template v-if="parseInt(orders.editedItem.type) == 1">
                                                Curs:
                                            </template>
                                            <template v-else>
                                                Descriere:
                                            </template>
                                            <span
                                                class="font-weight-light black--text">{{ orders.editedItem.meta.course }}</span>
                                        </p>
                                    </v-col>

                                    <v-col cols="4" v-if="orders.editedItem.note !== '' && parseInt(orders.editedItem.type) == 2">
                                        <p class="body-1 primary--text">Notă:
                                            <span
                                                class="font-weight-light black--text">{{ orders.editedItem.note }}</span>
                                        </p>
                                    </v-col>

                                </v-row>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-toolbar>
</template>