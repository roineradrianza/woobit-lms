<v-col cols="12" md="4">
  <label class="body-1 font-weight-thin pl-1">Tipo de documento</label>
  <v-select type="text" name="document_type" :items="['J', 'V', 'E']" v-model="payments.editedItem.meta.document_type" class="mt-3 fl-text-input" filled rounded dense></v-select>
</v-col>

<v-col cols="12" md="8">
  <label class="body-1 font-weight-thin pl-1">N° de documento</label>
  <v-text-field type="text" name="document_id" v-model="payments.editedItem.meta.document_id" class="mt-3 fl-text-input" filled rounded dense></v-text-field>
</v-col>

<v-col cols="12" md="4">
  <label class="body-1 font-weight-thin pl-1">Titular</label>
  <v-text-field type="text" name="owner" v-model="payments.editedItem.meta.owner" class="mt-3 fl-text-input" filled rounded dense></v-text-field>
</v-col>

<v-col cols="12" md="4">
  <label class="body-1 font-weight-thin pl-1">Banco</label>
  <v-text-field type="text" name="bank" v-model="payments.editedItem.meta.bank" class="mt-3 fl-text-input" filled rounded dense></v-text-field>
</v-col>

<v-col cols="12" md="4">
  <label class="body-1 font-weight-thin pl-1">Cuenta Bancaria</label>
  <v-text-field type="text" name="bank_account" v-model="payments.editedItem.meta.bank_account" class="mt-3 fl-text-input" filled rounded dense></v-text-field>
</v-col>
