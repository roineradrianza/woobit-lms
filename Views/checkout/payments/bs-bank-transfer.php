<v-col class="mb-n4" cols="12">
    <p>Realice la transferencia bancaria usandos los datos a continuación:</p>
</v-col>
<v-col cols="6">
    <p class="font-weight-bold">Documento de Identidad: <span class="font-weight-light">{{ Document }}</span></p>
</v-col>
<v-col cols="6">
    <p>Titular: <span class="font-weight-light">{{ bs_bank_transfer.owner }}</span></p>
</v-col>
<v-col cols="6">
    <p>Banco: <span class="font-weight-light">{{ bs_bank_transfer.bank }}</span></p>
</v-col>
<v-col cols="6">
    <p>Cuenta bancaria: <span class="font-weight-light">{{ bs_bank_transfer.bank_account }}</span></p>
</v-col>
<v-col cols="6" md="6">
    <p>Monto Antes de Impuestos: <span class="font-weight-light">{{ AmountInBs }}</span></p>
</v-col>
<v-col cols="6" md="2">
    <p>IVA: <span class="font-weight-light">16%</span></p>
</v-col>
<v-col cols="6" md="4">
    <p class="font-weight-bold primary--text">Monto Total: <span class="font-weight-light">{{ AmountWithIVA }}</span>
    </p>
</v-col>
<v-col cols="12">
    <v-alert color="info" dark dense icon="mdi-information" prominent>
        Es importante que el monto a transferir coincida con el monto total especificado.
    </v-alert>
</v-col>
<v-col cols="12">
    <v-text-field class="fl-text-input" v-model="info.meta.ref"
        placeholder="Ingrese acá el número de referencia que arroja el banco" hint="Número de referencia" rounded dense>
    </v-text-field>
</v-col>
<v-col class="p-0 mt-n4" cols="12">
    <p class="secondary--text font-weight-bold">Nota: <span class="font-weight-light">El pago será aprobado
            al realizar la verificación de la transferencia. Esto puede demorar hasta 72 horas.</span></p>
</v-col>