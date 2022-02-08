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
                            <v-card color="secondary" :href="'<?= SITE_URL ?>/cursuri/' + course.slug" width="300px"
                                height="200px" v-bind="attrs" v-on="on">
                                <v-img :src="course.featured_image" max-width="100%" height="100%">
                                </v-img>
                            </v-card>
                        </template>
                        <span>{{ course.title }}</span>
                    </v-tooltip>

                </v-col>
            </v-row>
        </v-col>
        <v-col cols="12" v-if="!existsChildCourses">
            <v-row justify="center">
                <v-col class="d-flex justify-center" cols="12" md="8">
                    <v-img src="<?= SITE_URL ?>/img/no-courses.svg" max-width="50%"></v-img>
                </v-col>
                <v-col cols="12" md="8">
                    <h4 class="text-h5 text-center">
                        Nu ești înscris/ă la niciun curs. Caută cursul perfect pentru tine
                    </h4>
                </v-col>
            </v-row>
        </v-col>
        <v-col cols="12">
            <form :action="'<?= SITE_URL ?>/cursuri/?search=' + search" method="GET">
                <v-row>
                    <v-col cols="12" md="2" order="4" order-md="1">
                        <v-btn class="white--text py-6 px-4" color="#e70f66"
                            :href="'<?= SITE_URL ?>/cursuri/get?search=' + search + 
                            '&start_date=' + start_date + '&category=' + category" block rounded>
                            Explorează:
                        </v-btn>
                    </v-col>

                    <v-col cols="12" md="6" order="1" order-md="2">
                        <v-text-field v-model="search" label="Ce dorești să înveți?" 
                        @keyup.enter="searchCourse" outlined>
                        </v-text-field>
                    </v-col>

                    <v-col class="ml-md-n2" cols="12" md="2" order="2" order-md="3">
                        <v-dialog ref="start_date_dialog" v-model="start_date_modal" :return-value.sync="start_date"
                            width="20vw">
                            <template #activator="{ on, attrs }">
                                <v-text-field v-model="start_date" name="start_date"
                                    label="Data de începere" readonly v-bind="attrs" v-on="on" outlined>
                                    <template #append>
                                        <v-icon v-bind="attrs" v-on="on">
                                            mdi-calendar
                                        </v-icon>
                                    </template>
                                </v-text-field>
                            </template>
                            <v-date-picker v-model="start_date" scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="start_date_modal = false">
                                    Anulează
                                </v-btn>
                                <v-btn text color="primary" @click="$refs.start_date_dialog.save(start_date)">
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </v-col>

                    <v-col class="ml-md-n2" cols="12" md="2" order="3" order-md="4">
                        <v-select v-model="category" :items="[
                            {
                                text: '',
                                value: '',
                            },
                            <?php foreach($categories as $category): ?>
                                <?php if($category['courses'] > 0) : ?>
                                    {
                                        text: '<?= $category['name'] ?>',
                                        value: <?= $category['category_id'] ?>
                                    },
                                <?php endif ?>
                            <?php endforeach?>
                            ]" name="category" label="Categorie" outlined>
                        </v-select>
                    </v-col>
                </v-row>
            </form>
        </v-col>
        <v-col cols="12">
            <v-row justify="center">
                <v-col class="d-flex justify-center" cols="6" md="2" v-for="category in categories">
                    <v-chip color="primary" :href="'<?= SITE_URL?>/categorie/' + category.category_id">
                        {{ category.name }}
                    </v-chip>
                </v-col>
            </v-row>
        </v-col>
        <v-col cols="12">
            <h4 class="text-h5 text-center">
                Te interesează un subiect anume? Ne interesează și pe noi! Trimite-ne un email la <span
                    class="primary--text">hello@woobit.ro</span>
            </h4>
        </v-col>
    </v-row>
</v-container>

<v-container class="px-4" fluid>
    <v-col cols="12">
        <v-row>
            <v-col cols="3" v-for="course in courses">
                <v-card class="my-12 flex-grow-1" :href="'<?= SITE_URL?>/cursuri/' + course.slug">

                    <v-img height="200" :src="course.featured_image"></v-img>
                    <v-card-subtitle class="mb-n6">{{ course.category}}</v-card-subtitle>
                    <v-card-title class="font-weight-bold">{{ course.title }}</v-card-title>
                    <v-card-text>
                        <v-divider></v-divider>
                    </v-card-text>
                    <v-card-actions class="pt-0">
                        <v-row align="center" class="mx-0">
                            <v-col class="d-flex align-center" cols="12" md="7" lg="8">
                                <v-rating :value="Math.round(course.ratings.average)" color="amber" dense
                                    half-increments readonly size="18">
                                </v-rating>

                                <span class="grey--text">
                                    {{ course.ratings.total }}
                                </span>
                            </v-col>

                            <v-col cols="12" md="5" lg="4">
                                <p class="mt-2">{{ course.price <= null ? 'FREE' : course.price + " RON" }}</p>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-col>
</v-container>