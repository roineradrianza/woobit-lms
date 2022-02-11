<v-container>
    <v-row class="mt-4 d-flex justify-center">
        <v-col class="mw-lg" cols="12">
            <v-row class="d-flex">
                <v-col class="d-md-flex align-end" cols="12" md="8">
                    <h2 class="text-h3 primary--text text-center text-md-left">
                        Lectori
                    </h2>
                </v-col>

                <v-col class="d-flex justify-center justify-md-end" cols="12" md="4">
                    <v-btn color="secondary">Continuă</v-btn>
                </v-col>

                <v-col cols="12" order="3">
                    <v-row class="d-block d-md-none">
                        <v-carousel class="custom_carousel no-ha pb-4" cycle :show-arrows="false"
                            hide-delimiter-background>
                            <?php if(!empty($teachers)) : ?>

                            <?php foreach($teachers as $instructor) : ?>
                            <v-carousel-item>
                                <v-col cols="12">
                                    <?= new \Controller\Template('home/partials/instructors/template', $instructor) ?>
                                </v-col>
                            </v-carousel-item>

                            <?php endforeach ?>

                            <?php else: ?>

                            <?= new \Controller\Template('home/partials/instructors/empty_carousel') ?>

                            <?php endif ?>
                        </v-carousel>
                    </v-row>

                    <v-row class="d-none d-md-flex" justify="space-between">

                        <?php if(!empty($teachers)) : ?>

                        <?php foreach($teachers as $instructor) : ?>
                        <v-col cols="12" md="2">
                            <?= new \Controller\Template('home/partials/instructors/template', $instructor) ?>
                        </v-col>
                        <?php endforeach ?>

                        <?php else: ?>

                        <?= new \Controller\Template('home/partials/instructors/empty') ?>

                        <?php endif ?>

                    </v-row>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</v-container>