<v-col cols="12">
    <p class="subtitle-1">
        Cursuri pe care aș dori să le predau
    </p>
</v-col>
<template v-for="course, i in <?= !empty($object) ? $object : 'form' ?>.meta.courses">
    <v-col class="d-flex justify-end" cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
        <v-btn color="error" @click="removeItem(<?= !empty($object) ? $object : 'form' ?>.meta.courses, i)">Eliminați</v-btn>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Titlul cursului</label>
        <v-text-field type="text" name="course_title" v-model="course.title" :rules="validations.requiredRules" outlined  
            reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12">
        <label class="body-1 font-weight-thin pl-1">Descriere</label>
        <v-textarea name="course_description" v-model="course.description" :rules="validations.descriptionRules"
            counter="2000" auto-grow outlined reactive>
        </v-textarea>
    </v-col>

</template>

<v-col class="d-flex justify-center py-0" cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
    <v-btn color="primary" @click="addCourse">
        Adăugați
    </v-btn>
</v-col>