				<v-row class="gradient pt-12 pb-12 pl-md-16 pr-md-10">
					<v-col class="pl-10" cols="12">
						<h1 class="white--text text-h2">Rezultate pentru "<?php echo $data['search_item'] ?>"</h1>
					</v-col>
				</v-row>	
				<v-row class="d-flex justify-center">
					<v-col class="CTA ml-md-n2" cols="12" md="6">
						<v-text-field v-model="search" class="font-weight-light mt-16" label="Buscar cursos" light flat outlined dense solo>
			      	<template #append>
			      		<v-btn class="my-4 mx-6 mx-md-0" color="secondary" :href="'<?php echo SITE_URL ?>/courses/?search=' + search" text icon><v-icon size="35">mdi-magnify</v-icon></v-btn>
			      	</template>
			      </v-text-field>
					</v-col>
					<?php if (empty($courses)): ?>
						<?php echo new Controller\Template('courses/parts/not_results'); ?>
					<?php else: ?>
					<v-col cols="12" md="10">
						<?php echo new Controller\Template('courses/parts/search_results', $courses) ?>
					</v-col>
					<?php endif ?>
				</v-row>			