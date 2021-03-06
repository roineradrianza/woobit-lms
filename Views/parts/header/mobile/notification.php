<v-menu content-class="notification" center bottom transition="slide-y-transition">
    <template #activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on"
            @click="$http.post('/api/notifications/mark-seen', {notifications: notifications.filter( (notification) => {return notification.seen == 0})})">
            <v-badge color="secondary"
                v-if="notifications.filter( (notification) => {return notification.seen == 0}).length > 0" dot>
                <v-icon class="black--text text--lighten-1">mdi-bell</v-icon>
            </v-badge>
            <v-icon class="black--text text--lighten-1" v-else>mdi-bell</v-icon>
        </v-btn>
    </template>
    <v-row></v-row>
    <v-list>
        <p class="text-center secondary--text font-weight-bold mb-n1">Notificări</p>
        <v-row class="d-flex justify-center align-center">
            <template v-for="notification in notifications" v-if="notifications.length > 0">
                <v-col cols="12">
                    <v-divider></v-divider>
                </v-col>
                <v-col class="px-4" cols="2">
                    <v-avatar color="secondary" size="56">
                        <v-img :src="notification.course_featured_image"
                            v-if="notification.course_featured_image != null"></v-img>
                        <v-icon light v-else>mdi-bell</v-icon>
                    </v-avatar>
                </v-col>
                <v-col class="pl-8 pl-4 pr-4" cols="9" v-html="notification.description">

                    <br>
                    <br>
                </v-col>
                <v-col cols="12" class="d-flex justify-end p-md-0 pr-6 mt-n7 mt-md-n8"
                    v-if="notification.redirect_url != null">
                    <v-btn color="secondary" :href="notification.redirect_url" fab small right light>
                        <v-icon>
                            mdi-arrow-top-right
                        </v-icon>
                    </v-btn>
                </v-col>
            </template>
            <template v-if="notifications.length == 0">
                <v-col class="d-flex justify-center" cols="12" md="8">
                    <img class="ml-n4" src="<?= SITE_URL ?>/img/empty-notifications.svg" width="70%"></img>
                </v-col>
                <v-col class="d-flex justify-center" cols="12" md="9">
                    <h5 class="text-h6 text-center secondary--text font-weight-bold">Nu ai încă notificări</h5>
                </v-col>
            </template>
        </v-row>
        <v-col class="gradient p-0 py-1 mb-n2" cols="12"></v-col>
    </v-list>
</v-menu>