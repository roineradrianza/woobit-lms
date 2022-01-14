<v-sheet class="mb-4" color="grey lighten-4" min-width="100%" rounded="lg" v-if="child_profile.child_selected.hasOwnProperty('user_id')">
    <v-col cols="12">
        <v-row justify="center">
            <v-avatar :color="child_profile.child_selected.gender == 'M' ? 'primary' : '#e70f66'" size="85">
                <v-icon color="white" size="80">
                    {{ child_profile.child_selected.gender == 'M' ? 'mdi-face-man' : 'mdi-face-woman' }}
                </v-icon>
            </v-avatar>
        </v-row>
        <h5 class="text-center text-h6">
            {{ child_profile.child_selected.full_name }}
        </h5>
        <v-row class="mt-6 mb-n3" v-if="child_profile.items.length > 1">
            <v-btn class="p-4" color="primary" @click="child_profile.dialog = true" block>
                Schimbă profilul
            </v-btn>
        </v-row>
    </v-col>
</v-sheet>