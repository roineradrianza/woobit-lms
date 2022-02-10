<v-container class="px-8 px-md-0 pt-16 pt-md-0">
    <v-form ref="application_form" v-model="application_form" lazy-validation>
        <v-row class="pt-8 pt-md-0">
            <template v-if="list_loading">
                <v-col cols="12">

                    <v-skeleton-loader type="article, actions"></v-skeleton-loader>

                    <v-skeleton-loader type="table-heading, list-item-two-line, image, table-tfoot">
                    </v-skeleton-loader>

                </v-col>
            </template>
            <template v-else>

                <v-col class="d-flex justify-center" cols="12" v-if="form.status >= 0">
                    <v-alert border="top" colored-border :type="getStatusType(form.status)" elevation="2">
                        <template v-if="form.status == '1'">
                            Cererea sa a fost aprobată
                        </template>

                        <template v-else-if="form.status == '3'">
                            Cererea dumneavoastră a fost respinsă
                        </template>

                        <template v-else>
                            Cererea dumneavoastră de a deveni lector este în curs de examinare.
                        </template>
                    </v-alert>
                </v-col>

                <v-col cols="12">
                    <?= new Controller\Template('become-teacher/step-1') ?>
                </v-col>

                <v-col cols="12">
                    <?= new Controller\Template('become-teacher/step-2') ?>
                </v-col>

                <v-col cols="12">
                    <?= new Controller\Template('become-teacher/step-3') ?>
                </v-col>

                <v-col cols="12">
                    <?= new Controller\Template('become-teacher/step-4') ?>
                </v-col>

                <v-col cols="12">
                    <?= new Controller\Template('become-teacher/step-5') ?>
                </v-col>

                <v-col class="d-flex justify-center" cols="12">
                    <v-btn class="white--text" :disabled="!application_form" :loading="loading" color="#a500a4"
                        @click="$refs.application_form.validate() ? save() : ''" v-if="form.status < 0">
                        Trimiteți
                        aplicația
                    </v-btn>
                    <v-alert border="top" colored-border :type="getStatusType(form.status)" elevation="2" v-else>
                        <template v-if="form.status == '1'">
                            Cererea sa a fost aprobată!
                        </template>

                        <template v-else-if="form.status == '3'">
                            Cererea dumneavoastră a fost respinsă
                        </template>

                        <template v-else>
                            Cererea dumneavoastră de a deveni profesor este în curs de examinare.
                        </template>
                    </v-alert>
                </v-col>

                <v-col cols="12">
                    <?= new Controller\Template('components/alert') ?>
                </v-col>
            </template>

        </v-row>
    </v-form>

</v-container>