<v-row>
    <v-col class="d-flex justify-center mb-n4" cols="12">
        <countdown tag="div" :time="zoom_countdown" :transform="transformSlotProps"
            v-slot="{ days, hours, minutes, seconds }" @end="show_button = true" ref="meeting_countdown">
            <v-row class="d-md-flex justify-center">
                <v-col cols="3">
                    <p class="text-h4 text-md-h2 secondary--text text-center">{{ days }} <br><span
                            class="body-1 text-md-h6 text-center mt-n6">zile</span>
                    </p>
                </v-col>
                <v-col cols="3">
                    <p class="text-h4 text-md-h2 secondary--text text-center">{{ hours }} <br><span
                            class="body-1 text-md-h6 text-center mt-n6">ore</span>
                    </p>
                </v-col>
                <v-col cols="3">
                    <p class="text-h4 text-md-h2 secondary--text text-center">{{ minutes }} <br><span
                            class="body-1 text-md-h6 text-center mt-n6">minute</span>
                    </p>
                </v-col>
                <v-col cols="3">
                    <p class="text-h4 text-md-h2 secondary--text text-center"> {{ seconds }} <br><span
                            class="body-1 text-md-h6 text-center mt-n6">secunde</span>
                    </p>
                </v-col>
                <v-col cols="12">
                    <v-divider></v-divider>
                </v-col>
            </v-row>
        </countdown>
    </v-col>
    <v-col cols="12">
        <v-row class="px-6">
            <v-col cols="12">
                <h4 class="text-h5 text-center my-5" v-if="meta.hasOwnProperty('zoom_timezone')">Data și ora:
                    <br>
                    <span class="secondary--text">{{ formatDate(meta.zoom_start_time) }},
                        {{ replaceString(meta.zoom_timezone, '_', ' ') }}</span>
                </h4>
                <h5 class="body-1 text-md-h6 text-center my-5"
                    v-if="show_button || countdown_container.totalMilliseconds < 1800000">
                    Cu 30 de minute înainte de start sub acest text va fi activat butonul de începere a cursului. </h5>
            </v-col>
            <v-col class="text-center" cols="12" v-if="show_button && zoom_link">
                <p>În cazul în care butonul nu funcționează, poți accesa cursul prin următorul link</p>
                <a :href="meta.zoom_url" style="word-break: break-all;">{{ meta.zoom_url }}</a>
            </v-col>
            <v-col class="text-center" cols="12" v-if="show_button && zoom_link">
                <p v-if="meta.hasOwnProperty('zoom_id') && meta.zoom_id != ''"><span class="secondary--text">ID:</span>
                    {{ meta.zoom_id }}</p>
                <p v-if="meta.hasOwnProperty('zoom_password') && meta.zoom_password != ''"><span
                        class="secondary--text">Parola:</span> {{ meta.zoom_password }}</p>
            </v-col>
            <v-col class="d-flex justify-center" cols="12" v-if="show_button">
                <v-btn class="secondary white--text py-6" @click="joinClass" :loading="join_loading" rounded>
                    ÎNCEPE CURSUL AICI 
                </v-btn>
            </v-col>
            <v-col cols="12">
                <v-row class="d-flex justify-center">
                    <v-col class="ql-editor" cols="12" v-html="meta.description">
                    </v-col>
                </v-row>
            </v-col>
            <v-row class="d-flex justify-center px-4" v-if="resources.length > 0">
                <v-col cols="12">
                    <v-divider></v-divider>
                    <h4 class="mt-4 text-h5">Materiale pentru classroom</h4>
                </v-col>
                <v-col cols="12">
                    <v-row>
                        <template v-for="resource in resources">
                            <v-col cols="12" md="6">
                                <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/resources/show', ['show_edit_btns' => false]) ?>
                            </v-col>
                        </template>
                    </v-row>
                </v-col>
            </v-row>
        </v-row>
    </v-col>
</v-row>