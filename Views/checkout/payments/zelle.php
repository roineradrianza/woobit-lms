<v-col class="mb-n4" cols="12">
    <p>Realice la transferencia zelle usandos los datos a continuación:</p>
</v-col>
<v-col cols="6">
    <p class="font-weight-bold">Datos del titular: <span class="font-weight-light">{{ zelle.owner }}</span></p>
</v-col>
<v-col cols="6">
    <p>Correo electrónico: <span class="font-weight-light">{{ zelle.email }}</span></p>
</v-col>
<v-col cols="12">
    <v-text-field class="fl-text-input" v-model="info.meta.ref"
        placeholder="Ingrese acá el número de confirmación que arroja el banco" hint="Número de confirmación" rounded
        dense></v-text-field>
</v-col>
<v-col class="p-0 mt-n4" cols="12">
    <p class="secondary--text font-weight-bold">Nota: <span class="font-weight-light">El pago será aprobado al realizar
            la verificación de la transferencia. Esto puede demorar hasta 72 horas.</span></p>
</v-col>