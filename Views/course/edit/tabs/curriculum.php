
						    	<v-row class="d-flex justify-center">
						    		<v-alert border="top" colored-border type="info" elevation="2" dismissible>En esta sección sólo necesitarás guardar en cada elemento cuando se presente el botón de <b>"Guardar"</b></v-alert>
						    		<v-alert border="top" colored-border type="info" elevation="2" dismissible>Puedes organizar el orden de las secciones y clases manteniendo presionado <v-icon>mdi-menu</v-icon> y arrastrandolo al lugar que deseas colocar</v-alert>
						    		<v-col class="d-flex justify-center" cols="12">
						    			<v-btn class="secondary white--text" @click="addSection" :loading="curriculum.add_loading">Agregar Sección</v-btn>
						    		</v-col>
						    		<v-col cols="12" md="9" class="p-0">
											<v-expansion-panels :disabled="curriculum.loading">
												<draggable class="col col-12" v-model="curriculum.sections">
													<v-expansion-panel v-for="(section, section_index) in curriculum.sections" :key="section.section_id">
														<v-expansion-panel-header @keyup.space.prevent>
															<v-row class="d-flex justify-end" no-gutters>
																<v-col class="d-flex justify-start p-0" cols="9" v-if="!checkSectionNames(section)">
																	Sección {{ section_index + 1 }}
																</v-col>
																<v-col class="d-flex justify-start p-0" cols="10" v-else>
																	Sección {{ section_index + 1 }}
																</v-col>
																<v-col class="d-flex justify-end p-0" cols="1" v-if="!checkSectionNames(section)">
																	<v-btn class="primary--text" :loading="curriculum.update_section_loading" @click.native.stop @click="updateSection(section)" text>Guardar</v-btn>
																</v-col>
																<v-col class="d-flex justify-end p-0" cols="1">
																	<v-icon>mdi-menu</v-icon>
																</v-col>
																<v-col class="d-flex justify-end p-0" cols="1">
																	<v-icon color="red" @click="removeSection(section)">mdi-delete</v-icon>
																</v-col>
																<v-col cols="12">
																	<v-text-field v-model="section.section_name" class="mt-3 fl-text-input" placeholder="Înregistrare de la sección" @click.native.stop filled rounded dense :disabled="curriculum.add_loading"></v-text-field>
																</v-col>
															</v-row>
														</v-expansion-panel-header>
														<v-expansion-panel-content>
															<v-col class="d-flex justify-center" cols="12">
											    			<v-btn class="secondary white--text" @click="addLesson(section_index)" :loading="curriculum.add_lesson_loading">Agregar lección</v-btn>
											    		</v-col>
															<draggable class="col col-12" :v-model="section.items">
																<v-row v-for="(lesson,index) in section.items" :key="lesson.id">
																		<v-row class="d-flex justify-end align-center" no-gutters>
																			<v-col class="d-flex justify-start p-0" cols="9">
																				<v-row>
																					<v-col cols="8" md="3">
																						<v-select class="v-normal-input" v-model="lesson.lesson_type" label="Tipo de lección" :items="lessons.types" item-text="text" @change="lesson.old_lesson_name += ' '" item-value="value" dense></v-select>
																					</v-col>
																				</v-row>
																			</v-col>
																			<v-col class="d-flex justify-end p-0" cols="3">
																				<v-btn-toggle group>
																					<v-btn class="primary--text"  v-if="!checkLessonNames(lesson)" :loading="curriculum.update_lesson_loading" @click="updateLesson(section_index, lesson)" text>Guardar</v-btn>
																					<v-btn text>
																						<v-icon>mdi-menu</v-icon>
																					</v-btn>
																					<v-btn @click="openLessonDialog(section_index, lesson)" text>
																						<v-icon color="primary">mdi-pencil-box</v-icon>
																					</v-btn>
																					<v-btn text>
																						<v-icon color="red" @click="removeLesson(section_index, lesson)">mdi-delete</v-icon>
																					</v-btn>
																				</v-btn-toggle>
																			</v-col>
																			<v-col cols="12">
																				<v-text-field v-model="lesson.lesson_name" class="mt-3 fl-text-input" placeholder="Înregistrare de la clase" @click.native.stop filled rounded dense :disabled="curriculum.add_loading"></v-text-field>
																			</v-col>
																			<v-col cols="12" md="6" v-if="instructors.items.length > 0">
																				<v-select class="v-normal-input" v-model="lesson.user_id" label="Profesor encargado" :items="instructors.items" @change="lesson.old_lesson_name += ' '" item-value="user_id" clearable dense>
																				</v-select>
																			</v-col>
																		</v-row>
																</v-row>
															</draggable>
														</v-expansion-panel-content>
													</v-expansion-panel>
												</draggable>
											</v-expansion-panels>
						    		</v-col>						    	
						    	</v-row>
						    	<?php echo new Controller\Template('course/edit/parts/lesson_form') ?>

						    	