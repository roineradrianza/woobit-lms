				
					<v-col class="lesson-sidebar mt-12 pl-4" cols="12" md="4" sm="12">
						<h3 class="secondary--text text-h5 font-weight-normal grey lighten-3 py-6 px-8"><?php echo $data['course']['title'] ?></h3>
							<v-tabs class="tabs" background-color="grey lighten-3" v-model="sidebar_tab" show-arrows fixed-tabs>
					    <v-tab class="py-6 black--text text-capitalize" href="#contributions">Aportes</v-tab>
					    <v-tab class="py-6 black--text text-capitalize" href="#questions">Preguntas</v-tab>
					    <v-tab class="py-6 black--text text-capitalize" href="#resources" v-if="resources.length > 0">Recursos</v-tab>
					    <v-tab-item class="px-4 pt-4 pb-10" value="contributions">
								<?php echo new Controller\Template('course/parts/tabs/contributions') ?>
        			</v-tab-item>
					    <v-tab-item class="px-4 pt-4 pb-10" value="questions">
								<?php echo new Controller\Template('course/parts/tabs/questions') ?>
					    </v-tab-item>
					    <v-tab-item class="px-10 py-10" value="resources" v-if="resources.length > 0">
								<?php echo new Controller\Template('course/parts/tabs/resources') ?>
					    </v-tab-item>
					  </v-tabs>
					  <?php echo new Controller\Template('components/snackbar') ?>
					</v-col>