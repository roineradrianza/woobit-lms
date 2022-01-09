<h3 class="text-h5 text-center">Sumarul cursului</h3>

<v-row class="d-flex justify-center">
    <v-col class="d-flex justify-center" cols="12">
        <v-btn class="secondary white--text" @click="addSection">Adăugați secțiunea</v-btn>
    </v-col>
    <v-col cols="12" md="9" class="p-0">
        <v-expansion-panels :disabled="curriculum.loading">
            <draggable class="col col-12" v-model="curriculum.sections" @update="checkSectionMove">
                <transition-group>
                    <v-expansion-panel v-for="(section, section_index) in curriculum.sections" :key="section_index">
                        <v-expansion-panel-header @keyup.space.prevent>
                            <v-row class="d-flex justify-end" no-gutters>
                                <v-col class="d-flex justify-start p-0" cols="10">
                                    Secțiunea {{ section_index + 1 }}
                                </v-col>
                                <v-col class="d-flex justify-end p-0" cols="1">
                                    <v-tooltip top>
                                        <template #activator="{ on, attrs }">
                                            <v-btn v-bind="attrs" v-on="on" text>
                                                <v-icon>mdi-menu</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Schimbați ordinea secțiunii prin tragerea
                                            containerului</span>
                                    </v-tooltip>

                                </v-col>
                                <v-col class="d-flex justify-end p-0" cols="1">
                                    <v-tooltip top>
                                        <template #activator="{ on, attrs }">
                                            <v-icon v-bind="attrs" v-on="on" color="red"
                                                @click="removeSection(section)">
                                                mdi-delete
                                            </v-icon>
                                        </template>
                                        <span>Ștergeți secțiunea</span>
                                    </v-tooltip>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="section.section_name" placeholder="Denumirea secțiunii"
                                        @click.native.stop outlined>
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                            <v-col cols="12">
                                <v-row>
                                    <v-col cols="12" md="4">
                                        <label class="body-1 font-weight-thin pl-1">Data de începere</label>
                                        <v-dialog ref="section_start_date" :return-value.sync="section.start_date"
                                            width="20vw">
                                            <template #activator="{ on, attrs }">
                                                <v-text-field class="mt-3" v-model="section.start_date" readonly
                                                    v-bind="attrs" v-on="on" outlined>
                                                    <template #append>
                                                        <v-icon v-bind="attrs" v-on="on">
                                                            mdi-calendar
                                                        </v-icon>
                                                    </template>
                                                </v-text-field>
                                            </template>
                                            <v-date-picker v-model="section.start_date" scrollable>
                                                <v-spacer></v-spacer>
                                                <v-btn text color="primary"
                                                    @click="$refs.section_start_date[$refs.section_start_date.length - 1].isActive = false">
                                                    Anulează
                                                </v-btn>
                                                <v-btn text color="primary"
                                                    @click="$refs.section_start_date[$refs.section_start_date.length - 1].save(section.start_date)">
                                                    OK
                                                </v-btn>
                                            </v-date-picker>
                                        </v-dialog>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label class="body-1 font-weight-thin pl-1">Frecvență</label>
                                        <v-select class="mt-3" v-model="section.frecuency" :items="
                                        [
                                            {
                                                text: 'Weekly',
                                                value: '1'
                                            },
                                            
                                            {
                                                text: 'Monthly',
                                                value: '2'
                                            }
                                        ]" outlined></v-select>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <label class="body-1 font-weight-thin pl-1">Numărul de clase</label>
                                        <v-text-field type="number" class="mt-3" v-model="section.classes" outlined>
                                        </v-text-field>
                                    </v-col>

                                    <v-col cols="12" md="4">
                                        <label class="body-1 pl-1">Orarul</label>
                                        <v-row>
                                            <v-col cols="6">
                                                <v-dialog ref="section_start_time"
                                                    :return-value.sync="section.start_time" persistent width="290px">
                                                    <template #activator="{ on, attrs }">
                                                        <label class="body-1 font-weight-thin pl-1">Începutul</label>
                                                        <v-text-field v-model="section.start_time" persistent-hint
                                                            class="mt-3" readonly v-bind="attrs" v-on="on" outlined>
                                                            <template #append>
                                                                <v-icon v-bind="attrs" v-on="on">mdi-clock</v-icon>
                                                            </template>
                                                        </v-text-field>
                                                    </template>
                                                    <v-time-picker v-model="section.start_time" full-width>
                                                        <v-spacer></v-spacer>
                                                        <v-btn text color="primary"
                                                            @click="section_start_time[$refs.section_start_time.length - 1].isActive = false">
                                                            Anulează
                                                        </v-btn>
                                                        <v-btn text color="primary"
                                                            @click="$refs.section_start_time[$refs.section_start_time.length - 1].save(section.start_time)">
                                                            OK
                                                        </v-btn>
                                                    </v-time-picker>
                                                </v-dialog>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-dialog ref="section_end_time"
                                                    :return-value.sync="section.end_time" persistent width="290px">
                                                    <template #activator="{ on, attrs }">
                                                        <label class="body-1 font-weight-thin pl-1">Sfârșitul</label>
                                                        <v-text-field v-model="section.end_time" persistent-hint
                                                            class="mt-3" readonly v-bind="attrs" v-on="on" outlined>
                                                            <template #append>
                                                                <v-icon v-bind="attrs" v-on="on">mdi-clock</v-icon>
                                                            </template>
                                                        </v-text-field>
                                                    </template>
                                                    <v-time-picker v-model="section.end_time" full-width>
                                                        <v-spacer></v-spacer>
                                                        <v-btn text color="primary"
                                                            @click="section_end_time[$refs.section_end_time.length - 1].isActive = false">
                                                            Anulează
                                                        </v-btn>
                                                        <v-btn text color="primary"
                                                            @click="$refs.section_end_time[$refs.section_end_time.length - 1].save(section.end_time)">
                                                            OK
                                                        </v-btn>
                                                    </v-time-picker>
                                                </v-dialog>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col class="d-flex justify-center" cols="12">
                                <v-btn class="secondary white--text" @click="addLesson(section_index)"
                                    :loading="curriculum.add_lesson_loading">Adăugați clasa
                                </v-btn>
                            </v-col>
                            <draggable class="col col-12" v-model="section.items"
                                @update="checkLessonMove(section_index)" reactive>
                                <transition-group>
                                    <v-row v-for="(lesson,index) in section.items" :key="index">
                                        <v-row class="d-flex justify-end align-center" no-gutters>
                                            <v-col class="d-flex justify-start p-0" cols="9">
                                            </v-col>
                                            <v-col class="d-flex justify-end p-0" cols="3">
                                                <v-btn-toggle group>
                                                    <v-tooltip top>
                                                        <template #activator="{ on, attrs }">
                                                            <v-btn v-bind="attrs" v-on="on" text>
                                                                <v-icon>mdi-menu</v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Schimbarea ordinii clasei prin
                                                            tragerea
                                                            containerului</span>
                                                    </v-tooltip>
                                                    <v-tooltip top>
                                                        <template #activator="{ on, attrs }">
                                                            <v-btn v-bind="attrs" v-on="on"
                                                                @click="openLessonDialog(section_index, lesson)" text>
                                                                <v-icon color="primary">
                                                                    mdi-pencil-box
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Schimbați clasa</span>
                                                    </v-tooltip>

                                                    <v-tooltip top>
                                                        <template #activator="{ on, attrs }">
                                                            <v-btn v-bind="attrs" v-on="on"
                                                                @click="openLessonDialog(section_index, lesson)" text>
                                                                <v-icon color="red"
                                                                    @click="removeLesson(section_index, lesson)">
                                                                    mdi-delete
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Ștergeți secțiunea</span>
                                                    </v-tooltip>
                                                </v-btn-toggle>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field v-model="lesson.lesson_name"
                                                    placeholder="Înregistrare de la clase" @click.native.stop outlined>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-row>
                                </transition-group>

                            </draggable>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </transition-group>

            </draggable>
        </v-expansion-panels>
    </v-col>
</v-row>