<v-col class="mb-n4" cols="12">
	<p class="subtitle-1 secondary--text font-weight-bold">Datos del PagoMóvil al que se realizó el pago:</p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Documento de Identidad: <span class="font-weight-light black--text">{{ orders.editedItem.meta.document }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Titular: <span class="font-weight-light black--text">{{ orders.editedItem.meta.owner }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Banco: <span class="font-weight-light black--text">{{ orders.editedItem.meta.bank }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Número de Télefono: <span class="font-weight-light black--text">{{ orders.editedItem.meta.telephone }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Monto Total: <span class="font-weight-light black--text">{{ AmountInBs }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">N° de Referencia: <span class="font-weight-light black--text">{{ orders.editedItem.meta.ref }}</span></p>
</v-col>