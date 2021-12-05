<v-col cols="12">
    <v-list-item class="px-0" three-line>
        <v-list-item-content>
            <v-list-item-title class="no-white-space">Diplome academic</v-list-item-title>
            <v-list-item-subtitle class="no-white-space">Pe când o diplomă în domeniul în
                care predai nu e
                necesară, te rog enumerează
                toate diplomele pe care le deții, incluzând certificate, mențiuni,
                cursuri,recomandări, etc.
            </v-list-item-subtitle>

            <v-list-item-subtitle class="no-white-space">
                Include anul, instituția care a oferit diploma, specializarea și materia
                învățată.
            </v-list-item-subtitle>
        </v-list-item-content>
    </v-list-item>
</v-col>
<template v-for="certificate, i in <?= !empty($object) ? $object : 'form' ?>.meta.certificates">
    <v-col class="d-flex justify-end" cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
        <v-btn color="error" @click="removeItem(<?= !empty($object) ? $object : 'form' ?>.meta.certificates, i)">Eliminați
        </v-btn>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Anul</label>
        <v-text-field type="text" name="degree_year" v-model="certificate.year" :rules="validations.requiredRules"
            outlined  reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Instituția</label>
        <v-text-field type="text" name="degree_institution" :rules="validations.requiredRules"
            v-model="certificate.institution" outlined
             reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Materiile abordate</label>
        <v-text-field type="text" name="degree_title" v-model="certificate.degree" :rules="validations.requiredRules"
            outlined  reactive>
        </v-text-field>
    </v-col>
</template>
<v-col class="d-flex justify-center py-0" cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
    <v-btn color="primary" @click="addDegree">
        Adăugați
    </v-btn>
</v-col>