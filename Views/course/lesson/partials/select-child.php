<?php if( count($students_enrolled) > 0 ) : ?>
<v-dialog v-model="child_profile.dialog" max-width="800px" persistent>
    <v-card>
        <v-toolbar class="gradient" elevation="0">
            <v-toolbar-title class="white--text">Selectați profilul</v-toolbar-title>
        </v-toolbar>

        <v-divider></v-divider>

        <v-card-text>
            <v-form>
                <v-row>
                    <v-col cols="12">
                        <label>Copii înscriși în această secțiune</label>
                        <v-select ref="child_profile_select" v-model="child_profile.child_selected" :items='
                            [
                                <?php foreach($students_enrolled as $child) : ?>
                                    {
                                        full_name: "<?= "{$child['first_name']} {$child['last_name']}" ?>",
                                        first_name: "<?= $child['first_name']?>",
                                        last_name: "<?= $child['last_name']?>",
                                        gender: "<?= $child['gender']?>",
                                        user_id: "<?= $child['user_id']?>",
                                    },
                                <?php endforeach?>
                            ]
                        ' item-text="full_name" @change="child_profile.child_id = child_profile.child_selected.user_id" return-object></v-select>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>

        <v-card-actions class="px-5">
            <v-spacer></v-spacer>
            <v-btn color="secondary white--text" block @click="child_profile.save()"
                :disabled="!child_profile.child_selected.hasOwnProperty('user_id')">
                Salvați
            </v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>
<?php endif ?>