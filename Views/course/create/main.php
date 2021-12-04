<v-container class="px-6 px-md-0">
    <?php echo new Controller\Template('course/edit/parts/lesson_form', ['mode' => 'create']) ?>
    <v-form>
        <v-row>
            <v-col cols="12">
                <h1 class="text-h4">Cursuri creative, în direct, pentru minți luminoase</h1>
            </v-col>
            <v-col class="d-flex justify-center align-center d-md-inline" cols="12">
                <v-btn color="primary" href="<?php echo SITE_URL ?>/new-class-guide">Ghid curs nou</v-btn>
                <v-btn class="my-6" color="primary" text>Adaugă curs nou
                </v-btn>
                <v-btn class="my-6" color="primary" href="<?php echo SITE_URL ?>/my-courses">Cursurile tale
                </v-btn>
            </v-col>
            <v-col cols="12">
                <v-form ref="course_form" lazy-validation>
                    <v-row>

                        <v-col cols="12" md="6">
                            <label>Imaginea de copertă a cursului</label>
                            <v-file-input v-model="course.featured_image" label="" truncate-length="66"
                                accept=".jpg, .jpeg, .png, .svg" :rules="validations.featuredImageRules"
                                prepend-icon="mdi-image" show-size outlined>
                                <template #selection="{ index, text }">
                                    <v-chip color="primary" label small>
                                        {{ text }}
                                    </v-chip>
                                </template>
                            </v-file-input>
                        </v-col>

                        <v-col cols="12" md="6">
                            <label>Titlul</label>
                            <v-text-field name="course_title" v-model="course.title" :rules="validations.titleRules"
                                outlined counter="100">
                            </v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <label>Categoría</label>
                            <v-select v-model="course.category_id" :items="categories" item-text="name"
                                item-value="category_id" :rules="validations.requiredRules" outlined></v-select>
                        </v-col>

                        <v-col cols="12" md="6">
                            <label>Tagline-ul</label>
                            <v-text-field name="description" v-model="course.meta.description"
                                :rules="validations.descriptionRules" outlined counter="65">
                            </v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <label>Ora cursului</label>
                            <v-text-field name="course_duration" v-model="course.duration" outlined>
                            </v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <label>Preț</label>
                            <v-text-field type="number" name="course_price" v-model="course.price"
                                :rules="validations.requiredRules" hint="Preț în RON" outlined>
                            </v-text-field>
                        </v-col>

                        <v-col class="py-0" cols="12" md="6">
                            <v-card flat color="transparent">
                                <v-subheader class="d-flex justify-center body-1">Vârsta
                                </v-subheader>

                                <v-card-text class="mt-n8">
                                    <v-row justify="center">
                                        <v-col cols="12" class="px-4">
                                            <v-range-slider v-model="age_range" :max="max_age" :min="min_age"
                                                hide-details class="align-center">
                                                <template #prepend>
                                                    <v-text-field v-model="age_range[0]" class="mt-0 pt-0" outlined
                                                        dense readonly type="number" style="width: 60px"
                                                        @change="$set(age_range, 0, $event)">
                                                    </v-text-field>
                                                </template>
                                                <template #append>
                                                    <v-text-field v-model="age_range[1]" class="mt-0 pt-0" outlined
                                                        dense readonly type="number" style="width: 60px"
                                                        @change="$set(age_range, 1, $event)">
                                                    </v-text-field>
                                                </template>
                                            </v-range-slider>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-col>

                        <v-col class="py-0" cols="12" md="6">
                            <v-row>
                                <v-col cols="12">
                                    Numărul minim și maxim de cursanți
                                </v-col>
                                <v-col cols="12" class="py-0">
                                    <v-row class="py-0">
                                        <v-col cols="6" class="py-0">
                                            <v-text-field label="Minim" type="number" v-model="course.min_students"
                                                name="min_students" :rules="validations.minRules" outlined>
                                            </v-text-field>
                                        </v-col>

                                        <v-col cols="6" class="py-0">
                                            <v-text-field label="Maxim" type="number" v-model="course.max_students"
                                                name="max_students" :rules="validations.maxRules" outlined>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col md="12">
                            <h3 class="text-h5 text-center">Sumarul cursului</h3>

                            <v-row class="d-flex justify-center">
                                <v-col class="d-flex justify-center" cols="12">
                                    <v-btn class="secondary white--text" @click="addSection">Adăugați secțiunea</v-btn>
                                </v-col>
                                <v-col cols="12" md="9" class="p-0">
                                    <v-expansion-panels :disabled="curriculum.loading">
                                        <draggable class="col col-12" v-model="curriculum.sections"
                                            @update="checkSectionMove">
                                            <transition-group>
                                                <v-expansion-panel
                                                    v-for="(section, section_index) in curriculum.sections"
                                                    :key="section_index">
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
                                                                <v-text-field v-model="section.section_name"
                                                                    placeholder="Denumirea secțiunii" @click.native.stop
                                                                    outlined>
                                                                </v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                    </v-expansion-panel-header>
                                                    <v-expansion-panel-content>
                                                        <v-col class="d-flex justify-center" cols="12">
                                                            <v-btn class="secondary white--text"
                                                                @click="addLesson(section_index)"
                                                                :loading="curriculum.add_lesson_loading">Adăugați clasa
                                                            </v-btn>
                                                        </v-col>
                                                        <draggable class="col col-12" v-model="section.items"
                                                            @update="checkLessonMove(section_index)" reactive>
                                                            <transition-group>
                                                                <v-row v-for="(lesson,index) in section.items"
                                                                    :key="index">
                                                                    <v-row class="d-flex justify-end align-center"
                                                                        no-gutters>
                                                                        <v-col class="d-flex justify-start p-0"
                                                                            cols="9">
                                                                        </v-col>
                                                                        <v-col class="d-flex justify-end p-0" cols="3">
                                                                            <v-btn-toggle group>
                                                                                <v-tooltip top>
                                                                                    <template
                                                                                        #activator="{ on, attrs }">
                                                                                        <v-btn v-bind="attrs" v-on="on"
                                                                                            text>
                                                                                            <v-icon>mdi-menu</v-icon>
                                                                                        </v-btn>
                                                                                    </template>
                                                                                    <span>Schimbarea ordinii clasei prin
                                                                                        tragerea
                                                                                        containerului</span>
                                                                                </v-tooltip>
                                                                                <v-tooltip top>
                                                                                    <template
                                                                                        #activator="{ on, attrs }">
                                                                                        <v-btn v-bind="attrs" v-on="on"
                                                                                            @click="openLessonDialog(section_index, lesson)"
                                                                                            text>
                                                                                            <v-icon color="primary">
                                                                                                mdi-pencil-box
                                                                                            </v-icon>
                                                                                        </v-btn>
                                                                                    </template>
                                                                                    <span>Schimbați clasa</span>
                                                                                </v-tooltip>

                                                                                <v-tooltip top>
                                                                                    <template
                                                                                        #activator="{ on, attrs }">
                                                                                        <v-btn v-bind="attrs" v-on="on"
                                                                                            @click="openLessonDialog(section_index, lesson)"
                                                                                            text>
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
                                                                                placeholder="Înregistrare de la clase"
                                                                                @click.native.stop outlined>
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
                        </v-col>
                        <v-col cols="12">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col class="d-flex justify-center" cols="12">
                            <v-btn class="secondary white--text" @click="$refs.course_form.validate() ? save() : ''"
                                :disabled="saved" :loading="loading">
                                Salvați cursul</v-btn>
                        </v-col>
                        <v-col class="d-flex justify-center" cols="12">
                            <v-alert prominent :type="alert_type" v-if="alert">
                                <v-row align="center">
                                    <v-col class="grow">
                                        {{ alert_message }}
                                    </v-col>
                                    <v-col class="shrink" v-if="course.slug != ''">
                                        <v-btn v-btn :href="'<?php echo SITE_URL ?>/courses/' + course.slug">Mergeți la curs</v-btn>
                                    </v-col>
                                </v-row>
                            </v-alert>
                        </v-col>
                    </v-row>
                </v-form>

            </v-col>
        </v-row>
    </v-form>
</v-container>