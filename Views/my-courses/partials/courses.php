<v-row>
    <v-col class="py-0" cols="12">
        <v-text-field label="Căutați cursurile mele" append-icon="mdi-magnify" v-model="search" outlined></v-text-field>
    </v-col>
    <v-col md="4" v-for="course, i in filtered_courses" :key="i">
        <v-card class="my-12 flex-grow-1">

            <v-img :height="$vuetify.breakpoint.name == 'xs' ? '' : 200" :src="'<?= SITE_URL?>' + course.featured_image"></v-img>
            <v-card-subtitle class="mb-n6">{{ course.category }}</v-card-subtitle>
            <v-card-title class="font-weight-bold">{{ course.title }}</v-card-title>
            <v-card-text>
                <v-divider></v-divider>
            </v-card-text>
            <v-card-actions class="pt-0">
                <v-container>
                    <v-row align="center" class="mx-0">
                        <v-col class="d-flex align-center" cols="12" md="7" lg="8">
                            <v-rating :value="Math.round(course.ratings.average)" color="amber" dense half-increments readonly size="18">
                            </v-rating>

                            <span class="grey--text">
                                {{ course.ratings.total }}
                            </span>
                        </v-col>

                        <v-col cols="12" md="5" lg="4">
                            <p class="mt-2">{{ course.price <= 0 ? 'FREE' : course.price + ' RON' }}</p>
                        </v-col>
                    </v-row>
                    <v-row justify="center">
                        <v-btn-toggle>
                            <v-btn class="secondary" :href="'<?= SITE_URL?>/cursuri/' + course.slug" icon>
                                <v-icon>mdi-eye</v-icon>
                            </v-btn>
                            <v-btn class="primary" :href="'<?= SITE_URL?>/cursuri/edit/' + course.course_id" icon>
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                        </v-btn-toggle>
                    </v-row>
                </v-container>

            </v-card-actions>
        </v-card>
    </v-col>
</v-row>