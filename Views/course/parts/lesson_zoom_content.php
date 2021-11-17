<?php echo new Controller\Template('course/parts/lesson_menu', [
'course_slug' => $course['slug'], 
'sections' => $course['sections']
]) 
?>
<?php echo new Controller\Template('course/parts/resources/preview') ?>
<v-col class="lesson" cols="12">
    <v-row>
        <v-col class="d-flex justify-center mb-n4" cols="12">
            <countdown tag="div" :time="zoom_countdown" :transform="transformSlotProps"
                v-slot="{ days, hours, minutes, seconds }" @end="show_button = true" ref="meeting_countdown">
                <v-row class="d-md-flex justify-center">
                    <v-col cols="3">
                        <p class="text-h3 text-md-h1 secondary--text text-center">{{ days }} <br><span
                                class="text-h6 text-md-h5 text-center mt-n6 d-none d-md-inline">días</span></p>
                    </v-col>
                    <v-col cols="3">
                        <p class="text-h3 text-md-h1 secondary--text text-center">{{ hours }} <br><span
                                class="text-h6 text-md-h5 text-center mt-n6 d-none d-md-inline">horas</span></p>
                    </v-col>
                    <v-col cols="3">
                        <p class="text-h3 text-md-h1 secondary--text text-center">{{ minutes }} <br><span
                                class="text-h6 text-md-h5 text-center mt-n6 d-none d-md-inline">minutos</span></p>
                    </v-col>
                    <v-col cols="3" class="pl-6">
                        <p class="text-h3 text-md-h1 secondary--text text-center"> {{ seconds }} <br><span
                                class="text-h6 text-md-h5 text-center mt-n6 d-none d-md-inline">segundos</span></p>
                    </v-col>
                    <v-col class="pl-6" cols="12">
                        <v-divider></v-divider>
                    </v-col>
                </v-row>
            </countdown>
        </v-col>
        <v-col cols="12">
            <h3 class="text-h3 text-center my-5"><?php echo $data['lesson']['lesson_name'] ?></h3>
            <h4 class="text-h5 text-center my-5" v-if="meta.hasOwnProperty('zoom_timezone')">Fecha y hora: <br>
                <span class="secondary--text">{{ formatDate(meta.zoom_start_time) }},
                    {{ replaceString(meta.zoom_timezone, '_', ' ') }}</span>
            </h4>
            <h5 class="text-h6 text-center my-5" v-if="show_button || countdown_container.totalMilliseconds < 1800000">
                30 minutos antes del inicio
                de la clase se habilitará debajo de este texto el botón para entrar a la clase </h5>
        </v-col>
        <v-col class="text-center" cols="12" v-if="show_button && zoom_link">
            <p>En caso de que el botón no funcione puede acceder a la clase a través del siguiente link</p>
            <a :href="meta.zoom_url" style="word-break: break-all;">{{ meta.zoom_url }}</a>
        </v-col>
        <v-col class="text-center" cols="12" v-if="show_button && zoom_link">
            <p v-if="meta.hasOwnProperty('zoom_id') && meta.zoom_id != ''"><span class="secondary--text">ID:</span>
                {{ meta.zoom_id }}</p>
            <p v-if="meta.hasOwnProperty('zoom_password') && meta.zoom_password != ''"><span
                    class="secondary--text">Parola:</span> {{ meta.zoom_password }}</p>
        </v-col>
        <v-col class="d-flex justify-center" cols="12" v-if="show_button">
            <v-btn class="secondary white--text py-6" @click="joinClass" :loading="join_loading" rounded>Entrar a
                la clase</v-btn>
        </v-col>
        <v-col cols="12">
            <v-row class="d-flex justify-center">
                <v-col class="ql-editor" cols="12" md="8" v-html="meta.description">
                </v-col>
            </v-row>
        </v-col>
        <?php if (!empty($data['course']['course_sponsors'])): ?>
        <v-col class="d-flex justify-center" cols="12">
            <v-row class="d-flex justify-center">
                <v-col cols="12" md="7">
                    <v-row class="d-flex justify-center align-center">
                        <v-col cols="12">
                            <p class="text-center">
                                Patrocinado por:
                            </p>
                        </v-col>
                        <?php foreach ($data['course']['course_sponsors'] as $sponsor): ?>

                        <v-col cols="4" md="3">
                            <a href="<?php echo $sponsor['website'] ?>">
                                <v-img src="<?php echo $sponsor['logo_url'] ?>" width="100%" style="max-width:300px">
                                </v-img>
                            </a>
                        </v-col>

                        <?php endforeach ?>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
        <?php endif ?>
        <v-row class="d-flex justify-center" v-if="resources.length > 0">
            <v-col cols="12" md="8">
                <h3 class="text-h4">Recursos de la clase</h3>
            </v-col>
            <v-col cols="12" md="8">
                <v-divider></v-divider>
            </v-col>
            <v-col cols="12" md="8">
                <v-row>
                    <template v-for="resource in resources">
                        <v-col cols="12" md="6">
                            <v-card class="mx-auto outlined">
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-list-item-title class="headline mb-1 no-white-space">
                                            {{ resource.name }}
                                        </v-list-item-title>
                                    </v-list-item-content>

                                    <v-list-item-avatar size="80" color="primary">
                                        <v-icon color="white" x-large>mdi-file-{{ getExtIcon(resource.url) }}
                                        </v-icon>
                                        <br>
                                    </v-list-item-avatar>
                                </v-list-item>

                                <v-card-actions>
                                    <v-row>
                                        <template v-if="resource.percent_loading_active">
                                            <v-col class="p-0 mb-n6" cols="12">
                                                <p class="text-center" v-if="resource.percent_loading < 100">
                                                    Descargando recurso</p>
                                                <p class="text-center" v-else>Descarga completada, espere un
                                                    momento...</p>
                                            </v-col>
                                            <v-col class="p-0" cols="12">
                                                <v-progress-linear :active="resource.percent_loading_active"
                                                    :value="resource.percent_loading" height="15" dark>
                                                    <template v-slot:default="{ value }">
                                                        <strong>{{ Math.ceil(value) }}%</strong>
                                                    </template>
                                                </v-progress-linear>
                                            </v-col>
                                        </template>
                                        <v-col class="d-flex justify-center" cols="12">
                                            <v-btn color="primary" @click="saveFile(resource.url, resource)"
                                                v-if="!parseInt(resource.preview_only)" outlined rounded text>
                                                Descargar
                                            </v-btn>
                                            <v-btn color="primary"
                                                @click="resource_preview = Object.assign(resource); resource_preview_dialog = true"
                                                v-else outlined rounded text>
                                                Visualizar
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </template>
                </v-row>
            </v-col>
        </v-row>
    </v-row>
</v-col>