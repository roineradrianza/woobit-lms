<v-row class="d-flex justify-center">
    <?php echo new Controller\Template('components/snackbar') ?>
    <?php echo new Controller\Template('course/tabs/list_tabs/users/registered-users') ?>
    <?php echo new Controller\Template('course/tabs/list_tabs/users/graduated-users') ?>
    <?php echo new Controller\Template('course/tabs/list_tabs/users/pending-users') ?>
    <?php echo new Controller\Template('course/tabs/list_tabs/users/pending-instructors') ?>
    <?php echo new Controller\Template('course/tabs/list_tabs/users/listeners') ?>
</v-row>