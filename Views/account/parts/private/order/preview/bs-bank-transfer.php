<v-col class="mb-n4" cols="12">
	<p class="subtitle-1 secondary--text font-weight-bold">Detalii privind contul bancar în care a fost efectuată plata:</p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Carte de identitate: <span class="font-weight-light black--text">{{ orders.editedItem.meta.document }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Suport: <span class="font-weight-light black--text">{{ orders.editedItem.meta.owner }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Banca: <span class="font-weight-light black--text">{{ orders.editedItem.meta.bank }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Cont bancar: <span class="font-weight-light black--text">{{ orders.editedItem.meta.bank_account }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Suma totală: <span class="font-weight-light black--text">{{ AmountInBs }}</span></p>
</v-col>
<v-col cols="4">
	<p class="body-1 primary--text">Nr. de referință: <span class="font-weight-light black--text">{{ orders.editedItem.meta.ref }}</span></p>
</v-col>