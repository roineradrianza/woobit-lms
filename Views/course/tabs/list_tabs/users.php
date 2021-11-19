<v-row class="d-flex justify-center">
    <?= new Controller\Template('components/snackbar') ?>
    <?= new Controller\Template('course/tabs/list_tabs/users/registered-users') ?>
    <?= new Controller\Template('course/tabs/list_tabs/users/graduated-users') ?>
    <?= new Controller\Template('course/tabs/list_tabs/users/pending-users') ?>
    <?= new Controller\Template('course/tabs/list_tabs/users/pending-instructors') ?>
    <?= new Controller\Template('course/tabs/list_tabs/users/listeners') ?>
</v-row>