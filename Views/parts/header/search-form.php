<template>
    <v-dialog :value="false" ref="menu_search_dialog" transition="dialog-top-transition" max-width="600">
        <v-card class="pt-8">
            <v-card-text class="mb-n10">
                <v-text-field ref="menu_search" label="Ce dorești să înveți?" solo>
                    <template #append>
                        <v-btn color="secondary"
                            :href="'<?= SITE_URL ?>/courses/?search=' + $refs.menu_search.internalValue"
                            text icon>
                            <v-icon>mdi-magnify</v-icon>
                        </v-btn>
                    </template>
                </v-text-field>
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn text @click="$refs.menu_search_dialog.isActive = false">Închideți</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>