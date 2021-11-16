<v-col class="lesson" cols="12" md="8" sm="12">
    <v-breadcrumbs></v-breadcrumbs>
    <template v-if="video_loading">
        <v-skeleton-loader class="full-height" width="100%" type="image"></v-skeleton-loader>
    </template>
    <video-player id="video-lesson" :options="playerOptions" class="vjs-custom-skin mt-3" ref="videoPlayer"
        @play="onPlayerPlay($event)" @pause="onPlayerPause($event)" @ended="onPlayerEnded($event)"
        @loadeddata="onPlayerLoadeddata($event)" @waiting="onPlayerWaiting($event)" @playing="onPlayerPlaying($event)"
        @timeupdate="onPlayerTimeupdate($event)" @canplay="onPlayerCanplay($event)"
        @canplaythrough="onPlayerCanplaythrough($event)" @ready="playerReadied"
        @statechanged="playerStateChanged($event)" v-else></video-player>
    <h3 class="my-5"><?php echo $data['lesson']['lesson_name'] ?></h3>
    <?php if (isset($course['manage_course']) && $course['manage_course']):?>
    <v-col class="pl-0" cols="11">
        <template v-if="percent_loading_active">
            <v-col class="p-0 mb-n6" cols="12">
                <p class="text-center" v-if="percent_loading < 100">Descargando clase</p>
                <p class="text-center" v-else>Descarga completada, espere un momento...</p>
            </v-col>
            <v-col class="p-0" cols="12">
                <v-progress-linear :active="percent_loading_active" :value="percent_loading" height="20">
                    <template v-slot:default="{ value }">
                        <strong>{{ Math.ceil(value) }}%</strong>
                    </template>
                </v-progress-linear>
            </v-col>
        </template>
        <template v-if="isLocalFile(meta.video_url)">
            <v-btn color="secondary" :href="meta.video_url" download block light>Descargar clase</v-btn>
        </template>
        <template v-else>
            <v-btn @click="saveFile(meta.video_url)" color="secondary" :disabled="percent_loading_active" block light>
                Descargar clase</v-btn>
        </template>
    </v-col>
    <?php endif ?>
    <v-col cols="12" v-html="meta.description">
    </v-col>
    <v-col class="pl-0" cols="11">
        <v-divider class="secondary mb-5"></v-divider>
        <?php if (!empty($data['lesson']['first_name']) && !empty($data['lesson']['last_name'])): ?>
        <v-avatar>
            <img src="<?php echo $data['lesson']['avatar'] ?>" alt="John">
        </v-avatar>
        <span class="font-weight-light">By:
            <?php echo $data['lesson']['first_name'] . ' ' . $data['lesson']['last_name']?></span>
        <?php endif ?>
    </v-col>
    <?php if (!empty($data['course']['course_sponsors'])): ?>
    <v-col class="d-flex justify-center" cols="11">
        <v-row class="d-flex justify-center">
            <v-col cols="11">
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
</v-col>