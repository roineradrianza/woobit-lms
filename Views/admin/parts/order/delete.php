<v-dialog v-model="dialogOrderDelete" max-width="50%">
  <v-card>
    <v-card-title class="headline d-flex justify-center">¿Estás seguro de que quieres eliminar esta orden de pago?</v-card-title>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="primary" text @click="closeOrderDelete">Cancelar</v-btn>
      <v-btn color="secondary" text @click="deleteOrderItemConfirm">Continuar</v-btn>
      <v-spacer></v-spacer>
    </v-card-actions>
  </v-card>
</v-dialog>