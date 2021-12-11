  
<div class="text-center">
  <v-snackbar color="snackbar_type" v-model="snackbar" :timeout="snackbar_timeout">
    {{ snackbar_text }}

    <template #action="{ attrs }">
      <v-btn text v-bind="attrs" @click="snackbar = false" dark>
        Închide
      </v-btn>
    </template>
  </v-snackbar>
</div>
