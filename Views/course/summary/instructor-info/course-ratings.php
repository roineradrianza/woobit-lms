<template v-if="rating != null">
    <?= new \Controller\Template('components/snackbar', [
        'snackbar' => 'rating.snackbar',
        'snackbar_timeout' => 'rating.snackbar_timeout',
        'snackbar_text' => 'rating.snackbar_text'
    ]) ?>
    <v-row>
        <v-col class="justify-center" cols="12">
            <h4 class="text-h5 text-center text-md-left">{{ rating.loading ? '' : rating.items.length }} Recenzii</h4>
            <v-rating class="d-flex d-md-inline justify-center" :value="5" color="amber" dense half-increments readonly
                size="36">
            </v-rating>
        </v-col>
    </v-row>

    <v-row v-if="rating.loading">
        <v-col cols="12" v-for="i in 4">
            <v-skeleton-loader class="full-height" width="100%" type="image"></v-skeleton-loader>
        </v-col>
    </v-row>

    <v-row>
        <?php if(!empty($_SESSION['user_id'])): ?>
        <?= new \Controller\Template('course/summary/instructor-info/rating-form')  ?>
        <?php endif ?>
        <v-col v-for="item, i in rating.items" cols="12" :key="i">
            <v-sheet color="#F6F6F8" rounded="xl">
                <v-row class="px-6">
                    <v-col cols="12">
                        <v-rating :value="item.stars" color="amber" dense half-increments readonly size="18">
                        </v-rating>
                        <p class="grey--text lighten-2 subtitle-1">
                            {{ rating.formatDate(item.published_at, 'll') }}</p>
                        <p>{{ item.comment }}</p>
                        <v-row>
                            <v-col cols="10">

                                <template v-if="item.avatar != null">
                                    <v-avatar size="42">
                                        <v-img :src="item.avatar"
                                            :alt="item.first_name">
                                        </v-img>
                                    </v-avatar>
                                </template>
                                
                                <template v-else>
                                    <v-icon color="primary">mdi-account-circle</v-icon>
                                </template>

                                <a href="#"><strong> {{ item.first_name + ' ' + item.last_name }} </strong></a>
                            </v-col>
                            <?php if(!empty($_SESSION['user_id']) && $_SESSION['user_type'] == 'administrator') : ?>
                            <v-col cols="2">
                                <v-icon class="mr-1" @click="rating.deleteItem(item, i)">
                                    mdi-trash-can
                                </v-icon>
                            </v-col>
                            <?php endif ?>
                        </v-row>

                    </v-col>
                </v-row>
            </v-sheet>
        </v-col>
    </v-row>
</template>