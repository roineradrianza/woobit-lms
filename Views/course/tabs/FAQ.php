
						    	<v-row class="d-flex justify-center">
									<?php foreach ($data as $question): ?>
						    		<v-col cols="12" md="8" class="p-0">
											<v-expansion-panels>
												<v-expansion-panel>
													<v-expansion-panel-header @keyup.space.prevent>
														<v-row class="d-flex align-center" no-gutters>
															<v-col cols="12">
																<p><?= $question['name'] ?></p>
															</v-col>
														</v-row>
													</v-expansion-panel-header>
													<v-expansion-panel-content>
														<?= $question['text'] ?>
													</v-expansion-panel-content>
												</v-expansion-panel>
											</v-expansion-panels>
						    		</v-col>
									<?php endforeach ?>
						    	</v-row>
						    	