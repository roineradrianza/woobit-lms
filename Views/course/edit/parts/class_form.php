<v-row>
    <v-col cols="12" md="6" v-if="1 == 2">
        <label class="body-1 font-weight-thin pl-1">Tipul de lecție</label>
        <v-select class="mt-3" v-model="lessons.item.meta.class_type" :items="lessons.class_types" outlined></v-select>
    </v-col>
    <?php if(!empty($mode) && $mode == 'edit') : ?>
    <v-col cols="12" md="6">
        <label class="body-1 font-weight-thin pl-1">Trimiteți poșta de publicare</label>
        <v-select class="mt-3" v-model="lessons.item.meta.send_publish_email"
            :items="[{text: 'Da', value: '1'}, {text: 'Nu', value: '0'}]" outlined></v-select>
    </v-col>
    <?php endif ?>
    <v-col cols="12" md="6">
        <label class="body-1 font-weight-thin pl-1">Durata</label>
        <v-text-field type="text" v-model="lessons.item.meta.duration" class="mt-3" hint="Exemplu: 1h 45 min"
            persistent-hint outlined></v-text-field>
    </v-col>

    <template v-if="lessons.item.meta.class_type == 'video'">
        <v-col cols="12" md="6">
            <label class="body-1 font-weight-thin pl-1">Póster</label>
            <v-file-input class="mt-3" v-model="lessons.item.meta.poster" prepend-icon="mdi-image" accept="image/*"
                hint="Imágen a mostrar como previa del video" persistent-hint outlined>
            </v-file-input>
        </v-col>
        <v-col cols="12" md="6">
            <label class="body-1 font-weight-thin pl-1">Video de la clase</label>
            <v-file-input class="mt-3" v-model="lessons.item.meta.video" item-text="text" prepend-icon="mdi-video"
                accept="video/*" hint="Video a subir de la clase" persistent-hint filled rounded dense></v-file-input>
        </v-col>
    </template>

    <template v-if="lessons.item.meta.class_type == 'zoom_meeting'">

        <v-col cols="12" md="6">
            <label class="body-1 font-weight-thin pl-1">Durata clasei</label>
            <v-text-field type="number" class="mt-3" v-model="lessons.item.meta.zoom_duration"
                placeholder="Introduceți durata în minute" hint="Setați durata clasei în zoom" suffix="minute"
                persistent-hint outlined>
            </v-text-field>
        </v-col>
        <v-col cols="12" md="6">
            <v-dialog ref="zoomDateDialog" v-model="zoom_date_modal" :return-value.sync="lessons.item.meta.zoom_date"
                persistent width="290px">
                <template #activator="{ on, attrs }">
                    <label class="body-1 font-weight-thin pl-1">Data cursului</label>
                    <v-text-field v-model="lessons.item.meta.zoom_date" class="mt-3" hint="Setați durata clasei în zoom"
                        v-bind="attrs" v-on="on" persistent-hint readonly outlined>
                        <template #append>
                            <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
                        </template>
                    </v-text-field>
                </template>
                <v-date-picker v-model="lessons.item.meta.zoom_date" scrollable>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="zoom_date_modal = false">
                        Anulează
                    </v-btn>
                    <v-btn text color="primary" @click="$refs.zoomDateDialog.save(lessons.item.meta.zoom_date)">
                        OK
                    </v-btn>
                </v-date-picker>
            </v-dialog>
        </v-col>

        <v-col cols="12" md="6">
            <v-dialog ref="zoomTimeDialog" v-model="zoom_time_modal" :return-value.sync="lessons.item.meta.zoom_time"
                persistent width="290px">
                <template #activator="{ on, attrs }">
                    <label class="body-1 font-weight-thin pl-1">Timp</label>
                    <v-text-field v-model="lessons.item.meta.zoom_time" hint="Setați ora de începere a clasei de zoom"
                        persistent-hint class="mt-3" readonly v-bind="attrs" v-on="on" outlined>
                        <template #append>
                            <v-icon v-bind="attrs" v-on="on">mdi-clock</v-icon>
                        </template>
                    </v-text-field>
                </template>
                <v-time-picker v-if="zoom_time_modal" v-model="lessons.item.meta.zoom_time" full-width>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="zoom_time_modal = false">
                        Anulează
                    </v-btn>
                    <v-btn text color="primary" @click="$refs.zoomTimeDialog.save(lessons.item.meta.zoom_time)">
                        OK
                    </v-btn>
                </v-time-picker>
            </v-dialog>
        </v-col>

        <v-col cols="12" md="6">
            <label class="body-1 font-weight-thin pl-1">Fusul</label>
            <v-select class="mt-3" v-model="lessons.item.meta.zoom_timezone" :items="timezones" item-text="name"
                item-value="id" outlined></v-select>
        </v-col>

        <v-col class="d-flex justify-center align-center" cols="12" md="6" v-if="lessons.item.meta.hasOwnProperty('zoom_id') && lessons.item.meta.zoom_id !== '' || 
            lessons.item.meta.hasOwnProperty('zoom_url') && lessons.item.meta.zoom_url !== ''">
            <span class="body-1 font-weight-thin pl-1"
                v-if="lessons.item.meta.hasOwnProperty('zoom_id') && lessons.item.meta.zoom_id !== ''">
                Zoom ID: {{ lessons.item.meta.zoom_id }}
            </span>
            <span class="body-1 font-weight-thin pl-1"
                v-if="lessons.item.meta.hasOwnProperty('zoom_url') && lessons.item.meta.zoom_url !== ''">Zoom url: <a
                    :href="lessons.item.meta.zoom_url">{{ lessons.item.meta.zoom_url }}</a> </span>
        </v-col>

        <v-col cols="12" md="6">
            <label class="body-1 font-weight-thin pl-1">Descriere zoom (Opțional)</label>
            <v-textarea rows="1" id="lesson_zoom_editor" class="mt-3" v-model="lessons.item.meta.zoom_agenda"
                placeholder="Scurtă descriere a zoom-ului" auto-grow outlined></v-textarea>
        </v-col>

    </template>

    <template v-if="lessons.item.meta.class_type == 'streaming'">

        <v-col cols="12" md="6">
            <v-dialog ref="streamingDateDialog" v-model="streaming_date_modal"
                :return-value.sync="lessons.item.meta.streaming_date" persistent width="290px">
                <template #activator="{ on, attrs }">
                    <label class="body-1 font-weight-thin pl-1">Fecha</label>
                    <v-text-field v-model="lessons.item.meta.streaming_date" class="mt-3" readonly v-bind="attrs"
                        v-on="on" outlined></v-text-field>
                </template>
                <v-date-picker v-model="lessons.item.meta.streaming_date" scrollable>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="streaming_date_modal = false">
                        Anulează
                    </v-btn>
                    <v-btn text color="primary"
                        @click="$refs.streamingDateDialog.save(lessons.item.meta.streaming_date)">
                        OK
                    </v-btn>
                </v-date-picker>
            </v-dialog>
        </v-col>

        <v-col cols="12" md="6">
            <v-dialog ref="streamingTimeDialog" v-model="streaming_time_modal"
                :return-value.sync="lessons.item.meta.streaming_time" persistent width="290px">
                <template #activator="{ on, attrs }">
                    <label class="body-1 font-weight-thin pl-1">Hora</label>
                    <v-text-field v-model="lessons.item.meta.streaming_time" class="mt-3" readonly v-bind="attrs"
                        v-on="on" outlined></v-text-field>
                </template>
                <v-time-picker v-if="streaming_time_modal" v-model="lessons.item.meta.streaming_time" full-width>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="streaming_time_modal = false">
                        Anulează
                    </v-btn>
                    <v-btn text color="primary"
                        @click="$refs.streamingTimeDialog.save(lessons.item.meta.streaming_time)">
                        OK
                    </v-btn>
                </v-time-picker>
            </v-dialog>
        </v-col>

        <v-col cols="12" md="6">
            <label class="body-1 font-weight-thin pl-1">Zona horaria</label>
            <v-select class="mt-3" v-model="lessons.item.meta.streaming_timezone" :items="timezones" item-text="name"
                item-value="id" outlined></v-select>
        </v-col>

        <v-col cols="12" md="6">
            <label class="body-1 font-weight-thin pl-1">ID del Streaming</label>
            <v-text-field class="mt-3" v-model="lessons.item.meta.streaming_id"
                placeholder="Inserte acá el ID del youtube streaming" rounded />
        </v-col>

    </template>

    <v-col cols="12" md="12">
        <label class="body-1 font-weight-thin pl-1">Descriere</label>
        <vue-editor id="lesson_editor" class="mt-3" v-model="lessons.item.meta.description" :editor-toolbar="customToolbar"
            placeholder="Descrierea clasei" />
    </v-col>

    <?php echo !empty($mode) && $mode == 'edit' ? new Controller\Template('course/edit/parts/resources' ) : '' ?>

    <?php echo new Controller\Template('components/alert') ?>

</v-row>