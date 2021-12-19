<v-container fluid class="pt-16 pt-md-0 secondary">
    <v-container>
        <v-row class="py-6">
            <v-col cols="12">
                <h2 class="text-center text-h4 white--text">Bine ai revenit,
                    <?= "{$_SESSION['first_name']} {$_SESSION['last_name']}" ?>
                </h2>
            </v-col>
            <v-col class="d-flex justify-center" cols="12">
                <v-btn class="primary--text" color="white">Cursuri noi</v-btn>
            </v-col>
        </v-row>
    </v-container>
</v-container>
<v-container class="px-4 px-md-0">
    <v-row>
        <v-col class="px-6" cols="12" md="6" v-for="child, i in children.items"
            v-if="filterLatestCourses(child.children_id).length > 0" :key="i">
            <v-row>
                <v-col cols="12">
                    <p class="text-center text-md-left text-h4">
                        Cursurile lui {{ child.first_name }}:
                    </p>
                </v-col>
                <v-col class="d-flex justify-center d-md-inline" cols="12" md="4"
                    v-for="course, i in filterLatestCourses(child.children_id)" :key="i">
                    <v-tooltip top color="primary">
                        <template #activator="{ on, attrs }">
                            <v-card color="secondary" :href="'<?= SITE_URL ?>/cursuri/' + course.slug" width="300px" height="200px" v-bind="attrs" v-on="on">
                                <v-img :src="course.featured_image" max-width="100%" height="100%">
                                </v-img>
                            </v-card>
                        </template>
                        <span>{{ course.title }}</span>
                    </v-tooltip>

                </v-col>
            </v-row>
        </v-col>
        <v-col cols="12">
            <form :action="'<?= SITE_URL ?>/cursuri/?search=' + search" method="GET">
                <v-row>
                    <v-col cols="12" md="2" order="2" order-md="1">
                        <v-btn class="white--text py-6 px-4" color="#e70f66"
                            :href="'<?= SITE_URL ?>/cursuri/?search=' + search" block rounded>
                            Explorează:
                        </v-btn>
                    </v-col>
                    <v-col cols="12" md="10" order="1" order-md="2">
                        <v-text-field v-model="search" label="Ce dorești să înveți?" outlined>
                        </v-text-field>
                    </v-col>
                </v-row>
            </form>
        </v-col>
    </v-row>
</v-container>