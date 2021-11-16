
						    	<v-row class="d-flex justify-center">
						    		<v-alert border="top" colored-border type="info" elevation="2" dismissible>Puedes organizar el orden de las preguntas manteniendo presionado <v-icon>mdi-menu</v-icon> y arrastrandolo al lugar que deseas colocar</v-alert>
						    		<v-col class="d-flex justify-center" cols="12">
						    			<v-btn class="secondary white--text" @click="addFAQ">Agregar pregunta</v-btn>
						    		</v-col>
						    		<v-col cols="12" md="8" class="p-0">
											<v-expansion-panels>
												<draggable class="col col-12" v-model="faq.items">
													<v-expansion-panel v-for="item in faq.items" :key="item.id">
														<v-expansion-panel-header @keyup.space.prevent>
															<v-row class="d-flex align-center" no-gutters>
																<v-col class="d-flex justify-center p-0" cols="1">
																	<v-icon>mdi-menu</v-icon>
																</v-col>
																<v-col class="d-flex justify-center p-0" cols="1">
																	<v-icon color="red" @click="removeFAQ(item)">mdi-delete</v-icon>
																</v-col>
																<v-col cols="10">
																	<v-text-field v-model="item.name" class="mt-3 fl-text-input" placeholder="Pregunta" @click.native.stop filled rounded dense :disabled="faq.add_loading"></v-text-field>
																</v-col>
															</v-row>
														</v-expansion-panel-header>
														<v-expansion-panel-content>
															<vue-editor :id="'editor'+item.id" class="mt-3 fl-text-input" v-model="item.text" :editor-toolbar="faq.customToolbar" placeholder="Respuesta de la pregunta" :disabled="faq.add_loading"/>
															{{ formatText(item.text) }}
														</v-expansion-panel-content>
													</v-expansion-panel>
												</draggable>
											</v-expansion-panels>
											<v-col class="px-3">
												<v-btn class="primary white--text" @click="saveFAQ" :loading="faq.add_loading" block>Guardar cambios</v-btn>												
											</v-col>
						    		</v-col>						    	
						    	</v-row>
						    	