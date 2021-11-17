<v-col class="mb-n4" cols="12">
	<p class="subtitle-1 secondary--text font-weight-bold">Datos de la cuenta bancaria a la que se realizó el pago:</p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Carte de identitate: <span class="font-weight-light black--text">{{ order.meta.document }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Titular: <span class="font-weight-light black--text">{{ order.meta.owner }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Banco: <span class="font-weight-light black--text">{{ order.meta.bank }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Cuenta bancaria: <span class="font-weight-light black--text">{{ order.meta.bank_account }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Suma Total: <span class="font-weight-light black--text">{{ AmountInBs }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">N° de Referencia: <span class="font-weight-light black--text">{{ order.meta.ref }}</span></p>
</v-col>