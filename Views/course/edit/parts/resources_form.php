    
    <v-row>

      <v-col cols="12" md="12">
        <label class="body-1 font-weight-thin pl-1">Descriere</label>
        <vue-editor id="lesson_editor" class="mt-3 fl-text-input" v-model="lessons.item.meta.description" placeholder="Descriere del curso" />
      </v-col>

     <?php echo new Controller\Template('course/edit/parts/resources') ?>
     <?php echo new Controller\Template('components/alert') ?>

    </v-row>
    