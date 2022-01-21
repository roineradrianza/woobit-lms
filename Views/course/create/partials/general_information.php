<v-row>

    <v-col cols="12" md="6">
        <label>Imaginea de copertă a cursului</label>
        <v-file-input
            v-model="<?= !empty($object) ? $object : 'course' ?>.<?= !empty($featured_image) ? 'new_featured_image' : 'featured_image' ?>"
            label="" truncate-length="66" accept=".jpg, .jpeg, .png, .svg"
            :rules="<?= !empty($object) ? $object : 'course' ?>.featured_image != '' ? validations.featuredImageRules : ''"
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
        <v-text-field name="course_title" v-model="<?= !empty($object) ? $object : 'course' ?>.title"
            :rules="validations.titleRules" outlined counter="100">
        </v-text-field>
    </v-col>

    <v-col cols="12" md="6" v-if="<?= !empty($object) ? $object : 'course' ?>.course_id > 0">
        <label>Stare</label>
        <v-select name="course_state" v-model="<?= !empty($object) ? $object : 'course' ?>.active" :items="true_false"
            outlined>
        </v-select>
    </v-col>

    <v-col cols="12" md="6">
        <label>Categorie</label>
        <v-select v-model="<?= !empty($object) ? $object : 'course' ?>.category_id"
            :items="<?= !empty($categories) ? $categories : 'categories' ?>" item-text="name" item-value="category_id"
            :rules="validations.requiredRules" outlined></v-select>
    </v-col>

    <v-col cols="12" md="6">
        <label>Tagline-ul</label>
        <v-text-field name="description" v-model="<?= !empty($object) ? $object : 'course' ?>.meta.description"
            :rules="validations.descriptionRules" outlined counter="65">
        </v-text-field>
    </v-col>

    <v-col cols="12" md="6">
        <label>Ora cursului</label>
        <v-text-field name="course_duration" v-model="<?= !empty($object) ? $object : 'course' ?>.duration" outlined>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="6">
        <label>Preț</label>
        <v-text-field type="number" name="course_price" v-model="<?= !empty($object) ? $object : 'course' ?>.price"
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
                        <v-range-slider v-model="age_range" :max="max_age" :min="min_age" hide-details
                            class="align-center">
                            <template #prepend>
                                <v-text-field v-model="age_range[0]" class="mt-0 pt-0" outlined dense readonly
                                    type="number" style="width: 60px" @change="$set(age_range, 0, $event)">
                                </v-text-field>
                            </template>
                            <template #append>
                                <v-text-field v-model="age_range[1]" class="mt-0 pt-0" outlined dense readonly
                                    type="number" style="width: 60px" @change="$set(age_range, 1, $event)">
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
                        <v-text-field label="Minim" type="number"
                            v-model="<?= !empty($object) ? $object : 'course' ?>.min_students" name="min_students"
                            :rules="validations.minRules" outlined>
                        </v-text-field>
                    </v-col>

                    <v-col cols="6" class="py-0">
                        <v-text-field label="Maxim" type="number"
                            v-model="<?= !empty($object) ? $object : 'course' ?>.max_students" name="max_students"
                            :rules="validations.maxRules" outlined>
                        </v-text-field>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-col>

    <v-col cols="12" md="12">
        <label class="body-1 font-weight-thin pl-1">Descrierea cursului</label>
        <vue-editor class="mt-3 fl-text-input" :editor-toolbar="customToolbar" v-model="<?= !empty($object) ? $object : 'course' ?>.meta.long_description"
            placeholder="Descrierea cursului" />
    </v-col>

</v-row>