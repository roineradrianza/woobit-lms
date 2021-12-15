<v-row align="center">
    <v-col cols="12" md="3">
        <h1 class="text-h3 font-weight-bold accent--text">Lectori</h1>
    </v-col>
    <v-col cols="12" md="9">
        <v-divider color="#0976c2"></v-divider>
    </v-col>
</v-row>
<v-row>
    <v-col cols="12">
        <p>Bine ai venit in comunitatea Woobit</p>
    </v-col>
    <v-col cols="12">
        <v-row justify="center">
            <?= new Controller\Template('account/parts/private/teacher/partials/panel', $data) ?>
        </v-row>
    </v-col>
</v-row>