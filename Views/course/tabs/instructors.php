
						    	<v-row>
						    		<?php foreach ($data as $instructor): ?>
                    <v-col class="d-flex" cols="6" md="4">
                    	<v-row class="d-flex justify-center">
                    		<v-card class="flex-grow-1 course-teacher-card gradient" elevation="10">
	                    		<v-col class="d-flex justify-center" cols="12">
	                    			

				                    <v-avatar color="white" width="100" height="100">
				                    	<?php if (!empty($instructor['avatar'])): ?>

												      <img src="<?php echo $instructor['avatar'] ?>">

	                    				<?php else: ?>

												      <v-icon color="primary" size="100px">mdi-account-circle</v-icon>

	                    				<?php endif ?>
												    </v-avatar>

	                    		</v-col>
	                    		<v-col class="mb-n6" cols="12">
										    		<p class="text-h5 text-center white--text"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name'] ?></p>
	                    		</v-col>
                    		</v-card>
                    	</v-row>
                    </v-col>
						    		<?php endforeach ?>
						    	</v-row>
						    	