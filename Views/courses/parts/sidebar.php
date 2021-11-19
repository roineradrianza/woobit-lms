
					<v-col class="mb-12 border-right"  cols="12" md="2">
						<h3 class="text-h4">Categorías</h3>
						<?php foreach ($data as $category): ?>
						<?php if (!empty($category['courses'])): ?>

							<v-list-item class="pl-0">
					      <v-list-item-content>
					      		
					        <v-list-item-title class="grey--text text--darkten-1 text-h5"><?= $category['name'] ?></v-list-item-title>
					      	<template v-if="1 == 2">
						        <v-list-item-subtitle class="body-1 grey--text text--lighten-1">Lorem ipsum</v-list-item-subtitle>
						        <v-list-item-subtitle class="body-1 grey--text text--lighten-1">Lorem ipsum</v-list-item-subtitle>
						        <v-list-item-subtitle class="body-1 grey--text text--lighten-1">Lorem ipsum</v-list-item-subtitle>
						        <v-list-item-subtitle class="body-1 grey--text text--lighten-1">Lorem ipsum</v-list-item-subtitle>
					      	</template>

					      </v-list-item-content>
					    </v-list-item>

						<?php endif ?>
						<?php endforeach ?>

						<template v-if="1 == 2">
							<h3 class="text-h4 mt-10">Cursos Avalados</h3>
							<v-list-item class="pl-0">
					      <v-list-item-content>
					        <v-list-item-title class="grey--text text--darkten-1 text-h5">Desarrollo</v-list-item-title>
					        <v-list-item-subtitle class="body-1 grey--text text--lighten-1">Lorem ipsum</v-list-item-subtitle>
					        <v-list-item-subtitle class="body-1 grey--text text--lighten-1">Lorem ipsum</v-list-item-subtitle>
					        <v-list-item-subtitle class="body-1 grey--text text--lighten-1">Lorem ipsum</v-list-item-subtitle>
					        <v-list-item-subtitle class="body-1 grey--text text--lighten-1">Lorem ipsum</v-list-item-subtitle>

					      </v-list-item-content>
					    </v-list-item>
							
						</template>
					</v-col>