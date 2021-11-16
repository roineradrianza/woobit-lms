<v-col cols="12" md="6">
  <label class="body-1 font-weight-thin pl-1">Datos del Títular</label>
  <v-text-field type="text" name="owner" v-model="payments.editedItem.meta.owner" class="mt-3 fl-text-input" filled rounded dense></v-text-field>
</v-col>

<v-col cols="12" md="6">
  <label class="body-1 font-weight-thin pl-1">Correo electrónico</label>
  <v-text-field type="text" v-model="payments.editedItem.meta.email" class="mt-3 fl-text-input" :rules="validations.email" filled rounded dense></v-text-field>
</v-col>
