<v-tabs v-model="list_tab" fixed-tabs centered show-arrows ref="list_tabs_section">
    <v-tab class="pt-6 primary--text font-weight-light" href="#users">Integrantes</v-tab>

    <v-tab class="pt-6 primary--text font-weight-light" href="#classes" v-if="sections.length > 0">Clases
    </v-tab>

    <v-tab class="pt-6 primary--text font-weight-light" href="#quizzes" v-if="sections.length > 0">Quizzes
    </v-tab>

    <v-tab class="pt-6 primary--text font-weight-light" href="#orders" v-if="sections.length > 0">Órdenes
    </v-tab>

    <v-tab-item class="px-3 pt-5" value="users">
        <?php echo new Controller\Template('course/tabs/list_tabs/users') ?>
    </v-tab-item>

    <v-tab-item class="px-3 py-10" value="classes">
        <?php echo new Controller\Template('course/tabs/list_tabs/classes') ?>
    </v-tab-item>

    <v-tab-item class="px-3 py-10" value="quizzes">
        <?php echo new Controller\Template('course/tabs/list_tabs/quizzes') ?>
    </v-tab-item>

    <v-tab-item class="px-3 py-10" value="orders">
        <?php echo new Controller\Template('course/tabs/list_tabs/orders') ?>
    </v-tab-item>

</v-tabs>